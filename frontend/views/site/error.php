<?php
use yii\helpers\Html;

$this->title = $name;
?>

<div class="hero" style="text-align: center;">
    <h1 style="color: #e74c3c; margin-bottom: 1rem; font-size: 3rem;"><?= Html::encode($name) ?></h1>
    <p style="font-size: 1.25rem; color: #6c757d; margin-bottom: 2rem;">
        <?= nl2br(Html::encode($message)) ?>
    </p>

    <?php if (YII_DEBUG && !empty($exception)): ?>
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-top: 2rem; text-align: left;">
            <h3 style="margin-bottom: 1rem;">Debug Information:</h3>
            <pre style="overflow-x: auto; font-size: 0.875rem; line-height: 1.6;">
<?= Html::encode($exception) ?>
            </pre>
        </div>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="/" class="btn">Volver a Inicio</a>
    </div>
</div>
