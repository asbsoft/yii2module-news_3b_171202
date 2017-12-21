<?php //echo __FILE__;
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $model asb\yii2\modules\news_1b_160430\models\News|empty */
    /* @var $modelI18n asb\yii2\modules\news_1b_160430\models\NewsI18n|empty */
    /* @var $datetimes array */

    $tagsModuleId = 'tags';
    $actionListTags = $this->context->module->uniqueId . '/' . $tagsModuleId . '/main/tags-list'; // fromsubmodule

?>
<?php $this->startParent(); ?>
    <?php $this->startBlock('article/subtitle') ?>

        <?php $this->parentBlock(); ?>

        <?php if ($model) echo Yii::$app->runAction($actionListTags, ['id' => $model->id]); ?>

    <?php $this->stopBlock('article/subtitle') ?>
<?php $this->stopParent(); ?>

