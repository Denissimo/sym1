<?php


use Phinx\Migration\AbstractMigration;

class CreateTableStatuses extends AbstractMigration
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
        $table = $this->table('app_status');
        $table->addColumn('sort', 'integer')
            ->addColumn('color_name', 'string', ['limit' => 16])
            ->addColumn('color', 'string', ['limit' => 6])
            ->addColumn('style', 'string', ['limit' => 16])
            ->addColumn('picture', 'string', ['limit' => 64])
            ->create();

        $rows = [
            [
                'sort'  => '100',
                'color_name'  => 'red',
                'color'  => 'dc3545',
                'style'  => 'bg-danger',
                'picture'  => 'color_red.png'
            ],
            [
                'sort'  => '200',
                'color_name'  => 'yellow',
                'color'  => 'ffc107',
                'style'  => 'bg-warning',
                'picture'  => 'color_yellow.png'
            ],
            [
                'sort'  => '300',
                'color_name'  => 'white',
                'color'  => 'ffffff',
                'style'  => '',
                'picture'  => 'color_white.png'
            ],
            [
                'sort'  => '400',
                'color_name'  => 'cyan',
                'color'  => '17a2b8',
                'style'  => 'bg-info',
                'picture'  => 'color_cyan.png'
            ],
            [
                'sort'  => '500',
                'color_name'  => 'blue',
                'color'  => '007bff',
                'style'  => 'bg-primary',
                'picture'  => 'color_blue.png'
            ]
        ];

        $this->table('app_status')->insert($rows)->save();
    }
}
