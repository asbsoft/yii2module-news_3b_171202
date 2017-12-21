<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author ASB <ab2014box@gmail.com>
 */
class MainTagsAsset extends AssetBundle
{
    public $css = [
        'news-tags-main.css',
    ];

    //public $js = [];
    //public $jsOptions = ['position' => View::POS_BEGIN];

    public $depends = [
        'asb\yii2\common_2_170212\assets\BootstrapCssAsset', // add only CSS - need to move up 'bootstrap.css' in <head>s of render HTML-results
    ];

    public function init() {
        parent::init();
        $this->sourcePath = __DIR__ . '/main';
    }
}
