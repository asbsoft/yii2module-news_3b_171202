<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

/**
 * This is the ActiveQuery class for [[NewsTagitemI18n]].
 *
 * @see NewsTagitemI18n
 */
class NewsTagitemI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NewsTagitemI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsTagitemI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
