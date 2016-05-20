<div class="menu-category list-group ">
    <div class="menu-category-name list-group-item active">Category</div>
    <?php if (isset($model->categories) && !empty($model->categories) && is_array($model->categories)) { ?>
        <?php foreach ($model->categories as $category) { ?>
            <a href="post/category/<?php echo $category->id; ?>" class="menu-item list-group-item"><?php echo $category->title; ?>
                <span class="badge">1</span>
            </a>
        <?php } ?>
    <?php } ?>
</div>