<?php

namespace asb\yii2\modules\news_3b_171202\models;

use asb\yii2\modules\news_3b_171202\Module;
use asb\yii2\modules\news_1b_160430\models\NewsSearchFront;

use Yii;

class NewsSearchByTag extends NewsSearchFront
{
    /**
     * @inheritdoc
     */
    public function search($params)
    {
        $dataProvider = parent::search($params);

        if (!empty($params['tag_id'])) {
            $tagId = $params['tag_id'];

            $subModel = $this->module->modules['tags']->model('NewsTagsArticles');
            $subQuery = $subModel::find()->select('news_id')->where(['tagitem_id' => $tagId]);

            $alias = $dataProvider->query->tableAliasMain;
            $dataProvider->query->andWhere(['in', "{$alias}.id", $subQuery]);
        }

        //list($sql, $sqlParams) = Yii::$app->db->getQueryBuilder()->build($dataProvider->query);var_dump($sql,$sqlParams);exit;
        return $dataProvider;
    }

}

