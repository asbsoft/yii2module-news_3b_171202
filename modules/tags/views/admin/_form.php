<?php

/* @var $this yii\web\View */
/* @var $model asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */
/* @var $form yii\widgets\ActiveForm */

    use asb\yii2\common_2_170212\assets\FlagAsset;

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;


    $assetsFlag = FlagAsset::register($this);
    $assets = $this->context->module->module->registerAsset('AdminAsset', $this); // assets of module-container, not this submodule
    
    $tc = $this->context->tcModule;

    $lh = $this->context->module->langHelper;
    $editAllLanguages = empty($this->context->module->params['editAllLanguages'])
                      ? false : $this->context->module->params['editAllLanguages'];
    $languages = $lh::activeLanguages($editAllLanguages);

    $enableEditVisibility = (!Yii::$app->user->can('roleNewsModerator') && Yii::$app->user->can('roleNewsAuthor')) ? false : true;

    if (empty($activeTab)) {
        $activeTab = $this->context->langCodeMain; // default language tab pane
        if ($model->hasI18nErrors()) { // select tab pane with error
            $errorsI18n = $model->getI18nErrors();
            foreach ($errorsI18n as $activeTab => $errors) {
                break; // get language of first tab with error
            }
        }
    }

    $modelsI18n = $model->i18n;

?>
<div class="news-tagitem-form">

    <?php $form = ActiveForm::begin([
              'id' => 'form-admin',
              'enableClientValidation' => false, // disable JS-validation
          ]); ?>

        <div>
            <?php if ($enableEditVisibility): ?>
              <?= $form->field($model, 'is_visible')->checkbox() ?>
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
        </div>

        <div class="tabbable content-multilang">
            <ul class="nav nav-tabs">
                <?php // multi-lang part - tabs
                    foreach ($languages as $langCode => $lang):
                        $countryCode2 = strtolower(substr($langCode, 3, 2));
                ?>
                    <li class="<?php if ($activeTab == $langCode): ?>active<?php endif; ?>">
                        <div class="tab-field">
                            <div class="tab-link flag f16">
                                <a href="#tab-<?= $langCode ?>" data-toggle="tab"><?= $lang->name_orig ?></a>
                                <span class="flag <?= $countryCode2 ?>" title="<?= "{$lang->name_orig}" ?>"></span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php // multi-lang part - content
                  foreach ($languages as $langCode => $lang):
                      $countryCode2 = strtolower(substr($langCode, 3, 2));
                      $flag = '<span class="flag f16"><span class="flag ' . $countryCode2 . '" title="' . $lang->name_orig . '"></span></span>';
                      $labels = $modelsI18n[$langCode]->attributeLabels();
                ?>
                <div id="tab-<?= $langCode ?>"
                    class="tab-pane <?php if ($activeTab == $langCode): ?>active<?php endif; ?>"
                >
                    <?= $form->field($modelsI18n[$langCode], "[{$langCode}]title",[
                            'options' => [
                                'class'=>'content-title',
                            ],
                        ])->label($flag . ' ' . $labels['title'])
                          ->textInput() ?>
                
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t($tc, 'Create') : Yii::t($tc, 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
