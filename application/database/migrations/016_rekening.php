<?php
class Migration_rekening extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'kode' => array('type' => 'VARCHAR','constraint' => 255),
            'uraian' => array('type' => 'VARCHAR','constraint' => 255)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('rekening');
    }

    public function down() {
        $this->dbforge->drop_table('rekening');
    }
}