<?php

use asb\yii2\modules\news_3b_171202\modules\tags\Module;
use asb\yii2\modules\news_3b_171202\modules\tags\models\TagsArticles;

use yii\db\Migration;

/**
 * @author ASB <ab2014box@gmail.com>
 */
class m171203_122503_tags_articles_table extends Migration
{
    protected $tableName = '{{%news_tags_articles}}';
    protected $idxNamePrefix = 'idx_news_tags_articles';
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
            'tagitem_id' => $this->integer()->notNull(),
            'news_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex("{$this->idxNamePrefix}_tagitem_id",   $this->tableName, 'tagitem_id');
        $this->createIndex("{$this->idxNamePrefix}_news_id",   $this->tableName, 'news_id');
    }

    public function safeDown()
    {
        //echo basename(__FILE__, '.php') . " cannot be reverted.\n";
        //return false;

        $this->dropTable($this->tableName);
    }

}
