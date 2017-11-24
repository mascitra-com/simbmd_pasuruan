<?php
class Migration_aset_d extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'reg_barang' => array('type' => 'INT','constraint' => 11),
            'reg_induk' => array('type' => 'VARCHAR','constraint' => 255),
            'tgl_perolehan' => array('type' => 'DATETIME'),
            'tgl_pembukuan' => array('type' => 'DATETIME'),
            'kontruksi' => array('type' => 'VARCHAR', 'constraint'=>255),
            'panjang' => array('type' => 'INT','constraint' => 11),
            'lebar' => array('type' => 'INT','constraint' => 11),
            'luas' => array('type' => 'INT','constraint' => 11),
            'lokasi' => array('type' => 'TEXT'),
            'dokumen_tgl' => array('type' => 'DATETIME'),
            'dokumen_no' => array('type' => 'VARCHAR', 'constraint'=>255),
            'status_tanah' => array('type' => 'VARCHAR', 'constraint'=>255),
            'kode_tanah' => array('type' => 'VARCHAR', 'constraint'=>255),
            'asal_usul' => array('type' => 'VARCHAR', 'constraint'=>255),
            'kondisi' => array('type' => 'VARCHAR', 'constraint'=>255),
            'nilai' => array('type' => 'BIGINT'),
            'nilai_sisa' => array('type' => 'BIGINT'),
            'masa_manfaat' => array('type' => 'INT','constraint' => 11),
            'keterangan' => array('type' => 'VARCHAR', 'constraint'=>255),
            'tahun' => array('type' => 'YEAR'),
            'kd_pemilik' => array('type' => 'VARCHAR', 'constraint'=>255),
            'id_kategori' => array('type' => 'INT','constraint' => 11),
            'id_organisasi' => array('type' => 'INT','constraint' => 11),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('aset_d');
    }

    public function down() {
        $this->dbforge->drop_table('aset_d');
    }
}