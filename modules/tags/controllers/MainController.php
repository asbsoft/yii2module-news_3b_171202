<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\controllers;

use asb\yii2\common_2_170212\controllers\BaseMultilangController;

/**
 * Test example of inherited controller.
 *
 * @author ASB <ab2014box@gmail.com>
 */
class MainController extends BaseMultilangController
{
    /**
     * @var integer minimal articles count to show tag in tags-cloud
     * DEfault 1 to show all
     */
    public $minCountShowTag = 1; // default - show all

    /** Max value of articles count */
    public $maxCount;
    
    /**
     * Lists tags for article $id.
     * Use as widget by runAction().
     * @param integer $id
     * @return mixed
     */
    public function actionTagsList($id)
    {
        $subModel = $this->module->model('NewsTagsArticles');
        $subQuery = $subModel::find()->select('tagitem_id')->where(['news_id' => $id]);
        $model = $this->module->model('NewsTagitem');
        $query = $model::find();
        $alias = $query->tableAliasMain;
        $models = $query
            ->andWhere(['in', "{$alias}.id", $subQuery])
            ->orderBy('title')
            ->all();
        return $this->renderPartial('tags-list', [
            'id' => $id,
            'models' => $models,
        ]);
    }

    /**
     * Tags cloud.
     * Use as widget by runAction().
     * @param string $langCode
     * @return mixed
     */
    public function actionTagsCloud($langCode = null)
    {
        if (empty($langCode)) {
            $langCode = $this->langCodeMain;
        }

        $this->minCountShowTag = empty($this->module->params['minCountShowTag'])
            ? $this->minCountShowTag : $this->module->params['minCountShowTag'];
        $mta = $this->module->model('NewsTagsArticles');

        $model = $this->module->model('NewsTagitem');
        $models = $model::find()
            ->where(['is_visible' => true])
            ->orderBy('title')
            ->all();

        $tagModels = [];
        $tagCounts = [];
        foreach ($models as $model) {
            $countArticles = $mta::countArticles($model->id, $langCode);
            if ($countArticles >= $this->minCountShowTag) {
                $tagModels[$model->id] = $model;
                $tagCounts[$model->id] = $countArticles;
            }
        }
        $this->maxCount = $mta::maxCount($langCode);
        
        $mta::saveAllCountsCache();
        
        return $this->renderPartial('tags-cloud', [
            'tagModels' => $tagModels,
            'tagCounts' => $tagCounts,
        ]);
    }
}
