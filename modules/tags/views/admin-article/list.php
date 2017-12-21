<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $models[] asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;


    $formAction = 'admin-article/del';

    $tc = $this->context->tcModule;

    $assets = $this->context->module->registerAsset('AdminTagsAsset', $this);

?>
<div id="tags-list">
<?php if (count($models) == 0): ?>
    <div id="no-tags" class="b dfn"><?= Yii::t($tc, 'No tags assigned yet') ?></div>
<?php else: ?>
    <?= Html::beginForm([$formAction, 'id' => $id], 'post') ?>
        <div class="col-sm-9">
            <?= Html::checkboxList($this->context->fieldsListName, null, ArrayHelper::map($models, 'id', 'title'), [
                'id' => 'checkbox-list',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::submitButton(Yii::t($tc, 'Delete marked tag(s)'), [
                'id' => 'btn-del-tags',
                'class' => 'btn btn-danger',
            ]) ?>
        </div>
    <?= Html::endForm() ?>
<?php endif; ?>
<br style="clear:both" />
</div>

<?php
    $msgNoSelected = addslashes(Yii::t($tc, 'No selected tags'));
    $msgConfirmDelete = addslashes(Yii::t($tc, 'Delete selected tags?'));
    $this->registerJs("
        jQuery('#btn-del-tags').bind('click', function() {
            var count = jQuery('#checkbox-list input:checked').length;
            if (count == 0) {
                alert('{$msgNoSelected}');
                return false;
            } else {
                return confirm('{$msgConfirmDelete}');
            }
        });
    ");
?>
