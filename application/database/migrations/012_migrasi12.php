<?php
class Migration_migrasi12 extends CI_Migration {

	public function up() {
		$fields = array('batas_nilai' => array('type' => 'DOUBLE', 'after' => 'umur_ekonomis', 'default'=>0));

		$this->dbforge->add_column('kategori', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('kategori', 'batas_nilai');
	}
}