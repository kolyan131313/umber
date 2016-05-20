<?php
/* @var $this yii\web\View */
use \yii\widgets\ListView;
use \common\widgets\CategoryList;

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
                'itemView'     => function ($model) {
                    return $this->render('partials/_post_list_item', ['model' => $model]);
                },
                'itemOptions'  => [
                    'tag' => false,
                ],
                'summary'      => '',
                'layout'       => '{items}{pager}',
                'pager'        => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel'  => 'Last',
                    'maxButtonCount' => 4,
                    'options'        => [
                        'class' => 'pagination text-center'
                    ]
                ],

            ]);
            ?>

            <?php echo CategoryList::widget(['limit' => 10]) ?>
        </div>

    </div>
</div>
