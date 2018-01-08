<?php
class Migration_migrasi2 extends CI_Migration {

    public function up() {
        $this->dbforge->rename_table('aset_a_temp', 'temp_aset_a');
        $this->dbforge->rename_table('aset_b_temp', 'temp_aset_b');
        $this->dbforge->rename_table('aset_c_temp', 'temp_aset_c');
        $this->dbforge->rename_table('aset_d_temp', 'temp_aset_d');
        $this->dbforge->rename_table('aset_e_temp', 'temp_aset_e');
        $this->dbforge->rename_table('kapitalisasi', 'aset_kapitalisasi');
    }

    public function down() {
        $this->dbforge->rename_table('temp_aset_a', 'aset_a_temp');
        $this->dbforge->rename_table('temp_aset_b', 'aset_b_temp');
        $this->dbforge->rename_table('temp_aset_c', 'aset_c_temp');
        $this->dbforge->rename_table('temp_aset_d', 'aset_d_temp');
        $this->dbforge->rename_table('temp_aset_e', 'aset_e_temp');
        $this->dbforge->rename_table('aset_kapitalisasi', 'kapitalisasi');
    }
}