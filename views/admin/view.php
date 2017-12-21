<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $model asb\yii2\modules\news_1b_160430\models\News */
    /* @var $modelsI18n array of asb\yii2\modules\news_1b_160430\models\NewsI18n */
    /* @var $page integer */

    use asb\yii2\common_2_170212\widgets\Alert;


    $tagsModuleId = 'tags';
    $actionFormTags = $this->context->module->uniqueId . '/' . $tagsModuleId . '/admin-article/form';
    $actionListTags = $this->context->module->uniqueId . '/' . $tagsModuleId . '/admin-article/list';

    $tc = $this->context->tcModule;

?>
<?php $this->startParent(); ?>

    <?php $this->startBlock('header'); ?>

        <?php $this->parentBlock(); ?>

        <?php echo Alert::widget(); ?>

    <?php $this->stopBlock('header'); ?>

    <?php $this->startBlock('beforeShowFrontend'); ?>

        <h4><?= Yii::t($tc, 'Tags assignment') ?></h4>

        <?= Yii::$app->runAction($actionFormTags, ['id' => $model->id]); ?>

        <?= Yii::$app->runAction($actionListTags, ['id' => $model->id]); ?>

    <?php $this->stopBlock('beforeShowFrontend'); ?>

<?php $this->stopParent(); ?>
