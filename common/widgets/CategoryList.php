<?php
namespace common\widgets;

use common\models\Categories;
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
     * @var object
     */
    private $categories;

    /**
     * Init main widget params
     */
    public function init()
    {
        parent::init();

        $this->categories = Categories::find()->limit($this->limit)->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('category_list', ['categories' => $this->categories]);
    }
}
