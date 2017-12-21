<?php

namespace asb\yii2\modules\news_3b_171202\models;

use asb\yii2\modules\news_1b_160430\models\NewsSearchFront;

class NewsSearchByTag extends NewsSearchFront
{
    /**
     * @inheritdoc
     */
    public function search($params)
    {
        $dataProvider = parent::search($params);
        if (empty($params['tag_id'])) {
            return $dataProvider;
        }
        $tagId = $params['tag_id'];

        $query = $dataProvider->query;

        $subModel = $this->module->modules['tags']->model('NewsTagsArticles');
        $subQuery = $subModel::find()->select('news_id')->where(['tagitem_id' => $tagId]);

        $alias = $query->tableAliasMain;
        $dataProvider->query->andWhere(['in', "{$alias}.id", $subQuery]);

        return $dataProvider;
    }

}

