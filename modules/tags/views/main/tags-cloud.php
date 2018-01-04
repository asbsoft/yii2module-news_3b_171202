<?php
    /* @var $this asb\yii2\common_2_170212\web\UniView */
    /* @var $tagModels[] asb\yii2\modules\news_3b_171202\modules\tags\models\NewsTagitem */
    /* @var $tagCounts[] integer */

    use yii\helpers\Html;


    $assets = $this->context->module->registerAsset('MainTagsAsset', $this);

    $actionListByTag = '/' . $this->context->module->module->uniqueId . '/main/list-for-tag'; // link from module-container

    $tc = $this->context->tcModule;

    $min = $this->context->minCountShowTag;
    $max = $this->context->maxCount;
    if (!function_exists('countRange')) {
        function countRange($value, $min, $max)
        {
            $range = 7; // 7 fonts: font-0 ... font-6
            $val = $value - $min;
            $rate = intval(round($range * $val / $max));
            return $rate;
        }
    }

?>
<div class="tags-cloud">
<?php if (!count($tagModels) == 0): ?>

    <h3><?= Yii::t($tc, 'Popular news subject') ?></h3>

    <?php foreach ($tagModels as $model):
              $fontClass = 'font-' . countRange($tagCounts[$model->id], $min, $max);
    ?>
        <div class="tags-cloud-item <?= $fontClass ?>">
            <?= Html::a($model->title, [$actionListByTag, 'id' => $model->id], [
                'class' => 'link-tags-cloud-item',
            ]) ?>
            <span class="tags-cloud-item-count"><?= "({$tagCounts[$model->id]})" ?></span>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
<br style="clear:both" />
</div>
