<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $models array of asb\yii2\modules\news_3b_171202\models\News */
    /* @var $title string|null|false */

    use yii\helpers\Html;


    $thumbnailWidth = '50px';
    
    $assets = $this->context->module->registerAsset('FrontAsset', $this);

    $tc = $this->context->tcModule;

    $lh = $this->context->module->langHelper;
    $langCode = $lh::normalizeLangCode(Yii::$app->language);

    if ($title === null) {
        $title = Yii::t($tc, 'Latest news'); // default
    }

?>
<div class="latest-news">
    <?php if ($models): ?>
        <?php if ($title): ?>
           <h3><?= Html::encode($title) ?></h3>
        <?php endif; ?>

        <table class="table-bordered">
        <tr style="vertical-align: top">
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
        </tr>
        </table>
    <?php endif; ?>
</div>
