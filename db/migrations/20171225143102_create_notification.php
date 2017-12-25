<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateNotification extends AbstractMigration
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
    public function change()
    {
        $notification = $this->table('notification', ['collation' => 'utf8mb4_general_ci']);
        $notification
            ->addColumn('user_id', 'integer')
            ->addColumn('message', 'string', ['limit' => 255])
            ->addColumn('icon', 'string', ['limit' => 255])
            ->addColumn('url', 'string', ['limit' => 255])
            ->addColumn('read_flag', 'integer',
                        ['limit' => MysqlAdapter::INT_TINY,
                         'default' => 0])
            ->addColumn('created_at', 'datetime',
                        ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime',
                        ['default' => 'CURRENT_TIMESTAMP',
                         'update' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey(['user_id'], 'users', 'id')
            ->create();
    }
}
