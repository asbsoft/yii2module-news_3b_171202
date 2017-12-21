<?php // UTF-8

namespace asb\yii2\modules\news_3b_171202\modules\tags\models;

use asb\yii2\modules\news_3b_171202\modules\tags\Module;

use asb\yii2\common_2_170212\models\DataModel;

use Yii;

/**
 * This is the model class for table "{{%news_tagitem_i18n}}".
 *
 * @property integer $id
 * @property integer $tagitem_id
 * @property string $lang_code
 * @property string $title
 *
 * @property NewsTagitem $tagitem
 */
class NewsTagitemI18n extends DataModel
{

/* move to config/params.php:
    public static function tableName()
    {
        return '{{%news_tagitem_i18n}}';
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
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['tagitem_id', 'integer'],
            ['tagitem_id', 'exist', 'skipOnError' => true, 'targetClass' => NewsTagitem::className(), 'targetAttribute' => ['tagitem_id' => 'id']],
            ['tagitem_id', 'required'],
            ['lang_code', 'string', 'max' => 5],
            ['title', 'string', 'max' => 255],
            ['title', 'unique',
                'targetAttribute' => ['lang_code', 'title'],
                'message' => Yii::t($this->tcModule
                  , 'such tag already used for this language {lang_code}', ['lang_code' => $this->lang_code])
            ],
            ['title', 'match',
                //'pattern' => '/^[a-zа-я0-9\.\-\ ]+$/ui',
                //'pattern' => '/^[\x{0400}-\x{04FF}0-9\.\-\ ]+$/ui',
                //'pattern' => '/^[\p{L}\p{Zs}0-9\.\-\ ]+$/ui',
                'pattern' => '|^[\p{L}\'`"0-9\.\-\ ]+$|ui',
                'message' => Yii::t($this->tcModule, 'only letters, apostrophe, digits, point, hyphen and blank')
            ],
            ['title', 'required'], // requred here for all languages together
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t($this->tcModule, 'ID'),
            'tagitem_id' => Yii::t($this->tcModule, 'Tag ID'),
            'lang_code' => Yii::t($this->tcModule, 'Lang code'),
            'title' => Yii::t($this->tcModule, 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagitem()
    {
        return $this->hasOne(NewsTagitem::className(), ['id' => 'tagitem_id']);
    }

    /**
     * @inheritdoc
     * @return NewsTagitemI18nQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsTagitemI18nQuery(get_called_class());
    }

    /**
     * Check if model has data to save.
     * Need for DataModelMultilang::saveMultilang() in main model to avoid save empty multilang data.
     * @return boolean
     */
    public function hasData()
    {
        return !empty($this->title);
    }

}
