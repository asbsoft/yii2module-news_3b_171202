<?php
/* @var $this asb\yii2\common_2_170212\web\UniView */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tagModel asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */
?>
<?php if (!empty($tagModel->title)): ?>
    <?php $this->beginBlock('list-for-tag-title') ?>
        <h1><?= $tagModel->title ?></h1>
        <h2><?= Yii::t($this->context->tc, 'News') ?></h2>
    <?php $this->endBlock() ?>
<?php endif; ?>
<?php
   echo $this->render('list', ['dataProvider' => $dataProvider], $this->context);
?>
