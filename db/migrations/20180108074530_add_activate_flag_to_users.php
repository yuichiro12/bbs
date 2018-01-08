<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddActivateFlagToUsers extends AbstractMigration
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
        $users = $this->table('users');
        $users->addColumn('activated_flag', 'integer',
                          ['limit' => MysqlAdapter::INT_TINY,
                           'default' => 0,
                           'after' => 'profile'
                          ])
            ->save();
    }

    public function down()
    {
        $users = $this->table('users');
        $users->removeColumn('activated_flag')->save();
    }
}
