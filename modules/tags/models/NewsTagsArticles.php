<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use asb\yii2\modules\news_3b_171202\modules\tags\Module;

use asb\yii2\common_2_170212\models\DataModel;

use Yii;

/**
 * This is the model class for table "{{%news_tags_articles}}".
 *
 * @property integer $id
 * @property integer $tagitem_id
 * @property integer $news_id
 */
class NewsTagsArticles extends DataModel
{

/* move to config/params.php:
    public static function tableName()
    {
        return '{{%news_tags_articles}}';
    }
*/

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->module)) {
            $this->module = Module::getModuleByClassname(Module::className());
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tagitem_id', 'news_id'], 'required'],
            [['tagitem_id', 'news_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t($this->tcModule, 'ID'),
            'tagitem_id' => Yii::t($this->tcModule, 'Tagitem ID'),
            'news_id' => Yii::t($this->tcModule, 'News ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return NewsTagsArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsTagsArticlesQuery(get_called_class());
    }

    /**
     * Add new tag for article if not exists.
     * @return integer number of added records
     */
    public static function add($tagId, $newsId)
    {
        $exists = static::find()->where(['tagitem_id' => $tagId, 'news_id' => $newsId])->count();
        if (!$exists) {
            $model = new static;
            $model->tagitem_id = $tagId;
            $model->news_id = $newsId;
            $model->save();
            static::clearCountsCache();
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Delete tag for article if exists.
     * @return integer number of deleted records
     */
    public static function del($tagId, $newsId)
    {
        $found = static::find()->where(['tagitem_id' => $tagId, 'news_id' => $newsId])->one();
        if ($found) {
            $found->delete();
            static::clearCountsCache();
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @param integer $tagId
     * @param string $langCode
     * @return integer count of articles for tag with id $tagId
     */
    public static function countArticles($tagId, $langCode)
    {
        if (static::getCountValue($tagId, $langCode) === false) {
            $module = Module::getModuleByClassname(Module::className()); // this (sub)module
            $modelI18n = $module->module->model('NewsI18n');

            $subModel = $module->module->model('NewsSearchByTag'); // model in module-container

            $dataProvider = $subModel->search([
                'tag_id' => $tagId
            ]);
            $subQuery = $dataProvider->query;
            $subQuery
                ->alias($subQuery->tableAliasMain)
                ->select("{$subQuery->tableAliasMain}.id")
                ->leftJoin([$subQuery->tableAliasI18n => $modelI18n::tableName()]
                    , "{$subQuery->tableAliasMain}.id = {$subQuery->tableAliasI18n}.news_id"
                      . " AND {$subQuery->tableAliasI18n}.lang_code = '{$subQuery->langCodeMain}'");

            $query = static::find();
            $query->where(['tagitem_id' => $tagId])
                  ->andWhere(['in', "{$query->tableAliasMain}.news_id", $subQuery])
                  ;//list($sql, $sqlParams) = Yii::$app->db->getQueryBuilder()->build($query);var_dump($sql,$sqlParams);exit;

            $count = $query->count();

            static::setCountValue($tagId, $langCode, $count);
        }
        $count = static::getCountValue($tagId, $langCode);
        return $count;
    }

    /**
     * @param string $langCode
     * @return integer maximum value of atricles counters
     */
    public static function maxCount($langCode)
    {
        if (empty(static::$_countsArticlesCache[$langCode]) && Yii::$app->cache->exists(self::CACHE_KEY)) {
            static::$_countsArticlesCache[$langCode] = Yii::$app->cache->get(self::CACHE_KEY);
        }
        $max = 0;
        if (!empty(static::$_countsArticlesCache)) {
            foreach (static::$_countsArticlesCache[$langCode] as $count) {
                if ($count > $max) {
                    $max = $count;
                }
            }
        }
        return $max;
    }

    /**
     * Save counts cache together.
     * Call it once after all counts calculated (at MainController::actionTagsCloud())
     */
    public static function saveAllCountsCache()
    {
        Yii::$app->cache->set(self::CACHE_KEY, static::$_countsArticlesCache);
    }

    // Caching counts of articles for tags
    const CACHE_KEY = __CLASS__;
    protected static $_countsArticlesCache = [];
    protected static function clearCountsCache()  // call it after any add/delete in this model
    {
        static $_countsArticlesCache = [];
        Yii::$app->cache->delete(self::CACHE_KEY);
    }
    protected static function setCountValue($tagId, $langCode, $value)
    {
        static::$_countsArticlesCache[$langCode][$tagId] = $value;
    }
    protected static function getCountValue($tagId, $langCode)
    {
        if (empty(static::$_countsArticlesCache) && Yii::$app->cache->exists(self::CACHE_KEY)) {
            static::$_countsArticlesCache = Yii::$app->cache->get(self::CACHE_KEY);
        }
        if (isset(static::$_countsArticlesCache[$langCode][$tagId])) {
            return static::$_countsArticlesCache[$langCode][$tagId];
        } else {
            return false;
        }
    }

}
