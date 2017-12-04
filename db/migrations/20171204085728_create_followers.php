<?php


use Phinx\Migration\AbstractMigration;

class CreateFollowers extends AbstractMigration
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
        $followers = $this->table('followers');
        $followers
            ->addColumn('user_id', 'integer')
            ->addColumn('follower_id', 'integer')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP',
                                                   'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['user_id', 'follower_id'], ['unique' => true])
            ->addForeignKey(['user_id'], 'users', 'id')
            ->addForeignKey(['follower_id'], 'users', 'id')
            ->create();
    }
}
