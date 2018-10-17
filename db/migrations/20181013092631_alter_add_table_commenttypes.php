<?php


use Phinx\Migration\AbstractMigration;

class AlterAddTableCommenttypes extends AbstractMigration
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
        $table = $this->table('comment_types',
            [
                'id' => false,
                'primary_key' => 'id',
            ]);
        $table
            ->addColumn( 'id', 'integer', ['signed' => false] )
            ->addColumn( 'name', 'string' )
            ->addColumn( 'value', 'string' )
            ->addColumn( 'app_status', 'integer' )
            ->create();

        $table = $this->table('comment_types')
            ->insert(
            [
                ['id' => 1, 'name' => 'recall', 'value' => 'Перезвонить', 'app_status' => 1],
                ['id' => 2, 'name' => 'busy', 'value' => 'Занято', 'app_status' => 2],
                ['id' => 3, 'name' => 'no_answer', 'value' => 'Не отвечает', 'app_status' => 2],
                ['id' => 4, 'name' => 'unawailable', 'value' => 'Недоступен', 'app_status' => 2],
                ['id' => 5, 'name' => 'drops', 'value' => 'Скидывает', 'app_status' => 2],
                ['id' => 6, 'name' => 'not_actual', 'value' => 'Не актуально', 'app_status' => 3],
                ['id' => 7, 'name' => 'wrong', 'value' => 'Неправильный номер', 'app_status' => 3],
                ['id' => 8, 'name' => 'moron', 'value' => 'Неадекват', 'app_status' => 3],
                ['id' => 9, 'name' => 'process', 'value' => 'Обработать', 'app_status' => 1],
                ['id' => 10, 'name' => 'comment', 'value' => 'Другое', 'app_status' => 2]
            ]
        )->save();
    }
}
