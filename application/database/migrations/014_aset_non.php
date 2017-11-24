<?php
class Migration_aset_non extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
			'nama' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'merk' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'tipe' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'nilai' => array('type' => 'BIGINT', 'default' => 0),
			'keterangan' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'id_organisasi' => array('type' => 'INT', 'constraint' => 11),
			'id_spk' => array('type' => 'INT', 'constraint' => 11),
			'log_action' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_user' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_time' => array('type' => 'DATETIME', 'default' => null),
			'is_deleted' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('aset_non');
	}

	public function down() {
		$this->dbforge->drop_table('aset_non');
	}
}