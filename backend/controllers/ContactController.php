<?php

namespace backend\controllers;

use Yii;
use common\models\Contact;
use backend\models\ContactForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
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
     * Lists all Contact models.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Contact::find()->where(['deleted_at' => null])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contact model.
     */
    public function actionCreate()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Contacto creado correctamente.');
            return $this->redirect(['view', 'id' => $model->contact_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Contacto actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->contact_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contact model.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Contacto eliminado correctamente.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El contacto solicitado no existe.');
    }
}
