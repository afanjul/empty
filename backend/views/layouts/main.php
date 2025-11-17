<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title ?? 'Facturacheck Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f5f5f5; }
        .header { background: #2c3e50; color: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { font-size: 1.5rem; font-weight: 600; }
        .header p { font-size: 0.9rem; opacity: 0.8; margin-top: 0.25rem; }
        .nav { background: #34495e; padding: 0 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav ul { list-style: none; display: flex; gap: 2rem; }
        .nav a { color: white; text-decoration: none; padding: 1rem 0; display: block; opacity: 0.8; transition: opacity 0.2s; }
        .nav a:hover { opacity: 1; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }
        .card { background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #3498db; }
        .stat-card h3 { color: #7f8c8d; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; }
        .stat-card .value { font-size: 2rem; font-weight: 700; color: #2c3e50; }
        .btn { display: inline-block; padding: 0.75rem 1.5rem; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-weight: 500; transition: background 0.2s; }
        .btn:hover { background: #2980b9; }
        .footer { text-align: center; padding: 2rem; color: #7f8c8d; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facturacheck Admin Panel</h1>
        <p>Sistema de gestión de facturación electrónica</p>
    </div>
    <nav class="nav">
        <ul>
            <li><a href="/admin/">Dashboard</a></li>
            <li><a href="/admin/account">Cuentas</a></li>
            <li><a href="/admin/user">Usuarios</a></li>
            <li><a href="/admin/contact">Contactos</a></li>
            <li><a href="/admin/document">Documentos</a></li>
            <li style="margin-left: auto;"><a href="/admin/site/logout" data-method="post">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Facturacheck - Powered by Yii Framework
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
