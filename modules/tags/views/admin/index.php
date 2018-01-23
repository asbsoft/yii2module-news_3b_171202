<?php

    /* @var $this yii\web\View */
    /* @var $searchModel asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitemSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */
    /* @var $currentId integer current item id */

    use asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagsArticles;

    use asb\yii2\common_2_170212\widgets\grid\ButtonedActionColumn;
    use asb\yii2\common_2_170212\widgets\Alert;

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\GridView;

    $gridHtmlClass = 'news-tags-list-grid';

    $tc = $this->context->tcModule;
    $tcRoot = $this->context->module->module->tcModule;

    $title = Yii::t($tc, 'News tags');
    $this->title = Yii::t($tcRoot, 'Adminer') . ' - ' . $title;

    $this->params['breadcrumbs'][] = [
        'label' => Html::encode($title),
        'url' => Url::to(['index']),
    ];

    $langCode = $this->context->langCodeMain;

?>
<div class="news-tagitem-index">

    <h1><?= Html::encode($title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-md-12">
        <?= Alert::widget(); ?>
    </div>

    <p>
        <?= Html::a(Yii::t($tc, 'Create news tag'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => $gridHtmlClass],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            [
                'attribute' => 'title',
                'options' => [
                    'class' => 'col-md-5',
                ],

            ],
            'create_time',
            'update_time',
            [
                'attribute' => 'is_visible',
                'label' => Yii::t($tc, 'Is visible'),
                'format' => 'boolean',
                'filter' => [
                    true  => Yii::t('yii', 'Yes'),
                    false => Yii::t('yii', 'No'),
                ],
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => '-' . Yii::t($tc, 'any') . '-'],
                'content' => function ($model, $key, $index, $column) {
                    return $model->is_visible ? Yii::t('yii', 'Yes')
                        : '<span class="bg-danger">' . Yii::t('yii', 'No') . '</span>';
                },
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'options' => [
                    //'style' => 'width:85px',
                    //'class' => 'width-min',
                    'class' => 'col-md-1',
                ],
            ],
            [
                //'label' => Yii::t($this->context->tcModule, 'ID'),
                'attribute' => 'id',
                //'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-right'],
                'options' => [
                    //'class' => 'width-min',
                    //'class' => 'col-md-1',
                    'style' => 'width:70px'
                ],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'style' => 'padding:5px',
                    //'maxlength' => 6,
                ],
            ],
            [
                'class' => ButtonedActionColumn::className(), // 'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t($tc, 'Actions'),
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-right'],
                'options' => [
                    'class' => 'col-md-1',
                ],
            ],
            [
                'header' => Yii::t($tc, 'Articles') . " ({$langCode})",
                'content' => function ($model, $key, $index, $column) use ($langCode) {
                    return NewsTagsArticles::countArticles($model->id, $langCode);
                },
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-right'],
                'options' => [
                    //'class' => 'col-md-1',
                    'style' => 'width:70px'
                ],
            ],
        ],
    ]); ?>
</div>

<?php
    $this->registerJs("
        jQuery('.{$gridHtmlClass} table tr').each(function(index) {
            var elem = jQuery(this);
            var id = elem.attr('data-key');
            if (id == '{$currentId}') {
               elem.addClass('bg-success'); //?? overwrite by .table-striped > tbody > tr:nth-of-type(2n+1)
               elem.css({'background-color': '#DFD'}); // work always
            }
        });
    ");
?>
