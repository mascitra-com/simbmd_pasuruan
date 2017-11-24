<?php
class Migration_edit_table_kib extends CI_Migration {

	public function up() {
		$fields = array(
			'id_hibah' => array('type' => 'int', 'constraint' => 11, 'default' => NULL),
		);
		$this->dbforge->add_column('aset_a', $fields, 'id_spk');
		$this->dbforge->add_column('aset_b', $fields, 'id_spk');
		$this->dbforge->add_column('aset_c', $fields, 'id_spk');
		$this->dbforge->add_column('aset_d', $fields, 'id_spk');
		$this->dbforge->add_column('aset_e', $fields, 'id_spk');
		$this->dbforge->add_column('aset_non', $fields, 'id_spk');

	}

	public function down() {
		$this->dbforge->drop_column('aset_a', 'id_hibah');
		$this->dbforge->drop_column('aset_b', 'id_hibah');
		$this->dbforge->drop_column('aset_c', 'id_hibah');
		$this->dbforge->drop_column('aset_d', 'id_hibah');
		$this->dbforge->drop_column('aset_e', 'id_hibah');
		$this->dbforge->drop_column('aset_non', 'id_hibah');
	}
}