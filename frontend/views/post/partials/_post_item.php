<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12 post">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    <strong>
                        <a href="<?php echo Url::to(['post/' . $model->id])?>" class="post-title"><?php echo $model->title; ?></a>
                        <?php if(isset($model->authorCreated) && isset($loggedUser->id) && $model->authorCreated->id === $loggedUser->id) { ?>
                            <?php echo Html::a('update', ['post/create'], ['class' => 'btn btn-xs btn-primary']); ?>
                        <?php } ?>
                    </strong>
                </h4>
            </div>
        </div>
        <?php echo $this->render('_post_stat',['model' => $model]); ?>
        <?php echo $this->render('_post_content',['model' => $model]); ?>
    </div>
</div>