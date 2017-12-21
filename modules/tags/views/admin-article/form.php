<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $models[] asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */
    /* @var $id integer */

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;


    $formAction = 'admin-article/add';

    $tc = $this->context->tcModule;

    $items = ArrayHelper::map($models, 'id', 'title');

?>
<div id="add-tags-form" class="form-group">
    <?= Html::beginForm([$formAction, 'id' => $id], 'post') ?>
        <div class="col-sm-6">
            <?= Html::listBox($this->context->fieldsListName, null, $items, [
                'id' => 'list-box',
                'class' => 'form-control',
                'multiple' => true,
                'size' => $this->context->sizeListBoxAdmin,
            ]) ?>
        </div>
        <div class="col-sm-1">
            <?= Html::submitButton(Yii::t($tc, 'Add tag(s)'), [
                'id' => 'btn-add-tags',
                'class' => 'btn btn-primary',
            ]) ?>
        </div>
    <?= Html::endForm() ?>
    <br style="clear:both" />
</div>

<?php
    $msgNoSelected = addslashes(Yii::t($tc, 'No selected tags'));
    $this->registerJs("
        jQuery('#btn-add-tags').bind('click', function() {
            var count = jQuery('#list-box option:selected').length;
            if (count == 0) {
                alert('{$msgNoSelected}');
                return false;
            }
        });
    ");
?>
