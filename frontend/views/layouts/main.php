<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title ?? 'Facturacheck') ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8f9fa; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 2rem; text-align: center; }
        .header h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        .header p { font-size: 1.125rem; opacity: 0.9; }
        .nav { background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 0 2rem; position: sticky; top: 0; z-index: 100; }
        .nav ul { list-style: none; display: flex; gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .nav a { color: #333; text-decoration: none; padding: 1rem 0; display: block; font-weight: 500; transition: color 0.2s; }
        .nav a:hover { color: #667eea; }
        .container { max-width: 1200px; margin: 3rem auto; padding: 0 2rem; }
        .hero { background: white; border-radius: 12px; padding: 3rem; box-shadow: 0 4px 6px rgba(0,0,0,0.07); margin-bottom: 2rem; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .feature { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.07); }
        .feature h3 { color: #667eea; margin-bottom: 1rem; font-size: 1.25rem; }
        .feature p { color: #6c757d; line-height: 1.6; }
        .btn { display: inline-block; padding: 1rem 2rem; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.2s; }
        .btn:hover { background: #5568d3; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102,126,234,0.4); }
        .footer { text-align: center; padding: 3rem 2rem; color: #6c757d; background: white; margin-top: 4rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facturacheck</h1>
        <p>Plataforma SaaS de Facturación Electrónica con Verifactu</p>
    </div>
    <nav class="nav">
        <ul>
            <li><a href="/">Inicio</a></li>
            <li><a href="/features">Características</a></li>
            <li><a href="/pricing">Precios</a></li>
            <li><a href="/contact">Contacto</a></li>
            <li><a href="/admin">Admin</a></li>
        </ul>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Facturacheck - Facturación Electrónica Profesional
    </div>
</body>
</html>
