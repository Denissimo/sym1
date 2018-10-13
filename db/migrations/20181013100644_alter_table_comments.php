<?php


use Phinx\Migration\AbstractMigration;

class AlterTableComments extends AbstractMigration
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

        $this->execute('DROP TRIGGER `comments_BEFORE_INSERT`');
        $this->execute('DROP TRIGGER `comments_BEFORE_UPDATE`');
        $this->execute('UPDATE comments SET ctype = 10 WHERE ctype = 0');


        $this->execute('ALTER TABLE comments
                    ADD CONSTRAINT comtype
                    FOREIGN KEY(ctype)
                    REFERENCES comment_types(id)
                    ON DELETE CASCADE ON UPDATE CASCADE'
        );

    }
}
