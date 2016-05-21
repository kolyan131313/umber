<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use common\widgets\CategoryList;

$this->title = 'Umber';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php echo ListView::widget([
                'options'      => [
                    'tag'   => 'div',
                    'class' => 'col-md-9'
                ],
                'dataProvider' => $listDataProvider,
                'itemView'     => function ($model) use ($loggedUser) {
                    return $this->render('partials/_post_item', [
                        'model'      => $model,
                        'loggedUser' => $loggedUser
                    ]);
                },
                'itemOptions'  => [
                    'tag' => false,
                ],
                'summary'      => '',
                'emptyText'    => "<h1 align='center'>Posts haven't been added yet:(</h1>",
                'layout'       => "{items}<div align='center'>{pager}</div>",
                'pager'        => [
                    'maxButtonCount' => 4,
                    'options'        => [
                        'class' => 'pagination'
                    ]
                ],

            ]);
            ?>

            <?php echo CategoryList::widget([
                'limit'      => 10,
                'loggedUser' => $loggedUser
            ]) ?>
        </div>

    </div>
</div>
