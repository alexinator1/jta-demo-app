<?php

use yii\db\Migration;

class m160417_145733_add_user_group_junction_table extends Migration
{
    public $table = "{{%user_group}}";

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->table, [
            'user_id' => $this->integer(),
            'group_id' => $this->integer(),
            'joined_at' => $this->timestamp(),
            'role' => $this->string(),
        ], $tableOptions);

        $this->createIndex('user_id_ind',$this->table, 'user_id');
        $this->createIndex('group_id_ind',$this->table, 'group_id');


        $this->addForeignKey('ug_fk_user_id', $this->table, 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('ug_fk_group_id', $this->table, 'group_id', 'group', 'id', 'CASCADE');

    }
    public function down()
    {
        $this->dropTable($this->table);
    }
}
