<?php


use Phinx\Migration\AbstractMigration;

class MyFirstMigration extends AbstractMigration
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
        $sessions = $this->table('sessions');
        $sessions
            ->addColumn('session_id', 'string', ['limit' => 255])
            ->addColumn('data', 'text')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP',
                                                   'update' => 'CURRENT_TIMESTAMP'])
            ->create();

        $threads = $this->table('threads');
        $threads
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('deleted_flag', 'binary', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP',
                                                   'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex('')
            ->create();

        $posts = $this->table('posts');
        $posts
            ->addColumn('user_id', 'integer', ['null' => true, 'default' => NULL])
            ->addColumn('thread_id', 'integer')
            ->addColumn('body', 'text')
            ->addColumn('modified_flag', 'binary', ['default' => 0])
            ->addColumn('deleted_flag', 'binary', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP',
                                                   'update' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('user_id', 'users', 'id')
            ->addForeignKey('thread_id', 'thread', 'id')
            ->create();

        $users = $this->table('users');
        $users
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('icon', 'string', ['limit' => 255])
            ->addColumn('profile', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP',
                                                   'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex('email', ['unique' => true])
            ->create();
    }
}
