<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[NewsTagsArticles]].
 *
 * @see NewsTagsArticles
 */
class NewsTagsArticlesQuery extends ActiveQuery
{
    public $tableAliasMain = 'mta';

    /**
     * @inheritdoc
     */
    public function __construct($modelClass, $config = [])
    {
        parent::__construct($modelClass, $config);
        $this->alias($this->tableAliasMain);
    }

}
