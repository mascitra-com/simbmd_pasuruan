<?php
class Migration_kategori extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'kd_golongan' => array('type' => 'INT','default'=>NULL),
            'kd_bidang' => array('type' => 'INT','default'=>NULL),
            'kd_kelompok' => array('type' => 'INT','default'=>NULL),
            'kd_subkelompok' => array('type' => 'INT','default'=>NULL),
            'kd_subsubkelompok' => array('type' => 'INT','default'=>NULL),
            'nama' => array('type' => 'VARCHAR','constraint' => 255),
            'jenis' => array('type' => 'TINYINT','constraint' => 1),
            'umur_ekonomis' => array('type' => 'INT','constraint' => 3),
            'sub_dari' => array('type' => 'INT','constraint' => 11,'default'=>NULL),
            'jenis' => array('type' => 'TINYINT','constraint' => 1,'default'=>1),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('kategori');
    }

    public function down() {
        $this->dbforge->drop_table('kategori');
    }
}