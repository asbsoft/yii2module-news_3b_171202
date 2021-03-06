<?php

/* @var $this yii\web\View */
/* @var $model asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */

    use yii\helpers\Html;

    $tc = $this->context->tcModule;

    $this->title = Yii::t($tc, 'Create news tag');
    $this->params['breadcrumbs'][] = ['label' => Yii::t($tc, 'News tags'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-tagitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
