<?php
namespace common\models;

use Yii;
use common\components\behaviors\CBlameableBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property integer $moderated
 * @property integer $unvisible
 * @property string $date_created
 * @property string $date_modified
 *
 * @property User $created_by
 * @property User $modified_by
 * @property PostCategory[] $postsCategories
 */
class Post extends General
{
    /**
     * Moderated status
     */
    const STATUS_MODERATED = 1;

    /**
     * Status unvisible
     */
    const STATUS_UNVISIBLE = 0;

    /**
     * @var category list
     */
    public $categories;

    /**
     * @var category list
     */
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * Adding user created and modified behavior
     * to General Behavior
     *
     * @return array
     */
    public function behaviors()
    {
        /** @var array $parenBehaviors */
        $parenBehaviors = parent::behaviors();

        $parenBehaviors[] = [
            'class'              => CBlameableBehavior::className(),
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'modified_by'
        ];

        return $parenBehaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'text', 'src', 'image', 'categories'], 'required'],
            [['text'], 'string'],
            [['created_by', 'modified_by', 'moderated', 'unvisible'], 'integer'],
            [['date_created', 'date_modified', 'src'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions' => 'jpg, gif, png'],
            [
                ['created_by', 'modified_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => [
                    'created_by'  => 'id',
                    'modified_by' => 'id'
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'description'   => 'Description',
            'text'          => 'Text',
            'src'           => 'Image',
            'created_by'    => 'Created By',
            'modified_by'   => 'Modified By',
            'moderated'     => 'Moderated',
            'unvisible'     => 'Hide publication',
            'date_created'  => 'Date Created',
            'date_modified' => 'Date Modified'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorModified()
    {
        return $this->hasOne(User::className(), ['id' => 'modified_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable(PostCategory::tableName(), ['post_id' => 'id']);
    }

    /**
     * Method for creating query with conditions
     *
     * @param $limit
     * @param $category
     * @return ActiveDataProvider
     */
    public function createQuery($limit, $category)
    {
        $query = self::find();

        if ($category) {
            $query->joinWith('categories');
            $query->andFilterWhere([
                'AND',
                ['category.url' => $category]
            ]);
        }

        $query->andFilterWhere([
            'AND',
            ['unvisible' => self::STATUS_UNVISIBLE],
            ['moderated' => self::STATUS_MODERATED]
        ]);

        $query->orderBy('id DESC');

        return new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $limit
            ],
        ]);
    }

    /**
     * Method for bind categories to post
     *
     * @param array $categories
     */
    public function linkCategory($categories = [])
    {
        if (!empty($categories) && is_array($categories)) {
            foreach ($categories as $category_id) {
                /** @var Category $category */
                $category = Category::findOne($category_id);
                $this->link('categories', $category);
            }
        }
    }

    /**
     * Get path to image
     *
     * @param string $src
     * @return string
     */
    public function getImagePath($post = false, $src = "")
    {
        return ($post ? '../' : '') . Yii::$app->params['uploadPath'] . DIRECTORY_SEPARATOR . ($src ? $src : $this->src);
    }
}
