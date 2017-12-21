<?php

use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemI18n;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemQuery;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemSearch;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagsArticles;

use asb\yii2\common_2_170212\base\UniApplication;
use asb\yii2\common_2_170212\i18n\LangHelper;

//var_dump(AdminController::$adminPath);exit;
$type = empty(Yii::$app->type) ? false : Yii::$app->type;

return  [
    // External using classes
    'userIdentity'  => Yii::$app->user->identityClass,
    'langHelper'    => LangHelper::className(),

    // Routes config
    'routesConfig' => [ // default: type => prefix|[config]
        'admin' => $type == UniApplication::APP_TYPE_FRONTEND ? false : [
            'urlPrefix' => 'tag', // default sublink in routes category 'admin' for this (sub)module

            // startlink to module - for menu builder (asb\yii2\common_2_170212\helpers\MenuBuilder):
            'startLinkLabel' => 'News tags manager', // is same as:
/*
            'startLink' => [
                'label' => 'News tags manager', //!! no translate here, it will translate using 'MODULE_UID/module' tr-category
                'action' => 'admin/index',
            ],
*/
        ],
        'main' => $type == UniApplication::APP_TYPE_BACKEND  ? false : [
            'urlPrefix' => 'tag', // default sublink in routes category 'main' for this (sub)module
/*
            // startlink to module - for menu builder (asb\yii2\common_2_170212\helpers\MenuBuilder):
            'startLink' => [
                'label' => 'Tags cloud', //!! no translate here, it will translate using 'MODULE_UID/module' tr-category
                'action' => 'main/list',
            ],
/**/
        ],
    ],

    // Shared models
    'models' => [ // alias => class name or object array
        'NewsTagitem'       => NewsTagitem::className(),
        'NewsTagitemI18n'   => NewsTagitemI18n::className(),
        'NewsTagitemQuery'  => NewsTagitemQuery::className(),
        'NewsTagitemSearch' => NewsTagitemSearch::className(),
        'NewsTagsArticles'  => NewsTagsArticles::className(),
    ],

    'assets' => [ // alias => class name
        'MainTagsAsset'  => 'asb\yii2\modules\news_3b_171202\modules\tags\assets\MainTagsAsset',
        'AdminTagsAsset' => 'asb\yii2\modules\news_3b_171202\modules\tags\assets\AdminTagsAsset',
    ],

];
