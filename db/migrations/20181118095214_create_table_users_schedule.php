<?php


use Phinx\Migration\AbstractMigration;

class CreateTableUsersSchedule extends AbstractMigration
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
        $table = $this->execute(
            'CREATE TABLE users_schedule (
          id int(11) NOT NULL AUTO_INCREMENT,
          user_id int(11) DEFAULT NULL,
          enabled tinyint(1) UNSIGNED DEFAULT NULL,
          type tinyint(1) UNSIGNED DEFAULT 0,
          date_from datetime DEFAULT NULL,
          date_to datetime DEFAULT NULL,
          PRIMARY KEY (id)
        )
        ENGINE = INNODB,
        AUTO_INCREMENT = 10,
        AVG_ROW_LENGTH = 2048,
        CHARACTER SET utf8,
        COLLATE utf8_general_ci;
        
        ALTER TABLE users_schedule1
        ADD CONSTRAINT FK_users_schedule_user_id FOREIGN KEY (user_id)
        REFERENCES users (id);'
        );
    }
}
