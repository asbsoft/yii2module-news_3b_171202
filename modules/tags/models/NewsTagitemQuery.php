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

    public function init()
    {
        parent::init();

        $this->alias($this->tableAliasMain);

        if (empty($this->langCodeMain) ) {
            $this->langCodeMain = LangHelper::normalizeLangCode(Yii::$app->language);
        }
    }

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     */
    public function count($q = '*', $db = null)
    {//echo __METHOD__;var_dump($q);
        $this
            ->alias($this->tableAliasMain)
            ->leftJoin([$this->tableAliasI18n => NewsTagitemI18n::tableName()] //!! join here, not in search model
                , "{$this->tableAliasMain}.id = {$this->tableAliasI18n}.tagitem_id "
                  . " AND {$this->tableAliasI18n}.lang_code = '{$this->langCodeMain}'"
              );
        return parent::count($q, $db);
    }

    /**
     * @inheritdoc
     * @return NewsTagitem[]|array
     */
    public function all($db = null)
    {//echo __METHOD__;
        $this
            ->alias($this->tableAliasMain)
            ->leftJoin([$this->tableAliasI18n => NewsTagitemI18n::tableName()] //!! join here, not in search model
                , "{$this->tableAliasMain}.id = {$this->tableAliasI18n}.tagitem_id "
                  . " AND {$this->tableAliasI18n}.lang_code = '{$this->langCodeMain}'")
            ->select([
                "{$this->tableAliasMain}.*",
                "{$this->tableAliasI18n}.title AS title",
            ]);//list ($sql, $parms) = Yii::$app->db->getQueryBuilder()->build($this);var_dump($sql);var_dump($parms);exit;
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsTagitem|array|null
     */
    public function one($db = null)
    {//echo __METHOD__;var_dump($this->langCodeMain);var_dump($this->where);
        if (isset($this->where['id'])) {
            $this->where["{$this->tableAliasMain}.id"] = $this->where['id'];
            unset($this->where['id']);
        }
        $this
            ->alias($this->tableAliasMain)
            ->leftJoin([$this->tableAliasI18n => NewsTagitemI18n::tableName()] //!! join here, not in search model
                , "{$this->tableAliasMain}.id = {$this->tableAliasI18n}.tagitem_id "
                  . " AND {$this->tableAliasI18n}.lang_code = '{$this->langCodeMain}'")
            //->where(["{$alias}.id" => $id]) //!! not 'id' by default
            ->where($this->where)
            ->select([
                "{$this->tableAliasMain}.*",
                "{$this->tableAliasI18n}.title AS title",
            ]);//list ($sql, $parms) = Yii::$app->db->getQueryBuilder()->build($this);var_dump($sql);var_dump($parms);exit;
        return parent::one($db);
    }
}
