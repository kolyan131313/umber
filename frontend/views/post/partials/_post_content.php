<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use \yii\helpers\Html;

?>
<div class="row post-content">
    <div class="col-md-3">
        <a href="<?php echo Url::to(['post/' . $model->id])?>">
            <?php echo Html::img($model->getImagePath(true), ['class' => 'img-responsive']) ?>
        </a>
    </div>
    <div class="col-md-9">
        <?php echo (isset($all) && !empty($all) ? $model->text : $model->description); ?>
        <?php if(!isset($all) || empty($all)) { ?>
            <p>
                <?php echo Html::a('Read more', ['post/' . $model->id], ['class' => 'btn btn-read-more']); ?>
            </p>
        <?php } ?>
    </div>
</div>