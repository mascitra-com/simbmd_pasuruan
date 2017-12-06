<?php
class Migration_kapitalisasi_edit extends CI_Migration {

    public function up() {
        $fields = array(
            'golongan' => array('type' => 'INT', 'constraint' => 1, 'default' => NULL),
            'id_aset' => array('type' => 'int', 'constraint' => 11, 'default' => NULL)
        );
        $this->dbforge->add_column('kapitalisasi', $fields, 'id_spk');

        $fields = array(
            'reg_induk' => array('type' => 'VARCHAR', 'constraint' => 255, 'default'=>NULL),
        );
        $this->dbforge->add_column('kapitalisasi', $fields, 'id');
    }

    public function down() {
        $this->dbforge->drop_column('kapitalisasi', 'id_aset');
        $this->dbforge->drop_column('kapitalisasi', 'golongan');
        $this->dbforge->drop_column('kapitalisasi', 'reg_induk');
    }
}