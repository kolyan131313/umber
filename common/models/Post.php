<?php
namespace common\models;

use Yii;
use common\components\behaviors\CBlameableBehavior;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

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
     * @var array category list
     */
    public $categories = [];

    /**
     * @var string image
     */
    public $image;

    /**
     * @var array statuses
     */
    private $statuses = ['New', 'Moderated', 'Deleted'];

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
            [['title', 'description', 'text', 'src', 'categories'], 'required'],
            [['text'], 'string'],
            [['created_by', 'modified_by', 'moderated', 'unvisible'], 'integer'],
            [['date_created', 'date_modified', 'src', 'image'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
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
            'moderated'     => 'Status',
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
    public function getCategoryList()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable(PostCategory::tableName(), ['post_id' => 'id']);
    }

    /**
     * Get All statuses
     * @return array
     */
    public function getStatuses()
    {
        return $this->statuses;
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
            $query->joinWith('categoryList');
            $query->andFilterWhere([
                'AND',
                ['category.url' => $category]
            ]);
        }

        $query->andFilterWhere([
            'AND',
            [self::tableName() . '.unvisible' => self::STATUS_UNVISIBLE],
            [self::tableName() . '.moderated' => self::STATUS_MODERATED]
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
            PostCategory::deleteAll('post_id=' . $this->id);

            foreach ($categories as $category_id) {
                /** @var Category $category */
                $category = Category::findOne($category_id);
                $this->link('categoryList', $category);
            }
        }
    }

    /**
     * Get path to image
     *
     * @param bool|string $post
     * @param string $src
     * @return string
     */
    public function getImagePath($post = false, $src = "")
    {
        return $this->createMainImagePath($post, $src);
    }

    /**
     * Processing path for images
     *
     * @param bool $post
     * @param string $src
     * @return string
     */
    public function createMainImagePath($post = false, $src = "")
    {
        $path = Yii::getAlias('@frontend');
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        $parts[] = 'web';

        $resPath = implode($parts, DIRECTORY_SEPARATOR);

        return $resPath . DIRECTORY_SEPARATOR . ($post ? '../' : '') . Yii::$app->params['uploadPath'] . DIRECTORY_SEPARATOR . ($src ? $src : $this->src);
    }

    /**
     * Get related categories ids
     */
    public function loadCategories()
    {
        /** @var Category $categories */
        $categories = $this->getCategoryList()->all();

        if ($categories && is_array($categories)) {
            foreach ($categories as $category) {
                array_push($this->categories, $category->id);
            }
        }
    }

    /**
     * Prepare file fore create or update
     *
     * @param UploadedFile $image
     * @return string
     */
    public function prepareUploadFile(UploadedFile $image)
    {
        $img_parts = (explode(".", $image->name));

        $this->image = Yii::$app->security->generateRandomString() . "." . end($img_parts);
        $this->src = $this->image;

        return $this->getImagePath();
    }

    /**
     * Set moderated false
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!Yii::$app->user->can('moderator')) {
                $this->moderated = 0;
            }

            return true;
        }

        return false;
    }

    /**
     * Category list to array
     *
     * @return string
     */
    public function categoryToString()
    {
        $catList = [];

        /** @var $this Post */
        if ($this->categoryList && is_array($this->categoryList)) {
            foreach ($this->categoryList as $category) {
                $catList[] = $category->title;
            }
        }

        return implode(', ', $catList);
    }
}
