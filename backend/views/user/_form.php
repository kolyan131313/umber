<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'username')->textInput(); ?>

    <?php echo $form->field($model, 'email')->textInput(); ?>
    <?php if($model->isNewRecord) { ?>
        <?php echo $form->field($model, 'password')->passwordInput()->label('Password'); ?>
    <?php } ?>
    <?php echo $form->field($model, 'role')->widget(Select2::classname(), [
        'data'          => ArrayHelper::map(AuthItem::find()->all(), 'name', 'description'),
        'options'       => ['placeholder' => 'Select a category ...'],
        'pluginOptions' => [
            'allowClear' => false,
            'multiple'   => false
        ],
    ]); ?>

    <?php echo $form->field($model, 'ban')->checkbox()->label(false); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
