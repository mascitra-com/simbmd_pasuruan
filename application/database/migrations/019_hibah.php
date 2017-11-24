<?php
class Migration_hibah extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
			'tgl_jurnal' => array('type' => 'DATETIME', 'default' => null),
			'asal_penerimaan' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'no_serah_terima' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'tgl_serah_terima' => array('type' => 'DATETIME', 'default' => null),
			'keterangan' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'id_organisasi' => array('type' => 'INT', 'constraint' => 11),
			'log_action' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_user' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_time' => array('type' => 'DATETIME', 'default' => null),
			'is_deleted' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('hibah');
	}

	public function down() {
		$this->dbforge->drop_table('hibah');
	}
}