<?php

namespace api\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\rest\Controller;
use yii\web\Response;

/**
 * ApiBaseController - Clase base para todos los controladores API
 */
class ApiBaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        // CORS
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        // Content Negotiation
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        // Rate Limiting
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::class,
            'enableRateLimitHeaders' => true,
        ];

        return $behaviors;
    }

    /**
     * Respuesta de éxito estándar
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return array
     */
    protected function success($data = null, ?string $message = null, int $code = 200): array
    {
        Yii::$app->response->statusCode = $code;

        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Respuesta de error estándar
     *
     * @param string $message
     * @param int $code
     * @param mixed $errors
     * @return array
     */
    protected function error(string $message, int $code = 400, $errors = null): array
    {
        Yii::$app->response->statusCode = $code;

        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }

    /**
     * Manejo de excepciones
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        // Log API calls
        if (Yii::$app->user->id) {
            Yii::info(sprintf(
                'API Call: %s %s by user %d',
                Yii::$app->request->method,
                Yii::$app->request->url,
                Yii::$app->user->id
            ), __METHOD__);
        }

        return $result;
    }
}
