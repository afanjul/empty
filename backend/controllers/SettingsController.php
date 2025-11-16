<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * Settings controller
 */
class SettingsController extends Controller
{
    /**
     * Application settings
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
