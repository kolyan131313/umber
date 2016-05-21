<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Category;
use \kartik\file\FileInput;

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'categories')->widget(Select2::classname(), [
        'data'          => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
        'options'       => ['placeholder' => 'Select a category ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple'   => true
        ],
    ]); ?>

    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg','gif','png']
        ]
    ]); ?>

    <?php echo $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'standard',
            'inline' => false
        ],
    ]); ?>
    <?php echo $form->field($model, 'unvisible')->checkbox()->label(false); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
