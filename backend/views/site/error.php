<?php
use yii\helpers\Html;

$this->title = $name;
?>

<div class="card">
    <h1 style="color: #e74c3c; margin-bottom: 1rem;"><?= Html::encode($name) ?></h1>
    <p style="font-size: 1.125rem; color: #7f8c8d; margin-bottom: 2rem;">
        <?= nl2br(Html::encode($message)) ?>
    </p>

    <?php if (YII_DEBUG && !empty($exception)): ?>
        <div style="background: #ecf0f1; padding: 1.5rem; border-radius: 4px; margin-top: 2rem;">
            <h3 style="margin-bottom: 1rem; color: #2c3e50;">Debug Information:</h3>
            <p style="font-family: monospace; font-size: 0.875rem; color: #34495e; line-height: 1.6;">
                <?= nl2br(Html::encode($exception)) ?>
            </p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="/admin/" class="btn">Volver al Dashboard</a>
    </div>
</div>
