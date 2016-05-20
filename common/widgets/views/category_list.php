<div class="col-lg-3">
    <div class="menu-category list-group ">
        <div class="menu-category-name list-group-item active">Category</div>
        <?php if (isset($categories) && !empty($categories) && is_array($categories)) { ?>
            <?php foreach ($categories as $category) { ?>
                <a href="<?php echo $category->id; ?>" class="menu-item list-group-item">
                    <?php echo $category->title; ?>
                    <span class="badge"><?php echo count($category->posts);?></span>
                </a>
            <?php } ?>
        <?php } else { ?>
            <a href="#" class="menu-item list-group-item">Categories is not added</a>
        <?php } ?>
    </div>
</div>