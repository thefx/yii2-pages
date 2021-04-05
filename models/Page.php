<?php

namespace thefx\pages\models;

use paulzi\nestedsets\NestedSetsBehavior;
use thefx\pages\behaviors\Slug;
use thefx\pages\models\queries\PagesQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $path
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property int $parent_id
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property int $create_user
 * @property string $create_date
 * @property int $update_user
 * @property string $update_date
 * @property int $public
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text'], 'string'],
            [['parent_id', 'lft', 'rgt', 'depth', 'create_user', 'update_user', 'public'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['title', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'text' => 'Текст',
            'path' => 'Url',
            'seo_title' => 'Заголовок в браузере',
            'seo_keywords' => 'Ключевые слова',
            'seo_description' => 'Описание',
            'parent_id' => 'Категория',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'create_user' => 'Create User',
            'create_date' => 'Create Date',
            'update_user' => 'Update User',
            'update_date' => 'Update Date',
            'public' => 'Активность',
        ];
    }

    public function getEditorPath()
    {
        $id = $this->getPrimaryKey();
        $path = Yii::$app->params['path.page.editor'];

        $dir = Yii::getAlias('@webroot/upload/' . $path) . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;

        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        return Yii::getAlias('@web/upload/' . $path) . '/';
    }

    public function pagesList()
    {
        $pages = static::find()->orderBy('lft');
//        $pages->where(['!=', 'Name', "root"]);

        if ($this->id) {
            $pages->andWhere(['!=', 'id', $this->id]);
        }

        $pages = $pages->all();

        return ArrayHelper::map($pages, 'id', static function(self $row) {
            return str_repeat('—', $row->depth) . ' ' . $row->title;
        });
    }

    public function getPath()
    {
//        $path = Yii::$app->cache->getOrSet('page'.$this->id , function () {
            $parents = ArrayHelper::map($this->getParents()->withoutRoot()->all(), 'path', 'title');
            $path = '/';
            foreach ($parents as $id => $parent) {
                $path .= $id . '/';
            }
            return $path . $this->path . '/';
//        }, 0, new TagDependency(['tags' => 'page']));
//
//        return $path;
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => Slug::class,
                'in_attribute' => 'title',
                'out_attribute' => 'path'
            ],
            NestedSetsBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     * @return PagesQuery
     */
    public static function find()
    {
        return new PagesQuery(static::class);
    }
}
