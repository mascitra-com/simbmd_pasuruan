<?php
class Migration_aset_a extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
			'reg_barang' => array('type' => 'INT', 'constraint' => 11),
			'reg_induk' => array('type' => 'VARCHAR', 'constraint' => 255),
			'luas' => array('type' => 'INT', 'constraint' => 11),
			'alamat' => array('type' => 'TEXT'),
			'sertifikat_tgl' => array('type' => 'DATETIME'),
			'sertifikat_no' => array('type' => 'VARCHAR', 'constraint' => 255),
			'hak' => array('type' => 'VARCHAR', 'constraint' => 255),
			'pengguna' => array('type' => 'VARCHAR', 'constraint' => 255),
			'tgl_perolehan' => array('type' => 'DATETIME'),
			'tgl_pembukuan' => array('type' => 'DATETIME'),
			'tahun' => array('type' => 'YEAR'),
			'asal_usul' => array('type' => 'VARCHAR', 'constraint' => 255),
			'nilai' => array('type' => 'BIGINT'),
			'keterangan' => array('type' => 'VARCHAR', 'constraint' => 255),
			'kd_pemilik' => array('type' => 'VARCHAR', 'constraint' => 255),
			'id_kategori' => array('type' => 'INT', 'constraint' => 11),
			'id_organisasi' => array('type' => 'INT', 'constraint' => 11),
			'id_spk' => array('type' => 'INT', 'constraint' => 11),
			'log_action' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_user' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => null),
			'log_time' => array('type' => 'DATETIME', 'default' => null),
			'is_deleted' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('aset_a');
	}

	public function down() {
		$this->dbforge->drop_table('aset_a');
	}
}