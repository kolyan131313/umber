<?php
namespace common\models;

use Yii;
use common\components\behaviors\CBlameableBehavior;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $moderated
 * @property integer $visible
 * @property string $date_created
 * @property string $date_modified
 *
 * @property User $author
 * @property PostsCategories[] $postsCategories
 */
class Posts extends General
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
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
            [['title', 'description'], 'required'],
            [['text'], 'string'],
            [['created_by', 'modified_by', 'moderated', 'visible'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
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
            'created_by'    => 'Created By',
            'modified_by'   => 'Modified By',
            'moderated'     => 'Moderated',
            'visible'       => 'Visible',
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
    public function getPostsCategories()
    {
        return $this->hasMany(PostsCategories::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable(PostsCategories::tableName(), ['post_id' => 'id']);
    }
}
