<?php
class Migration_kibcd_edit extends CI_Migration {

    public function up() {
        $fields = array(
            'nilai_tambah' => array('type' => 'BIGINT', 'default' => 0),
        );
        $this->dbforge->add_column('aset_c', $fields, 'nilai_sisa');
        $this->dbforge->add_column('aset_d', $fields, 'nilai_sisa');
    }

    public function down() {
        $this->dbforge->drop_column('aset_c', 'nilai_tambah');
        $this->dbforge->drop_column('aset_d', 'nilai_tambah');
    }
}