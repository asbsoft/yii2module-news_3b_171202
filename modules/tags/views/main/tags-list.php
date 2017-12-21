<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $models[] asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */

    use yii\helpers\Html;


    $assets = $this->context->module->registerAsset('MainTagsAsset', $this);

    $actionListByTag = '/' . $this->context->module->module->uniqueId . '/main/list-for-tag'; // link from module-container

    $tc = $this->context->tcModule;

?>
<div class="tags-list">
<?php if (count($models) == 0): ?>
<!--
    <div id="no-tags" class="b dfn"><?= Yii::t($tc, 'No tags assigned yet') ?></div>
-->
<?php else: ?>

    <?php foreach ($models as $model): ?>
        <div class="tags-list-item">
            <?= Html::a($model->title, [$actionListByTag, 'id' => $model->id], [
                'class' => 'link-tags-list-item'
            ]) ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
<br style="clear:both" />
</div>
