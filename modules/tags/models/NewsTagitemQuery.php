<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use asb\yii2\common_2_170212\i18n\LangHelper;

use yii\db\ActiveQuery;
use Yii;

/**
 * This is the ActiveQuery class for [[NewsTagitem]].
 *
 * @see NewsTagitem
 */
class NewsTagitemQuery extends ActiveQuery
{
    public $tableAliasMain = 'main';
    public $tableAliasI18n = 'i18n';
    
    public $langCodeMain;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->alias($this->tableAliasMain);

        if (empty($this->langCodeMain) ) {
            $this->langCodeMain = LangHelper::normalizeLangCode(Yii::$app->language);
        }
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        $query = parent::prepare($builder);
        $query->leftJoin([$this->tableAliasI18n => NewsTagitemI18n::tableName()] //!! join here, not in search model
                  , "{$this->tableAliasMain}.id = {$this->tableAliasI18n}.tagitem_id "
                    . " AND {$this->tableAliasI18n}.lang_code = '{$this->langCodeMain}'"
                );
        return $query;
    }

    /**
     * @inheritdoc
     * @return NewsTagitem[]|array
     */
    public function all($db = null)
    {
        $this
            ->select([
                "{$this->tableAliasMain}.*",
                "{$this->tableAliasI18n}.title AS title",
            ]);
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsTagitem|array|null
     */
    public function one($db = null)
    {
        if (isset($this->where['id'])) {
            $this->where["{$this->tableAliasMain}.id"] = $this->where['id'];
            unset($this->where['id']);
        }
        $this
            ->where($this->where)
            ->select([
                "{$this->tableAliasMain}.*",
                "{$this->tableAliasI18n}.title AS title",
            ]);
        return parent::one($db);
    }

}
