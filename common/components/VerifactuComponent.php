<?php

namespace common\components;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\base\Component;
use yii\base\InvalidArgumentException;

/**
 * VerifactuComponent - Componente para gestionar Verifactu
 *
 * Proporciona funcionalidades para:
 * - Generación de hash encadenado (HMAC-SHA256)
 * - Generación de código QR
 * - Firma electrónica de registros
 * - Validación de estructura Verifactu
 */
class VerifactuComponent extends Component
{
    /**
     * @var string Versión de Verifactu
     */
    public string $version = '1.0';

    /**
     * @var string Algoritmo de hash
     */
    public string $hashAlgorithm = 'sha256';

    /**
     * @var int Tamaño del código QR
     */
    public int $qrCodeSize = 300;

    /**
     * @var string URL base de verificación de AEAT
     */
    public string $aeatVerificationUrl = 'https://prewww1.aeat.es/wlpl/TIKE-CONT/ValidarQR';

    /**
     * Genera el hash de un registro de facturación Verifactu
     *
     * El hash se calcula sobre los siguientes campos concatenados:
     * - IDEmisorFactura (NIF)
     * - NumSerieFactura
     * - FechaExpedicionFactura (dd-mm-yyyy)
     * - TipoFactura
     * - CuotaTotal (12,2)
     * - ImporteTotal (12,2)
     * - Huella del registro anterior (si no es el primero)
     *
     * @param array $data Datos del registro
     * @param string|null $previousHash Hash del registro anterior
     * @return string Hash calculado (64 caracteres)
     */
    public function generateHash(array $data, ?string $previousHash = null): string
    {
        // Validar campos obligatorios
        $required = ['issuer_nif', 'invoice_number', 'issue_date', 'invoice_type', 'total_tax', 'total_amount'];

        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new InvalidArgumentException("Campo obligatorio '{$field}' no proporcionado para generar hash");
            }
        }

        // Preparar campos para hash
        $issuerNif = $this->normalizeNif($data['issuer_nif']);
        $invoiceNumber = trim($data['invoice_number']);
        $issueDate = $this->formatDate($data['issue_date']);
        $invoiceType = $data['invoice_type'];
        $totalTax = $this->formatDecimal($data['total_tax'], 12, 2);
        $totalAmount = $this->formatDecimal($data['total_amount'], 12, 2);

        // Construir cadena para hash
        $hashString = implode('', [
            $issuerNif,
            $invoiceNumber,
            $issueDate,
            $invoiceType,
            $totalTax,
            $totalAmount,
        ]);

        // Si hay hash anterior, agregarlo
        if ($previousHash !== null) {
            // Usar solo los primeros 64 caracteres del hash anterior
            $hashString .= substr($previousHash, 0, 64);
        }

        // Calcular hash HMAC-SHA256
        // Nota: La clave secreta debe estar configurada por tenant
        $secretKey = $this->getSecretKey();
        $hash = hash_hmac($this->hashAlgorithm, $hashString, $secretKey);

        Yii::info("Hash generado para factura {$invoiceNumber}: {$hash}", __METHOD__);

        return $hash;
    }

    /**
     * Genera el código QR para una factura Verifactu
     *
     * El QR contiene una URL con parámetros que permiten verificar la factura en AEAT
     *
     * @param array $data Datos para el QR
     * @return string Contenido del QR (URL)
     */
    public function generateQRCode(array $data): string
    {
        // Validar campos obligatorios
        $required = ['issuer_nif', 'invoice_number', 'issue_date', 'total_amount'];

        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new InvalidArgumentException("Campo obligatorio '{$field}' no proporcionado para generar QR");
            }
        }

        // Construir URL del QR
        $params = [
            'nif' => $this->normalizeNif($data['issuer_nif']),
            'num' => trim($data['invoice_number']),
            'fecha' => $this->formatDate($data['issue_date']),
            'importe' => $this->formatDecimal($data['total_amount'], 12, 2),
        ];

        $qrUrl = $this->aeatVerificationUrl . '?' . http_build_query($params);

        Yii::info("QR generado: {$qrUrl}", __METHOD__);

        return $qrUrl;
    }

    /**
     * Genera la imagen del código QR
     *
     * @param string $qrContent Contenido del QR (URL)
     * @param string|null $outputPath Ruta donde guardar la imagen (null para devolver el contenido)
     * @return string|null Contenido de la imagen o null si se guardó en archivo
     */
    public function generateQRImage(string $qrContent, ?string $outputPath = null): ?string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrContent)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size($this->qrCodeSize)
            ->margin(10)
            ->build();

        if ($outputPath !== null) {
            $result->saveToFile($outputPath);
            return null;
        }

        return $result->getString();
    }

    /**
     * Firma un registro de facturación con certificado digital
     *
     * @param string $content Contenido XML a firmar
     * @param string $certificatePem Certificado en formato PEM
     * @param string $privateKeyPem Clave privada en formato PEM
     * @param string|null $passphrase Passphrase de la clave privada
     * @return string Firma electrónica XAdES
     */
    public function signRecord(string $content, string $certificatePem, string $privateKeyPem, ?string $passphrase = null): string
    {
        // Cargar la clave privada
        $privateKey = openssl_pkey_get_private($privateKeyPem, $passphrase ?? '');

        if ($privateKey === false) {
            throw new \RuntimeException('No se pudo cargar la clave privada: ' . openssl_error_string());
        }

        // Firmar el contenido
        $signature = '';
        $success = openssl_sign($content, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$success) {
            throw new \RuntimeException('Error al firmar el contenido: ' . openssl_error_string());
        }

        // Codificar la firma en base64
        $signatureBase64 = base64_encode($signature);

        // Liberar recursos
        openssl_free_key($privateKey);

        Yii::info("Registro firmado correctamente", __METHOD__);

        return $signatureBase64;
    }

    /**
     * Verifica una firma electrónica
     *
     * @param string $content Contenido original
     * @param string $signature Firma en base64
     * @param string $certificatePem Certificado en formato PEM
     * @return bool True si la firma es válida
     */
    public function verifySignature(string $content, string $signature, string $certificatePem): bool
    {
        $publicKey = openssl_pkey_get_public($certificatePem);

        if ($publicKey === false) {
            throw new \RuntimeException('No se pudo cargar el certificado: ' . openssl_error_string());
        }

        $signatureBinary = base64_decode($signature);
        $result = openssl_verify($content, $signatureBinary, $publicKey, OPENSSL_ALGO_SHA256);

        openssl_free_key($publicKey);

        return $result === 1;
    }

    /**
     * Normaliza un NIF/CIF español
     *
     * @param string $nif
     * @return string NIF normalizado (mayúsculas, sin espacios)
     */
    protected function normalizeNif(string $nif): string
    {
        return strtoupper(trim(str_replace([' ', '-', '.'], '', $nif)));
    }

    /**
     * Formatea una fecha para Verifactu (dd-mm-yyyy)
     *
     * @param string|\DateTime $date
     * @return string Fecha formateada
     */
    protected function formatDate(string|\DateTime $date): string
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        return $date->format('d-m-Y');
    }

    /**
     * Formatea un decimal para Verifactu
     *
     * @param float|string $value Valor a formatear
     * @param int $totalDigits Total de dígitos (incluyendo decimales)
     * @param int $decimalPlaces Número de decimales
     * @return string Valor formateado
     */
    protected function formatDecimal(float|string $value, int $totalDigits, int $decimalPlaces): string
    {
        $formatted = number_format((float) $value, $decimalPlaces, '.', '');

        // Rellenar con ceros a la izquierda si es necesario
        $integerPart = explode('.', $formatted)[0];
        $decimalPart = explode('.', $formatted)[1] ?? str_repeat('0', $decimalPlaces);

        $integerDigits = $totalDigits - $decimalPlaces - 1; // -1 por el punto decimal
        $integerPart = str_pad($integerPart, $integerDigits, '0', STR_PAD_LEFT);

        return $integerPart . $decimalPart;
    }

    /**
     * Obtiene la clave secreta para HMAC del tenant actual
     *
     * @return string
     */
    protected function getSecretKey(): string
    {
        // En producción, esto debería obtenerse de la configuración del tenant
        // y estar cifrado en la base de datos
        if (Yii::$app->has('tenantManager')) {
            $tenant = Yii::$app->tenantManager->getTenant();

            if ($tenant !== null) {
                $settings = $tenant->getVerifactuSettings();

                if (isset($settings['secret_key'])) {
                    return $settings['secret_key'];
                }
            }
        }

        // Fallback: usar una clave del archivo de configuración
        return Yii::$app->params['verifactu']['secretKey'] ?? 'default-secret-key-CHANGE-IN-PRODUCTION';
    }

    /**
     * Valida la estructura de un registro de facturación Verifactu
     *
     * @param array $data Datos del registro
     * @return array Array de errores (vacío si válido)
     */
    public function validateRecord(array $data): array
    {
        $errors = [];

        // Campos obligatorios
        $required = [
            'version' => 'Versión',
            'issuer_nif' => 'NIF Emisor',
            'invoice_number' => 'Número de Factura',
            'issue_date' => 'Fecha de Expedición',
            'invoice_type' => 'Tipo de Factura',
            'total_tax' => 'Cuota Total',
            'total_amount' => 'Importe Total',
            'hash' => 'Huella/Hash',
            'generated_at' => 'Fecha de Generación',
        ];

        foreach ($required as $field => $label) {
            if (!isset($data[$field]) || $data[$field] === null || $data[$field] === '') {
                $errors[] = "Campo obligatorio '{$label}' no proporcionado";
            }
        }

        // Validar formato NIF
        if (isset($data['issuer_nif']) && !preg_match('/^[XYZ0-9][0-9]{7}[A-Z0-9]$/', strtoupper($data['issuer_nif']))) {
            $errors[] = 'El formato del NIF emisor no es válido';
        }

        // Validar tipo de factura
        $validTypes = ['F1', 'F2', 'F3', 'R1', 'R2', 'R3', 'R4', 'R5'];
        if (isset($data['invoice_type']) && !in_array($data['invoice_type'], $validTypes)) {
            $errors[] = 'Tipo de factura no válido';
        }

        // Validar hash
        if (isset($data['hash']) && strlen($data['hash']) !== 64) {
            $errors[] = 'El hash debe tener 64 caracteres';
        }

        return $errors;
    }
}
