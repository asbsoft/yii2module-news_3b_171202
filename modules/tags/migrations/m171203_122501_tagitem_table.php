<?php

use asb\yii2\modules\news_3b_171202\modules\tags\Module;
use asb\yii2\modules\news_3b_171202\modules\tags\models\Tagitem;

use yii\db\Migration;

/**
 * @author ASB <ab2014box@gmail.com>
 */
class m171203_122501_tagitem_table extends Migration
{
    protected $tableName = '{{%news_tagitem}}';
    protected $idxNamePrefix = 'idx_news_tagitem';
/* tmp
    protected $tableName;
    protected $idxNamePrefix;
*/
    public function init()
    {
        parent::init();
/* tmp
        $this->tableName     = Tagitem::tableName();
        $this->idxNamePrefix = 'idx_' . Tagitem::baseTableName();
*/
    }
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id'          => $this->primaryKey(),
            'is_visible'  => $this->boolean()->notNull()->defaultValue(false),
            'create_time' => $this->datetime()->notNull(),
            'update_time' => $this->timestamp(),
        ], $tableOptions);
        $this->createIndex("{$this->idxNamePrefix}_is_visible",   $this->tableName, 'is_visible');
    }

    public function safeDown()
    {
        //echo basename(__FILE__, '.php') . " cannot be reverted.\n";
        //return false;

        $this->dropTable($this->tableName);
    }

}
