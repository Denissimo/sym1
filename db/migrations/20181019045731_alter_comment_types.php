<?php


use Phinx\Migration\AbstractMigration;

class AlterCommentTypes extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('comment_types');
        $table->addColumn('date_interval', 'string', ['limit' => 8]);
        $table->addColumn('in_work', 'boolean')
            ->update();
        $this->execute('UPDATE comment_types SET date_interval = "PT0S", in_work = 0 WHERE name="recall"');
        $this->execute('UPDATE comment_types SET date_interval = "PT15M", in_work = 0 WHERE name="busy"');
        $this->execute('UPDATE comment_types SET date_interval = "PT3H", in_work = 0 WHERE name="no_answer"');
        $this->execute('UPDATE comment_types SET date_interval = "PT6H", in_work = 0 WHERE name="unawailable"');
        $this->execute('UPDATE comment_types SET date_interval = "PT30M", in_work = 0 WHERE name="drops"');
        $this->execute('UPDATE comment_types SET date_interval = "PT0S", in_work = 1 WHERE name="not_actual"');
        $this->execute('UPDATE comment_types SET date_interval = "PT0S", in_work = 1 WHERE name="wrong"');
        $this->execute('UPDATE comment_types SET date_interval = "PT0S", in_work = 1 WHERE name="moron"');
        $this->execute('UPDATE comment_types SET date_interval = "PT0S", in_work = 0 WHERE name="process"');
        $this->execute('UPDATE comment_types SET date_interval = "PT3H", in_work = 0 WHERE name="comment"');
    }
}
