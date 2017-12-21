<?php

/* @var $this yii\web\View */
/* @var $model asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemSearch */
/* @var $form yii\widgets\ActiveForm */

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $tc = $this->context->tcModule;

?>
<div class="news-tagitem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_visible') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('yii', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
