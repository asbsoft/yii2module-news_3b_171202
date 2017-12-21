<?php

namespace asb\yii2\modules\news_3b_171202\controllers;

// possible variants:
//use asb\yii2\modules\news_1b_160430\controllers\AdminController as BaseAdminController;
use asb\yii2\modules\news_2b_161124\controllers\AdminController as BaseAdminController;

use Yii;

class AdminController extends BaseAdminController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'][] = [
            'actions' => ['test-ext'],
            'allow' => true,
            'roles' => ['roleAdmin', 'roleNewsAuthor', 'roleNewsModerator'],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        // cool but not correct: view-template will be render twice - lost session data for Alert widget
        //$result = parent::actionView($id); // render result not need, only $this->renderData
        //return $this->render('view', $this->renderData); // use $this->renderData

        // repeat data preparation like in parent news_1b_160430/AdminController:
        $model = $this->findModel($id);
        $modelsI18n = $model::prepareI18nModels($model);

        if ($model->pageSize > 0) {
            $model->orderBy = $model->defaultOrderBy;
            $model->page = $model->calcPage();
        }

        return $this->render('view', [
            'model' => $model,
            'modelsI18n' => $modelsI18n,
        ]);
    }

    /** Test of views extension */
    public function actionTestExt()
    {
        return $this->render('test-ext', [
            't' => Yii::t($this->tcModule, 'Title') . ' (message from news_1b_160430)',
            's' => Yii::t($this->tcModule, 'Slug') . ' (message from news_2b_161124)',
            'n' => 987654321,
        ]);
    }


}
