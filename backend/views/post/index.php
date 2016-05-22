<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description',
            [
                'attribute' => 'categories',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    return $model->categoryToString();
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    return $model->authorCreated->username;
                }
            ],
            [
                'attribute' => 'moderated',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    return array_key_exists($model->moderated, $model->getStatuses()) ? $model->getStatuses()[$model->moderated] : '';
                }
            ],
            [
                'attribute' => 'unvisible',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    return $model->unvisible ? 'Hide' : '';
                }
            ],
            'date_created:datetime',
            'date_modified:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
