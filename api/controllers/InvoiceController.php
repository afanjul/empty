<?php

namespace api\controllers;

use common\interfaces\InvoiceServiceInterface;
use common\requests\CreateInvoiceRequest;
use common\requests\UpdateInvoiceRequest;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * InvoiceController - API REST para facturas
 */
class InvoiceController extends ApiBaseController
{
    private InvoiceServiceInterface $invoiceService;

    public function __construct($id, $module, InvoiceServiceInterface $invoiceService = null, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->invoiceService = $invoiceService ?? Yii::$container->get(InvoiceServiceInterface::class);
    }

    /**
     * Lista de facturas
     *
     * GET /api/invoice
     */
    public function actionIndex(): array
    {
        try {
            $filters = Yii::$app->request->get();
            $page = (int) (Yii::$app->request->get('page', 1));
            $pageSize = (int) (Yii::$app->request->get('page_size', 20));

            $result = $this->invoiceService->listInvoices($filters, $page, $pageSize);

            return $this->success($result);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al listar facturas: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Obtener factura por ID
     *
     * GET /api/invoice/{id}
     */
    public function actionView(int $id): array
    {
        try {
            $invoice = $this->invoiceService->getInvoice($id);

            if ($invoice === null) {
                throw new NotFoundHttpException('Factura no encontrada');
            }

            return $this->success($invoice->toArray());
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al obtener factura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Crear factura
     *
     * POST /api/invoice
     */
    public function actionCreate(): array
    {
        try {
            $request = new CreateInvoiceRequest();
            $request->load(Yii::$app->request->bodyParams, '');

            if (!$request->validate()) {
                return $this->error('Datos de entrada inválidos', 400, $request->errors);
            }

            $invoice = $this->invoiceService->createInvoice($request->attributes);

            return $this->success($invoice->toArray(), 'Factura creada exitosamente', 201);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al crear factura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Actualizar factura
     *
     * PUT /api/invoice/{id}
     */
    public function actionUpdate(int $id): array
    {
        try {
            $request = new UpdateInvoiceRequest();
            $request->load(Yii::$app->request->bodyParams, '');

            if (!$request->validate()) {
                return $this->error('Datos de entrada inválidos', 400, $request->errors);
            }

            $invoice = $this->invoiceService->updateInvoice($id, $request->attributes);

            return $this->success($invoice->toArray(), 'Factura actualizada exitosamente');
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al actualizar factura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Eliminar factura
     *
     * DELETE /api/invoice/{id}
     */
    public function actionDelete(int $id): array
    {
        try {
            $this->invoiceService->deleteInvoice($id);

            return $this->success(null, 'Factura eliminada exitosamente');
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al eliminar factura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Aprobar factura
     *
     * POST /api/invoice/{id}/approve
     */
    public function actionApprove(int $id): array
    {
        try {
            $invoice = $this->invoiceService->approveInvoice($id);

            return $this->success($invoice->toArray(), 'Factura aprobada y registro Verifactu generado');
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al aprobar factura: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Generar PDF
     *
     * GET /api/invoice/{id}/pdf
     */
    public function actionPdf(int $id): array
    {
        try {
            $pdfPath = $this->invoiceService->generatePDF($id);

            return $this->success(['pdf_path' => $pdfPath]);
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al generar PDF: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Enviar por email
     *
     * POST /api/invoice/{id}/send-email
     */
    public function actionSendEmail(int $id): array
    {
        try {
            $email = Yii::$app->request->post('email');
            $this->invoiceService->sendByEmail($id, $email);

            return $this->success(null, 'Factura enviada por email exitosamente');
        } catch (NotFoundHttpException $e) {
            return $this->error($e->getMessage(), 404);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->error('Error al enviar factura: ' . $e->getMessage(), 500);
        }
    }
}
