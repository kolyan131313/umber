<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="col-lg-3">
    <div class="menu-category list-group ">
        <div class="menu-category-name list-group-item active">Category</div>
        <?php if (isset($categories) && !empty($categories) && is_array($categories)) { ?>
            <?php foreach ($categories as $category) { ?>
                <a href="<?php echo Url::to(['posts/' . $category->url]) ?>" class="menu-item list-group-item">
                    <?php echo $category->title; ?>
                    <span class="badge"><?php echo(isset($cntPosts[$category->id]) ? $cntPosts[$category->id] : '0'); ?></span>
                </a>
            <?php } ?>
        <?php } else { ?>
            <?php echo Html::a("Categories haven't been added :(", ['#'], ['class' => 'menu-item list-group-item']); ?>
        <?php } ?>
    </div>
    <?php if ($loggedUser) { ?>
        <div class="create_post_block">
            <?php echo Html::a('Create post', ['post/create'], ['class' => 'btn btn-primary btn-md']); ?>
        </div>
    <?php } ?>
</div>