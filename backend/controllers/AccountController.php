<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * Account controller
 */
class AccountController extends Controller
{
    /**
     * Lists all accounts
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creates a new account
     */
    public function actionCreate()
    {
        return $this->render('create');
    }
}
