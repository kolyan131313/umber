<div class="row">
    <div class="col-md-12 post">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    <strong>
                        <a href="/post/<?php echo $model->id;?>" class="post-title">Cool Share Button Effects Styles</a>
                    </strong>
                </h4>
            </div>
        </div>
        <?php echo $this->render('_post_stat',['model' => $model]); ?>
        <?php echo $this->render('_post_content',['model' => $model]); ?>
    </div>
</div>