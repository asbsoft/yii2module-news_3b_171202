<?php

namespace asb\yii2\modules\news_3b_171202\controllers;

// possible variants:
//use asb\yii2\modules\news_1b_160430\controllers\MainController as BaseMainController;
use asb\yii2\modules\news_2b_161124\controllers\MainController as BaseMainController;

use Yii;
use yii\web\NotFoundHttpException;

class MainController extends BaseMainController
{
    /** Count of news in 'latest-news' action-widget */
    public $countLatestNews = 4; // default value if not set
    
    public function init()
    {
        parent::init();

        $param = 'countLatestNews';
        if (isset($this->module->params[$param])) {
            $this->$param = $this->module->params[$param];
        }
    }
    
    public function actionListForTag($id, $page = 1)
    {
        $tagModel = $this->module->modules['tags']->getDataModel('NewsTagitem')->findOne($id);
        if (!$tagModel || !$tagModel->is_visible) {
            throw new NotFoundHttpException(Yii::t($this->tcModule, 'Not found such news tag'));
        }

        $params = ['tag_id' => $id];
        $searchModel = $this->module->getDataModel('NewsSearchByTag');
        $dataProvider = $searchModel->search($params);

        $pager = $dataProvider->getPagination();
        $pager->pageSize = $this->module->params['pageSizeFront'];
        $pager->totalCount = $dataProvider->getTotalCount();

        // page number correction:
        if ($pager->totalCount <= $pager->pageSize || $page > ceil($pager->totalCount / $pager->pageSize) ) {
            $pager->page = 0; //goto 1st page if shortage records
        } else {
            $pager->page = $page - 1; //! from 0
        }

        $this->renderData = [
            'tagModel' => $tagModel,
            'dataProvider' => $dataProvider,
        ];
        return $this->render('list-for-tag', $this->renderData);
    }

    public function actionLatestNews($count = null, $title = null)
    {
        if ($count === null) {
            $count = $this->countLatestNews;
        }

        $searchModel = $this->module->getDataModel('NewsSearchFront');
        $dataProvider = $searchModel->search([]);
        $dataProvider->pagination->pageSize = $count;

        $models = $dataProvider->getModels();
        return $this->renderPartial('latest-news', [
            'models' => $models,
            'title' => $title,
        ]);
    }
}
