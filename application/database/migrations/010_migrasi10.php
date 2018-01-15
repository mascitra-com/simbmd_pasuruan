<?php
class Migration_migrasi10 extends CI_Migration {

    public function up() {
    	# TABEL KOREKSI
    	#########################################################################
    	$fields = array(
    		'id'=>array('type'=>'INT', 'constraint'=>11, 'auto_increment'=>TRUE),
    		'tgl_jurnal'=>array('type'=>'DATETIME', 'default'=>NULL),
    		'keterangan'=>array('type'=>'TEXT', 'default'=>NULL),
    		'jenis_koreksi'=>array('type'=>'TINYINT', 'constraint'=>1, 'default'=>NULL),
    		'status_pengajuan'=>array('type'=>'TINYINT', 'constraint'=>1, 'default'=>0),
    		'tanggal_verifikasi'=>array('type'=>'DATETIME', 'default'=>NULL),
    		'id_organisasi'=>array('type'=>'INT', 'constraint'=>11),
    		'log_action'=>array('type'=>'VARCHAR', 'constraint'=>255, 'default'=>NULL),
    		'log_time'=>array('type'=>'DATETIME', 'default'=>NULL),
    		'log_user'=>array('type'=>'INT', 'constraint'=>11, 'default'=>NULL),
    		'is_deleted'=>array('type'=>'TINYINT', 'constraint'=>1, 'default'=>0)
    	);

    	$this->dbforge->add_field($fields);
    	$this->dbforge->add_key('id', TRUE);
    	$this->dbforge->create_table('koreksi');

        # TABEL KOREKSI DETAIL
        #########################################################################
    	$fields = array(
    		'id'=>array('type'=>'INT', 'constraint'=>11, 'auto_increment'=>TRUE),
    		'original_value'=>array('type'=>'VARCHAR', 'constraint'=>255, 'default'=>NULL),
    		'corrected_value'=>array('type'=>'VARCHAR', 'constraint'=>255, 'default'=>NULL),
    		'log_action'=>array('type'=>'VARCHAR', 'constraint'=>255, 'default'=>NULL),
    		'log_time'=>array('type'=>'DATETIME', 'default'=>NULL),
    		'log_user'=>array('type'=>'INT', 'constraint'=>11, 'default'=>NULL),
    		'is_deleted'=>array('type'=>'TINYINT', 'constraint'=>1, 'default'=>0)
    	);

    	$this->dbforge->add_field($fields);
    	$this->dbforge->add_key('id', TRUE);
    	$this->dbforge->create_table('koreksi_detail');

    	# TAMBAH KOLOM id_koreksi dan id_koreksi_detail di aset_temp
    	#########################################################################
    	$fields = array(
    		'id_koreksi_detail' => array('type' => 'INT', 'constraint'=>1, 'after' => 'id_hapus', 'default'=>NULL),
    		'id_koreksi' => array('type' => 'INT', 'constraint'=>1, 'after' => 'id_hapus', 'default'=>NULL)
    	);
		$this->dbforge->add_column('temp_aset_a', $fields);
		$this->dbforge->add_column('temp_aset_b', $fields);
		$this->dbforge->add_column('temp_aset_c', $fields);
		$this->dbforge->add_column('temp_aset_d', $fields);
		$this->dbforge->add_column('temp_aset_e', $fields);

		# TAMBAH KOLOM id_koreksi di persetujuan
    	#########################################################################
    	$fields = array(
    		'id_koreksi' => array('type' => 'INT', 'constraint'=>11, 'after'=>'id_hapus', 'default'=>NULL)
    	);
		$this->dbforge->add_column('persetujuan', $fields);

		# Perbaiki tipe data id_spk di tabel persetujuan
    	#########################################################################
    	$fields = array(
    		'id_spk' => array('name'=>'id_spk','type' => 'INT', 'constraint'=>11, 'default'=>NULL)
    	);
		$this->dbforge->modify_column('persetujuan', $fields);
    }

    public function down() {
    	$this->dbforge->drop_table('koreksi');
    	$this->dbforge->drop_table('koreksi_detail');

    	$this->dbforge->drop_column('temp_aset_a', 'id_koreksi');
    	$this->dbforge->drop_column('temp_aset_a', 'id_koreksi_detail');

    	$this->dbforge->drop_column('temp_aset_b', 'id_koreksi');
    	$this->dbforge->drop_column('temp_aset_b', 'id_koreksi_detail');

    	$this->dbforge->drop_column('temp_aset_c', 'id_koreksi');
    	$this->dbforge->drop_column('temp_aset_c', 'id_koreksi_detail');

    	$this->dbforge->drop_column('temp_aset_d', 'id_koreksi');
    	$this->dbforge->drop_column('temp_aset_d', 'id_koreksi_detail');

    	$this->dbforge->drop_column('temp_aset_e', 'id_koreksi');
    	$this->dbforge->drop_column('temp_aset_e', 'id_koreksi_detail');

    	$this->dbforge->drop_column('persetujuan', 'id_koreksi');
    }
}