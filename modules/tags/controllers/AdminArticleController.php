<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\controllers;

use asb\yii2\common_2_170212\controllers\BaseAdminController;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class AdminArticleController extends BaseAdminController
{
    public $sizeListBoxAdmin = 5; // default if not set in params

    public $fieldsListName = 'tags';

    public $actionNewsView;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->actionNewsView = '/' . $this->module->module->uniqueId . '/admin/view'; // action in container("parent")-module

        $param = 'sizeListBoxAdmin';
        if (!empty($this->module->params[$param]) && intval($this->module->params[$param]) > 0) {
            $this->$param = intval($this->module->params[$param]);
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ]);
        return $behaviors;
    }

    /**
     * Form for add tags for article $id.
     * @param integer $id
     * @return mixed
     */
    public function actionForm($id)
    {
        $model = $this->module->model('NewsTagitem');
        $models = $model::find()->orderBy('title')->all();

        return $this->renderPartial('form', [
            'id' => $id,
            'models' => $models,
        ]);
    }

    /**
     * Add tags for article $id.
     * @param integer $id
     * @return mixed
     */
    public function actionAdd($id)
    {
        $post = Yii::$app->request->post();
        if (empty($post[$this->fieldsListName])) {
            Yii::$app->session->addFlash('error', Yii::t($this->tcModule, "Didn't select any tag"));
        } else {
            $mt = $this->module->model('NewsTagitem');
            $model = $this->module->model('NewsTagsArticles');
            $result = 0;
            foreach($post[$this->fieldsListName] as $tagId) {
                $tagModel = $mt::findOne($tagId); // may be empty if tag was deleted now from another window
                if ($tagModel) {
                    $result += $model::add($tagId, $id);
                }
            }
            Yii::$app->session->addFlash('success', Yii::t($this->tcModule, "Added {N} selected tag(s)", ['N' => $result]));
        }
        return $this->redirect([$this->actionNewsView, 'id' => $id]);
    }

    /**
     * Lists tags for article $id.
     * @param integer $id
     * @return mixed
     */
    public function actionList($id)
    {
        $subModel = $this->module->model('NewsTagsArticles');
        $subQuery = $subModel::find()->select('tagitem_id')->where(['news_id' => $id]);
        $model = $this->module->model('NewsTagitem');
        $query = $model::find();
        $alias = $query->tableAliasMain;
        $models = $query->where(['in', "{$alias}.id", $subQuery])->orderBy('title')->all();
        return $this->renderPartial('list', [
            'id' => $id,
            'models' => $models,
        ]);
    }

    /**
     * Delete tags for article $id.
     * @param integer $id
     * @return mixed
     */
    public function actionDel($id)
    {
        $post = Yii::$app->request->post();
        if (empty($post[$this->fieldsListName])) {
            Yii::$app->session->addFlash('error', Yii::t($this->tcModule, "Didn't select any tag for deletion"));
        } else {
            $model = $this->module->model('NewsTagsArticles');
            $result = 0;
            foreach($post[$this->fieldsListName] as $tagId) {
                $result += $model::del($tagId, $id);
            }
            Yii::$app->session->addFlash('success', Yii::t($this->tcModule, "Deleted {N} selected tag(s)", ['N' => $result]));
        }
        return $this->redirect([$this->actionNewsView, 'id' => $id]);
    }

}
