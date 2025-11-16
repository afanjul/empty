<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * Document controller
 */
class DocumentController extends Controller
{
    /**
     * Lists all documents
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
