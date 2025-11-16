<?php

namespace backend\controllers;

use Yii;
use common\models\Document;
use backend\models\DocumentForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Document models.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Document::find()->where(['deleted_at' => null])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Document model.
     */
    public function actionCreate()
    {
        $model = new DocumentForm();
        $model->status = Document::STATUS_DRAFT;
        $model->document_type_id = Document::TYPE_INVOICE;
        $model->issue_date = date('Y-m-d');
        $model->base_currency_id = 'EUR';
        $model->document_currency_id = 'EUR';
        $model->exchange_rate = 1.0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Documento creado correctamente.');
            return $this->redirect(['view', 'id' => $model->document_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Document model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model->canBeEdited()) {
            Yii::$app->session->setFlash('error', 'Este documento no puede ser editado.');
            return $this->redirect(['view', 'id' => $model->document_id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Documento actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->document_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Document model.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->isApproved()) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar un documento aprobado.');
            return $this->redirect(['index']);
        }

        $model->deleted_at = date('Y-m-d H:i:s');
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Documento eliminado correctamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Document model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El documento solicitado no existe.');
    }
}
