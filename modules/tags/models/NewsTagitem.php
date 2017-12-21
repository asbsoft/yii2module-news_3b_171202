<?php

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use asb\yii2\modules\news_3b_171202\modules\tags\Module;

use asb\yii2\common_2_170212\models\DataModelMultilang;

use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "{{%news_tagitem}}".
 *
 * @property integer $id
 * @property integer $is_visible
 * @property string $create_time
 * @property string $update_time
 *
 * @property NewsTagitemI18n[] $newsTagitemI18ns
 */
class NewsTagitem extends DataModelMultilang
{
    public static $i18n_join_model = 'NewsTagitemI18n';
    public static $i18n_join_prim_key = 'tagitem_id';

    /** Default order in list */
  //public static $defaultOrderBy = ['id' => SORT_ASC];
    public static $defaultOrderBy = ['title' => SORT_ASC];

    public $languages;
    public $langCodeMain;

    // multilang property
    public $title;

/* move to config/params.php:
    public static function tableName()
    {
        return '{{%news_tagitem}}';
    }
*/

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->module)) {
            $this->module = Module::getModuleByClassname(Module::className());
        }

        $langHelper = $this->module->langHelper;
        $editAllLanguages = empty($this->module->params['editAllLanguages']) ? false : $this->module->params['editAllLanguages'];
        $this->languages = $langHelper::activeLanguages($editAllLanguages);
        if (empty($this->langCodeMain) ) {
            $this->langCodeMain = $langHelper::normalizeLangCode(Yii::$app->language);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_visible'], 'boolean'],
            //[['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t($this->tcModule, 'ID'),
            'is_visible' => Yii::t($this->tcModule, 'Is visible'),
            'create_time' => Yii::t($this->tcModule, 'Create time'),
            'update_time' => Yii::t($this->tcModule, 'Update time'),
            'title' => Yii::t($this->tcModule, 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTagitemI18ns()
    {
        return $this->hasMany(NewsTagitemI18n::className(), ['tagitem_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return NewsTagitemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsTagitemQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = new Expression('NOW()');
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @param array $attributeNames list of attribute names that should be validated.
     * If this parameter is empty, it means any attribute listed in the applicable validation rules should be validated.
     * @param boolean $clearErrors whether to call [[clearErrors()]] before performing validation
     * @return boolean whether the validation is successful without any error.
     * @throws InvalidParamException if the current scenario is unknown.
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $result = parent::validate($attributeNames, $clearErrors);
        return $result;
    }

    /**
     * @inheritdoc
     * Save multilang data in transaction.
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }
        $transaction = static::getDb()->beginTransaction();
        try {
            $result = parent::save($runValidation, $attributeNames);
            if ($result) {
                $result = $this->saveMultilang(); // save multilang models
            }
        } catch (Exception $e) {
            $transaction->rollBack();

            $msg = Yii::t($this->tcModule, 'Saving unsuccessfull');
            $msgFull = Yii::t($this->tcModule, 'Saving unsuccessfull by the reason') . ': ' . $e->getMessage();
            Yii::error($msgFull);
            $showError = isset($this->module->params['showAdminSqlErrors']) && $this->module->params['showAdminSqlErrors'];
            Yii::$app->session->setFlash('error', $showError ? $msgFull : $msg);
            return false;
        }
        if ($result) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }
        return $result;
    }

    /**
     * @inheritdoc
     * Delete also joined links to news-articles.
     */
    public function delete()
    {
        $mta = $this->module->model('NewsTagsArticles');

        $mtaModels = $mta::find()->where(['tagitem_id' => $this->id])->all();
        foreach ($mtaModels as $model) {
            $model->delete();
        }

        return parent::delete();
    }

}
