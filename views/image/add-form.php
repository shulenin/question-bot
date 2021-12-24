<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<br>
<br>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?php if (Yii::$app->session->getFlash('success')): ?>
        <p>Данные формы прошли валидацию</p>
    <?php else: ?>
        <p>Данные формы не прошли валидацию</p>
    <?php endif; ?>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'name')?>
<?= $form->field($model, 'img')->fileInput() ?>

<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

<br>
<br>

<?php foreach ($array as $item): ?>
    <p><?php echo $item->id ?>. <b><?php echo $item->name ?></b></p>
    <img src="/uploads/<?= $item->img?>" alt="" width="300">
<?php endforeach ?>

