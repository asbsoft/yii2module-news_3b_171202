<?php

/* @var $this yii\web\View */
/* @var $model asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\widgets\DetailView;


    $tc = $this->context->tcModule;

    $lh = $this->context->module->langHelper;
    $editAllLanguages = empty($this->context->module->params['editAllLanguages'])
                      ? false : $this->context->module->params['editAllLanguages'];
    $languages = $lh::activeLanguages($editAllLanguages);

    $modelsI18n = $model->i18n;

    $titleAttributes = [];
    foreach ($languages as $langCode => $lang) {
        $value = empty($modelsI18n[$langCode]->title) ? '' : $modelsI18n[$langCode]->title;
        $titleAttributes[] = [
            'label' => '&nbsp;-&nbsp;' . $lang->name_orig,
            'value' => $value ?: Yii::t($tc, '<empty>'),
        ];
    }
    $this->title = Yii::t($tc, 'News tag') . ' #' . $model->id;
    $this->params['breadcrumbs'][] = ['label' => Yii::t($tc, 'News tags'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-tagitem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t($tc, 'Return to list'), ['index'
              , 'page' => $model->page, 'id' => $model->id
            ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => ArrayHelper::merge([
            'id',
            [
                'attribute' => 'is_visible',
                'value' => $model->is_visible ? Yii::t('yii', 'Yes') : Yii::t('yii', 'No'),
            ],
            'create_time',
            'update_time',
            [
                'attribute' => 'title',
                'value' => '',
            ],
        ], $titleAttributes),
    ]) ?>

</div>
