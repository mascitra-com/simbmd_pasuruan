<?php
class Migration_migrasi4 extends CI_Migration {

	public function up() {
		$fields = array('id_sp2d' => array('type' => 'INT', 'after' => 'id_spk', 'default'=>NULL));

		$this->dbforge->add_column('aset_a', $fields);
		$this->dbforge->add_column('aset_b', $fields);
		$this->dbforge->add_column('aset_c', $fields);
		$this->dbforge->add_column('aset_d', $fields);
		$this->dbforge->add_column('aset_e', $fields);
		$this->dbforge->add_column('aset_non', $fields);
		$this->dbforge->add_column('aset_kapitalisasi', $fields);
		$this->dbforge->add_column('temp_aset_a', $fields);
		$this->dbforge->add_column('temp_aset_b', $fields);
		$this->dbforge->add_column('temp_aset_c', $fields);
		$this->dbforge->add_column('temp_aset_d', $fields);
		$this->dbforge->add_column('temp_aset_e', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('aset_a', 'id_sp2d');
		$this->dbforge->drop_column('aset_b', 'id_sp2d');
		$this->dbforge->drop_column('aset_c', 'id_sp2d');
		$this->dbforge->drop_column('aset_d', 'id_sp2d');
		$this->dbforge->drop_column('aset_e', 'id_sp2d');
		$this->dbforge->drop_column('aset_non', 'id_sp2d');
		$this->dbforge->drop_column('aset_kapitalisasi', 'id_sp2d');
		$this->dbforge->drop_column('temp_aset_a', 'id_sp2d');
		$this->dbforge->drop_column('temp_aset_b', 'id_sp2d');
		$this->dbforge->drop_column('temp_aset_c', 'id_sp2d');
		$this->dbforge->drop_column('temp_aset_d', 'id_sp2d');
		$this->dbforge->drop_column('temp_aset_e', 'id_sp2d');
	}
}