<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'title',
            'description',
            [
                'attribute' => 'created_by',
                'value'     => $model->authorCreated->username
            ],
            [
                'attribute' => 'moderated',
                'value'     => array_key_exists($model->moderated, $model->getStatuses()) ? $model->getStatuses()[$model->moderated] : ''
            ],
            [
                'attribute' => 'unvisible',
                'value'     => $model->unvisible ? 'Hide' : ''
            ],
            [
                'attribute' => 'categories',
                'value'     => $model->categoryToString()
            ],
            'date_created:datetime',
            'date_modified:datetime',
        ],
    ]) ?>

</div>
