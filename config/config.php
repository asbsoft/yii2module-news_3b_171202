<?php
// Config of inherited module-package
//!! only add changes - they will merged with parent

use asb\yii2\common_2_170212\base\UniApplication;

$type = empty(Yii::$app->type) ? false : Yii::$app->type;//var_dump($type);

return  [
    'bootstrap' => [
        'tags'
    ],
    'modules' => [
        'tags' => [
            'class' => 'asb\yii2\modules\news_3b_171202\modules\tags\Module',
            'routesConfig' => [ // type => prefix|config
                'admin' => [
                    // redefine default sublink for routes-category 'admin':
                    'urlPrefix' => $type == UniApplication::APP_TYPE_FRONTEND ? false : 'tags',
                ],

                'main'  => [
                    // redefine default sublink for routes-category 'main':
                    'urlPrefix' => $type == UniApplication::APP_TYPE_BACKEND  ? false : 'tags',
                ],
            ],
        ],
    ],
];
