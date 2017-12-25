
News-3: Demonstration of modules inheritance
============================================

Basic (ancestor) module-package is news_2b_161124, which inherited module-package news_1b_160430.

New feature(s) in version news_3b_171202:
- Add submodule "tags".
  Every news can belong to category(es) describes by tag(s)
  You can add anywhere in view-templates list of news tags by widget-action:
    <?= Yii::$app->runAction("NEWS_MODULE_UNIQUE_ID/tags/main/tags-cloud") ?>
  or if use content-module asbsoft/yii2module-content_2_170309 any content-page can contain:
    {{%render action='NEWS_MODULE_UNIQUE_ID/tags/main/tags-cloud'}}
- Add widget-action "latest news". 
  It can be used in view-template:
    <?= Yii::$app->runAction("NEWS_MODULE_UNIQUE_ID/main/latest-news", ['count' => NN]) ?>
  or in content-page of asbsoft/yii2module-content_2_170309:
    {{%render action='NEWS_MODULE_UNIQUE_ID/main/latest-news', count=NN}}

You can set parent module news_1b_160430 instead of news_2b_161124
and lost functionality from news_2b_161124 (news backup/restore and slugs for URLs).
For this you have to modify such files:
- Module.php
- config/routes-admin.php, routes-main.php
- controllers/AdminController.php, MainController.php
