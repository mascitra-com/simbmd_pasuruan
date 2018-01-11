<?php
class Migration_migrasi8 extends CI_Migration {

	public function up() {
		$fields = array('is_kepala_upb' => array('type' => 'TINYINT', 'after' => 'is_admin', 'default'=>0));

		$this->dbforge->add_column('user', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('user', 'is_kepala_upb');
	}
}