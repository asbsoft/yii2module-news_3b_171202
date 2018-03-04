<?php

use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemI18n;
use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagsArticles;

use asb\yii2\common_2_170212\behaviors\ParamsAccessBehaviour;


return [
    'label'   => 'Tags manager (submodule of News module)',

    'behaviors' => [
        'params-access' => [
            'class' => ParamsAccessBehaviour::className(),
            'defaultRole' => 'roleAdmin',
          //'readonlyParams' => [], // not need here
        ],
    ],

    // set TRUE to show in edit form all registered languages, not only visible
    'editAllLanguages' => false,
  //'editAllLanguages' => true,

    // admin list ðage size
    'pageSizeAdmin' => 10,

    // tags list box size in add tags admin-form for article
    'sizeListBoxAdmin' => 3,

    // minimal articles count to show tag in tags-cloud
    'minCountShowTag' => 2,

    // tables names
    NewsTagitem::className() => [
        'tableName' => '{{%news_tagitem}}',
    ],
    NewsTagitemI18n::className() => [
        'tableName' => '{{%news_tagitem_i18n}}',
    ],
    NewsTagsArticles::className() => [
        'tableName' => '{{%news_tags_articles}}',
    ],

];
