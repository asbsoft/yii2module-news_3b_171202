<?php

    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $count integer */
    /* @var $models array of asb\yii2\modules\news_3b_171202\models\News */
    /* @var $title string|null|false */
    /* @var $emptyIfNothing boolean */
    /* @var $options array */

    use yii\helpers\Html;


    $thumbnailWidth = '50px';
    $titleCss = !empty($options['titleCss']) ? $options['titleCss'] : 'class="h3"';
    $noNewsMessageCss = !empty($options['noNewsMessageCss']) ? $options['noNewsMessageCss'] : 'class="text-center"';

    
    $assets = $this->context->module->registerAsset('FrontAsset', $this);

    $tc = $this->context->tcModule;

    $lh = $this->context->module->langHelper;
    $langCode = $lh::normalizeLangCode(Yii::$app->language);

    if ($title === null) {
        $title = Yii::t($tc, 'Latest news'); // default
    }
    $noNewsMessage = Yii::t($tc, 'no latest news');


?>
<?php if (!$emptyIfNothing || $count): ?>
<div class="latest-news">
    <?php if ($models): ?>
        <?php if ($title): ?>
           <div <?= $titleCss?>><?= Html::encode($title) ?></div>
        <?php endif; ?>

        <table class="table-bordered">
        <tr style="vertical-align: top">

        <?php if ($count === 0): ?>
            <div <?= $noNewsMessageCss?>><?= Html::encode($noNewsMessage) ?></div>
        <?php else: ?>
            <?php foreach ($models as $model): ?>
                <td>
                    <?php
                        if(!empty($model->image)) {
                            $imgSrc = $this->context->uploadsNewsUrl . '/' . $model->image;
                        } else {
                            $imgSrc = $assets->baseUrl . '/img/no-picture.jpg';
                          //$imgSrc = false;
                        }
                    ?>
                    <?php if ($imgSrc) {
                              echo Html::img($imgSrc, [
                                  'class' => 'thumbnail pull-left latest-news-img',
                                  'style' => "width: {$thumbnailWidth}",
                              ]);
                          } ?>

                    <span class="latest-news-link">
                        <?= Html::encode($model->title) ?>
                        <?php
                            $slug = $model->getSlug($langCode);
                            if (empty($slug)) {
                                $route = ['view', 'id' => $model->id];
                            } else {
                                $route = ['view-by-slug', 'slug' => $slug];
                            }
                        ?>
                        <?= Html::a(Html::encode(">>>"), $route, [
                                'title' => Html::encode($model->title),
                            ]) ?>
                    </span>
                </td>
            <?php endforeach; ?>
        <?php endif; ?>

        </tr>
        </table>
    <?php endif; ?>
</div>
<?php endif; ?>
