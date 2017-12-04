<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class BinaryToTinyint extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $threads = $this->table('threads');
        $threads
            ->changeColumn('deleted_flag', 'integer', ['limit' => MysqlAdapter::INT_TINY])
            ->save();

        $posts = $this->table('posts');
        $posts
            ->changeColumn('modified_flag', 'integer', ['limit' => MysqlAdapter::INT_TINY])
            ->changeColumn('deleted_flag', 'integer', ['limit' => MysqlAdapter::INT_TINY])
            ->save();

    }

    public function down()
    {
        $threads
            ->changeColumn('deleted_flag', 'binary', ['default' => 0])
            ->save();

        $posts = $this->table('posts');
        $posts
            ->changeColumn('modified_flag', 'binary', ['default' => 0])
            ->changeColumn('deleted_flag', 'binary', ['default' => 0])
            ->save();
    }
}
