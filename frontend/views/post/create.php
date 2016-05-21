<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="post-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo  $this->render('partials/_form', [
        'model' => $model,
    ]) ?>

</div>
