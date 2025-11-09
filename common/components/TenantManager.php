<?php

namespace common\components;

use common\models\Account;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;

/**
 * TenantManager - Componente para gestionar el contexto de multitenencia
 *
 * Este componente detecta y mantiene el tenant activo durante la petición.
 * Soporta detección por subdominio, header HTTP o parámetro de query/post.
 *
 * @property-read Account|null $tenant
 * @property-read int|null $tenantId
 */
class TenantManager extends Component
{
    /**
     * @var Account|null Tenant activo en el contexto actual
     */
    private ?Account $_tenant = null;

    /**
     * @var int|null ID del tenant activo
     */
    private ?int $_tenantId = null;

    /**
     * @var bool Indica si el tenant ha sido detectado
     */
    private bool $_detected = false;

    /**
     * @var string Método de detección: 'subdomain', 'header', 'parameter'
     */
    public string $detectionMethod = 'subdomain';

    /**
     * @var string Nombre del header HTTP para detección
     */
    public string $headerName = 'X-Tenant-Id';

    /**
     * @var string Nombre del parámetro para detección
     */
    public string $parameterName = 'tenant_id';

    /**
     * @var int Tiempo de caché en segundos
     */
    public int $cacheTimeout = 3600;

    /**
     * @var bool Permitir acceso sin tenant (para rutas públicas)
     */
    public bool $allowNoTenant = false;

    /**
     * Inicialización del componente
     */
    public function init(): void
    {
        parent::init();

        // Cargar configuración desde params
        $params = Yii::$app->params['tenant'] ?? [];
        $this->detectionMethod = $params['detectionMethod'] ?? $this->detectionMethod;
        $this->headerName = $params['headerName'] ?? $this->headerName;
        $this->parameterName = $params['parameterName'] ?? $this->parameterName;
        $this->cacheTimeout = $params['cacheTimeout'] ?? $this->cacheTimeout;
    }

    /**
     * Detecta el tenant actual basándose en el método configurado
     *
     * @return bool True si se detectó un tenant, false en caso contrario
     * @throws InvalidConfigException
     */
    public function detect(): bool
    {
        if ($this->_detected) {
            return $this->_tenantId !== null;
        }

        $this->_detected = true;

        $identifier = match ($this->detectionMethod) {
            'subdomain' => $this->detectBySubdomain(),
            'header' => $this->detectByHeader(),
            'parameter' => $this->detectByParameter(),
            default => throw new InvalidConfigException("Invalid detection method: {$this->detectionMethod}"),
        };

        if ($identifier === null) {
            return false;
        }

        // Buscar tenant en caché o base de datos
        $this->loadTenant($identifier);

        return $this->_tenantId !== null;
    }

    /**
     * Detecta el tenant por subdominio
     *
     * @return string|null Subdominio detectado
     */
    protected function detectBySubdomain(): ?string
    {
        if (!Yii::$app->has('request')) {
            return null;
        }

        $host = Yii::$app->request->getHostName();
        $parts = explode('.', $host);

        // Si tiene al menos 3 partes (subdomain.domain.com), extraer subdominio
        if (count($parts) >= 3) {
            return $parts[0];
        }

        return null;
    }

    /**
     * Detecta el tenant por header HTTP
     *
     * @return string|null ID del tenant desde el header
     */
    protected function detectByHeader(): ?string
    {
        if (!Yii::$app->has('request')) {
            return null;
        }

        $value = Yii::$app->request->headers->get($this->headerName);

        return $value !== null ? (string) $value : null;
    }

    /**
     * Detecta el tenant por parámetro de query/post
     *
     * @return string|null ID del tenant desde parámetro
     */
    protected function detectByParameter(): ?string
    {
        if (!Yii::$app->has('request')) {
            return null;
        }

        $value = Yii::$app->request->get($this->parameterName)
            ?? Yii::$app->request->post($this->parameterName);

        return $value !== null ? (string) $value : null;
    }

    /**
     * Carga el tenant desde caché o base de datos
     *
     * @param string $identifier Identificador del tenant (subdomain o ID)
     */
    protected function loadTenant(string $identifier): void
    {
        $cacheKey = "tenant:{$this->detectionMethod}:{$identifier}";

        // Intentar obtener de caché
        $tenantData = Yii::$app->cache->get($cacheKey);

        if ($tenantData === false) {
            // No está en caché, buscar en base de datos
            $query = Account::find();

            if ($this->detectionMethod === 'subdomain') {
                $query->where(['subdomain' => $identifier]);
            } else {
                $query->where(['tenant_id' => (int) $identifier]);
            }

            $tenant = $query
                ->andWhere(['IN', 'status', [Account::STATUS_TRIAL, Account::STATUS_ACTIVE]])
                ->one();

            if ($tenant === null) {
                return;
            }

            // Guardar en caché
            $tenantData = [
                'tenant_id' => $tenant->tenant_id,
                'fiscal_name' => $tenant->fiscal_name,
                'subdomain' => $tenant->subdomain,
                'status' => $tenant->status,
                'settings' => $tenant->account_settings,
            ];

            Yii::$app->cache->set($cacheKey, $tenantData, $this->cacheTimeout);

            $this->_tenant = $tenant;
        } else {
            // Reconstruir objeto Account desde caché
            $this->_tenant = new Account();
            $this->_tenant->setAttributes($tenantData, false);
        }

        $this->_tenantId = $this->_tenant->tenant_id;
    }

    /**
     * Establece manualmente el tenant actual
     *
     * @param Account|int $tenant Objeto Account o ID del tenant
     * @throws InvalidConfigException
     */
    public function setTenant(Account|int $tenant): void
    {
        if ($tenant instanceof Account) {
            $this->_tenant = $tenant;
            $this->_tenantId = $tenant->tenant_id;
        } else {
            $this->_tenantId = $tenant;
            $this->_tenant = Account::findOne($tenant);

            if ($this->_tenant === null) {
                throw new InvalidConfigException("Tenant with ID {$tenant} not found");
            }
        }

        $this->_detected = true;
    }

    /**
     * Obtiene el tenant actual
     *
     * @return Account|null
     */
    public function getTenant(): ?Account
    {
        if (!$this->_detected) {
            $this->detect();
        }

        return $this->_tenant;
    }

    /**
     * Obtiene el ID del tenant actual
     *
     * @return int|null
     */
    public function getTenantId(): ?int
    {
        if (!$this->_detected) {
            $this->detect();
        }

        return $this->_tenantId;
    }

    /**
     * Verifica si hay un tenant activo
     *
     * @return bool
     */
    public function hasTenant(): bool
    {
        return $this->getTenantId() !== null;
    }

    /**
     * Limpia el caché del tenant actual
     */
    public function clearCache(): void
    {
        if ($this->_tenant !== null) {
            $cacheKey = "tenant:{$this->detectionMethod}:";

            if ($this->detectionMethod === 'subdomain') {
                $cacheKey .= $this->_tenant->subdomain;
            } else {
                $cacheKey .= $this->_tenantId;
            }

            Yii::$app->cache->delete($cacheKey);
        }
    }

    /**
     * Reinicia el estado del manager
     */
    public function reset(): void
    {
        $this->_tenant = null;
        $this->_tenantId = null;
        $this->_detected = false;
    }
}
