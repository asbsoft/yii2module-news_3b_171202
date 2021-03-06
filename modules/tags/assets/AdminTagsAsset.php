<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author ASB <ab2014box@gmail.com>
 */
class AdminTagsAsset extends AssetBundle
{
    public $css = [
        'news-tags-admin.css',
    ];

    //public $js = [];
    //public $jsOptions = ['position' => View::POS_BEGIN];

    public $depends = [
        'yii\bootstrap\BootstrapAsset', // add only CSS - need to move up 'bootstrap.css' in <head>s of render HTML-results
    ];

    public function init() {
        parent::init();
        $this->sourcePath = __DIR__ . '/admin';
    }
}
