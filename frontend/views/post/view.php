<?php
/* @var $this yii\web\View */
use common\widgets\CategoryList;

$this->title = 'Umber';
?>
<div class="site-index">
    <div class="body-content">
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