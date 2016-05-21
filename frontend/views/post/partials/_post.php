<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Show Post';
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="row">
    <div class="col-md-12 post">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    <strong>
                        <?php echo Html::a($model->title, ['post' . $model->id], ['class' => 'post-title']); ?>
                    </strong>
                </h4>
            </div>
        </div>
        <?php echo $this->render('_post_stat', ['model' => $model]); ?>
        <?php echo $this->render('_post_content', ['model' => $model, 'all' => true]); ?>
    </div>
</div>