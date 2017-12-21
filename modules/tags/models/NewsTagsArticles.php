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
}
