<?php
class Migration_organisasi extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'kd_bidang' => array('type' => 'INT','default'=>null),
            'kd_unit' => array('type' => 'INT','default'=>null),
            'kd_subunit' => array('type' => 'INT','default'=>null),
            'kd_upb' => array('type' => 'INT','default'=>null),
            'nama' => array('type' => 'VARCHAR','constraint' => 255),
            'alamat' => array('type' => 'TEXT','default'=>null),
            'telpon' => array('type' => 'VARCHAR','constraint'=>15,'default'=>null),
            'kepala_nip' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'kepala_nama' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'pengurus_nip' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'pengurus_nama' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'sub_dari' => array('type' => 'INT','constraint' => 11, 'default'=>null),
            'jenis' => array('type' => 'TINYINT','constraint' => 1),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('organisasi');
    }

    public function down() {
        $this->dbforge->drop_table('organisasi');
    }
}