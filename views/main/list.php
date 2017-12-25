<?php
/* @var $this asb\yii2\common_2_170212\web\UniView */
/* @var $dataProvider yii\data\ActiveDataProvider */

$moduleUid = $this->context->module->uniqueId;

?>
<?php $this->startParent(); ?>
    <?php $this->startBlock('title') ?>
        <?php if (empty($this->blocks['list-for-tag-title'])): ?>
            <?php $this->parentBlock() ?>
        <?php else: ?>
            <?= $this->blocks['list-for-tag-title'] ?>
        <?php endif; ?>
    <?php $this->stopBlock('title') ?>

    <?php $this->startBlock('after-page') ?>
        <?= Yii::$app->runAction("{$moduleUid}/tags/main/tags-cloud") ?>

        <?php $this->parentBlock() ?>
    <?php $this->stopBlock('after-page') ?>
<?php $this->stopParent(); ?>
