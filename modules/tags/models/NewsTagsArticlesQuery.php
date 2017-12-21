<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

/**
 * This is the ActiveQuery class for [[NewsTagsArticles]].
 *
 * @see NewsTagsArticles
 */
class NewsTagsArticlesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NewsTagsArticles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsTagsArticles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
