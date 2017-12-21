<?php

use asb\yii2\modules\news_3b_171202\modules\tags\Module;
use asb\yii2\modules\news_3b_171202\modules\tags\models\TagitemI18n;
use asb\yii2\modules\news_3b_171202\modules\tags\models\Tagitem;

use yii\db\Migration;

/**
 * @author ASB <ab2014box@gmail.com>
 */
class m171203_122502_tagitem_i18n_table extends Migration
{
    protected $tableNameI18n = '{{%news_tagitem_i18n}}';
    protected $tableName     = '{{%news_tagitem}}';
    protected $idxNamePrefix = 'idx_news_tagitem_i18n';
    protected $fkName        = 'fk_news_tagitem_i18n';

    public function init()
    {
        parent::init();
/*
        $this->tableNameI18n = TagitemI18n::tableName();
        $this->tableName     = Tagitem::tableName();
        $this->idxNamePrefix = 'idx_' . TagitemI18n::basetableName();
        $this->fkName        = 'fk_' . TagitemI18n::basetableName();
*/
    }
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableNameI18n, [
            'id' => $this->primaryKey(),
            'tagitem_id' => $this->integer()->notNull(),
            'lang_code' => $this->string(5)->notNull(),
            'title' => $this->string(255),
        ], $tableOptions);
        $this->createIndex("{$this->idxNamePrefix}_tagitem_id",  $this->tableNameI18n, 'tagitem_id');
        $this->addForeignKey($this->fkName, $this->tableNameI18n, 'tagitem_id', $this->tableName, 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        //echo basename(__FILE__, '.php') . " cannot be reverted.\n";
        //return false;

        $this->dropForeignKey($this->fkName, $this->tableNameI18n);
        $this->dropTable($this->tableNameI18n);
    }

}
