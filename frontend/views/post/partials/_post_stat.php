<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12 post-header-line">
        <span class="glyphicon glyphicon-user"></span>
        by
        <a href="#"><?php echo isset($model->authorCreated) && !empty($model->authorCreated) ? $model->authorCreated->username : ''; ?></a> |
        <span class="glyphicon glyphicon-calendar"></span><?php echo Yii::$app->formatter->asDate($model->date_created); ?> |
        <span class="glyphicon glyphicon-refresh"></span><?php echo Yii::$app->formatter->asDate($model->date_created); ?> |
        <span class="glyphicon glyphicon-folder-open"></span>
        Categories :
        <?php if (isset($model->categoryList) && !empty($model->categoryList) && is_array($model->categoryList)) { ?>
            <?php foreach ($model->categoryList as $category) { ?>
                <?php if(!$category->unvisible) { ?>
                    <a href="<?php echo Url::to(['posts/' . $category->url])?>">
                        <span class="label label-info"><?php echo $category->title; ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>