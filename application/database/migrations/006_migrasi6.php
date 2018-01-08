<?php
class Migration_migrasi6 extends CI_Migration {

    public function up() {
    	$fields = array(
    		'tanggal_verifikasi' => array('type' => 'DATETIME', 'after' => 'id_kegiatan', 'default'=>NULL),
    		'status_pengajuan' => array('type' => 'TINYINT', 'after' => 'id_kegiatan', 'default'=>0)
    	);
		$this->dbforge->add_column('spk', $fields);

		$fields = array('id_spk' => array('type' => 'TINYINT', 'after' => 'status', 'default'=>NULL));
		$this->dbforge->add_column('persetujuan', $fields);
    }

    public function down() {
		$this->dbforge->drop_column('spk','status_pengajuan');
		$this->dbforge->drop_column('spk','tanggal_verifikasi');
		$this->dbforge->drop_column('persetujuan','id_spk');

    }
}