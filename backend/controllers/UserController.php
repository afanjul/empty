<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * Lists all users
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creates a new user
     */
    public function actionCreate()
    {
        return $this->render('create');
    }
}
