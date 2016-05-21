<?php
/* @var $this yii\web\View */
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-12 post">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    <strong>
                        <a href="<?php echo Url::to(['post/' . $model->id]) ?>" class="post-title"><?php echo $model->title; ?></a>
                    </strong>
                </h4>
            </div>
        </div>
        <?php echo $this->render('_post_content', ['model' => $model, 'all' => true]); ?>
        <?php echo $this->render('_post_stat', ['model' => $model]); ?>
    </div>
</div>