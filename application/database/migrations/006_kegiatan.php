<?php
class Migration_kegiatan extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'kode' => array('type' => 'VARCHAR','constraint' => 255),
            'nama' => array('type' => 'VARCHAR','constraint' => 255),
            'tahun' => array('type' => 'YEAR'),
            'id_organisasi' => array('type' => 'INT','constraint' => 11),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('kegiatan');
    }

    public function down() {
        $this->dbforge->drop_table('kegiatan');
    }
}