<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\controllers;

use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemSearch;
use asb\yii2\common_2_170212\controllers\BaseAdminMulangController;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * AdminController implements the CRUD actions for NewsTagitem model.
 */
class AdminController extends BaseAdminMulangController
{
    public $pageSizeAdmin = 20; // default if not set in params

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $param = 'pageSizeAdmin';
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
                    'delete' => ['POST'],
                ],
            ],
        ]);
        //$behaviors['access']['rules'] = []; // disable default 'roleRoot' and 'roleAdmin'
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['create'], 'roles' => ['createNews']];
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['delete'], 'roles' => ['deleteNews']];
        $behaviors['access']['rules'][] = ['allow' => true, 'actions' => ['update'], 'roles' => ['roleNewsModerator']
        ];

        return $behaviors;
    }

    /**
     * Lists all NewsTagitem models.
     * @return mixed
     */
    public function actionIndex($page = 1, $id = 0)
    {
        $searchModel = $this->module->model('NewsTagitemSearch');
        $qryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($qryParams);

        $pager = $dataProvider->getPagination();
        $pager->pageSize = $this->pageSizeAdmin;
        $pager->totalCount = $dataProvider->getTotalCount();

        $maxPage = ceil($pager->totalCount / $pager->pageSize);
        if ($page > $maxPage) {
            $pager->page = $maxPage - 1;
        } else {
            $pager->page = $page - 1; //! from 0
        }

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'currentId'    => $id,
        ]);
    }

    /**
     * Displays a single NewsTagitem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model->pageSize = $this->pageSizeAdmin;
        if ($model->pageSize > 0) {
            $model->orderBy = $model::$defaultOrderBy;
            $model->page = $model->calcPage($model->find());
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new NewsTagitem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->module->model('NewsTagitem');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $model->pageSize = $this->pageSizeAdmin;
            $model->orderBy = $model::$defaultOrderBy;
            $model->page = $model->calcPage($model->find());
            return $this->redirect(['index',
                'page'   => $model->page,
                'id'     => $model->id,
                'sort'   => $model->orderByToSort(),
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NewsTagitem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $model->pageSize = $this->pageSizeAdmin;
            $model->orderBy = $model::$defaultOrderBy;
            $model->page = $model->calcPage($model->find());
            return $this->redirect(['index',
                'page'   => $model->page,
                'id'     => $model->id,
                'sort'   => $model->orderByToSort(),
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NewsTagitem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->pageSize = $this->pageSizeAdmin;
        $model->orderBy = $model::$defaultOrderBy;
        $model->page = $model->calcPage($model->find());
        $returnTo = ['index',
            'page'   => $model->page,
            'id'     => $model->id,
            'sort'   => $model->orderByToSort(),
        ];

        $model->delete();

        return $this->redirect($returnTo);
    }

    /**
     * Finds the NewsTagitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsTagitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelNewsTagitem = $this->module->model('NewsTagitem');
        if (($model = $modelNewsTagitem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
