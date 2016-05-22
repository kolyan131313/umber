<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $unvisible
 * @property string $date_created
 * @property string $date_modified
 *
 * @property PostCategory[] $postsCategory
 * @property Post[] $posts
 */
class Category extends General
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            ['unvisible', 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['url', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'unvisible' => 'Hide Category',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostsCategories()
    {
        return $this->hasMany(PostCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])
            ->viaTable(PostCategory::tableName(), ['category_id' => 'id']);
    }
}
