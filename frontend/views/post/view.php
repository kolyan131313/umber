<?php
/* @var $this yii\web\View */
use common\widgets\CategoryList;
use yii\helpers\Html;

$this->title = 'Umber';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-3">
                <ul class="pager">
                    <li class="previous">
                        <?php echo Html::a('Back', Yii::$app->request->referrer, ['class' => 'glyphicon glyphicon-chevron-left']); ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <?php echo $this->render('partials/_post', ['model' => $model]); ?>
            </div>
            <?php echo CategoryList::widget([
                'limit'      => 10,
                'loggedUser' => $loggedUser
            ]) ?>
        </div>

    </div>
</div>