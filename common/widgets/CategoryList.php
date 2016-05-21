<?php
namespace common\widgets;

use common\models\Category;
use common\models\Post;
use yii\bootstrap\Widget;

/**
 * Class Alert
 * @package common\widgets
 */
class CategoryList extends Widget
{
    /**
     * @var integer limit of categories.
     */
    public $limit = 10;

    /**
     * @var array object
     */
    private $categories = [];

    /**
     * @var array object
     */
    private $cntPosts = [];

    /**
     * @var object
     */
    public $loggedUser;

    /**
     * Init main widget params
     */
    public function init()
    {
        parent::init();

        $this->categories = Category::find()->limit($this->limit)->all();

        $this->calculatePosts();
    }

    /**
     * Method for calculating post in category
     */
    public function calculatePosts()
    {
        if ($this->categories && is_array($this->categories)) {
            foreach ($this->categories as $category) {
                $this->cntPosts[$category->id] = 0;
                foreach ($category->posts as $post) {
                    if ($post->unvisible === Post::STATUS_UNVISIBLE && $post->moderated === Post::STATUS_MODERATED) {
                        $this->cntPosts[$category->id] += 1;
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('category_list', [
            'categories' => $this->categories,
            'loggedUser' => $this->loggedUser,
            'cntPosts'   => $this->cntPosts
        ]);
    }
}
