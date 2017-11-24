<?php
class Migration_sp2d extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'nomor' => array('type' => 'VARCHAR','constraint' => 255),
            'tanggal' => array('type' => 'DATETIME'),
            'nilai' => array('type' => 'BIGINT', 'default'=>0),
            'keterangan' => array('type' => 'VARCHAR','constraint' => 255, 'default'=>null),
            'kode_rekening' => array('type' => 'VARCHAR','constraint' => 255, 'default'=>null),
            'id_spk' => array('type' => 'INT','constraint' => 11),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('sp2d');
    }

    public function down() {
        $this->dbforge->drop_table('sp2d');
    }
}