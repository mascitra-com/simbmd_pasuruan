<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Import extends MY_Controller
{
	public $is_superadmin = 1;
	public $kib;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model','organisasi');
	}
	
	public function index()
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
		$this->render('modules/backup/import/index', $data);
	}

	public function upload()
	{
		# GET & VALIDATE DATA
		$data = $this->input->post();
		
		if (empty($data['kib'])) {
			$this->message('Data KIB harus dipilih','danger');
			$this->go('backup/import');
		}

		# BEGIN UPLOAD
		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
			$config['file_name']	 	 = date('Ymdhis').uniqid();
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']      = 16000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);
			
			# Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('backup/import/');
			}

			# PUSH NAMA FILE
			$files = $this->session->userdata('import');

			if (!is_array($files))
				$files = array();

			# DELETE OLD TEMP
			$this->delete_old_temp_files();

			array_push($files, array('file_name'=>$this->upload->data('file_name'), 'kib'=>$data['kib']));

			# SIMPAN DI SEASON
			$this->session->set_userdata('import', $files);

			# ARAHKAN KE HALAMAN LOADING
			$this->render('modules/backup/import/loading');
		}else{
			$this->message('Pilih file terlebih dahulu', 'danger');
			$this->go('backup/import');
		}
	}

	public function do_import()
	{
		$this->load->library('Excel', 'excel');

		# Ambil nama file yang terakhir diupload
		$temp = $this->session->userdata('import');
		$temp = $temp[count($temp) - 1];
		# Set model
		$this->load->model('aset/Kib'.$temp['kib'].'_model', 'kib');
		$this->load->model('aset/Saldo_kib'.$temp['kib'].'_model', 'kib_saldo');
		# Persiapan config excel
		$conf['file'] = realpath(FCPATH.'res/docs/temp/'.$temp['file_name']);
		$conf['startRow'] = 1;
		# Ekstrak data dari file excel
		$results = $this->excel->import($conf);
		# Persiapkan data untuk siap insert
		$results = $this->finalize_data($results);

		# INSERT ke DB
		if ($this->kib_saldo->batch_insert($results)) {
			if ($this->kib->batch_insert($results)) {
				echo json_encode(array('status'=>'success'));
				return;
			}
		}
		echo json_encode(array('status'=>'error'));
		return;
	}

	private function finalize_data($data = array())
	{
		# Hapus data yg melebihi batas
		$data = $this->strip_overload_data($data);
		# Generate reg induk
		$reg = $this->kib->get_regInduk(count($data));
		# Set nama kolom
		for($i = 1; $i < count($data); $i++){
			foreach ($data[$i] as $key => $value) {
				# Ambil nama kolom
				$nama_kolom = $data[0][$key];
				# Set data sesuai kolom
				switch ($nama_kolom) {
					case 'tgl_perolehan':
					case 'tgl_pembukuan':
					case 'sertifikat_tgl':
					case 'dokumen_tgl':
					$data[$i][$nama_kolom] = datify($value, 'Y-m-d');
					break;
					default:
					$data[$i][$nama_kolom] = $value;
					break;
				}

				$data[$i]['reg_induk'] = $reg[$i];
				# Unset data lama
				unset($data[$i][$key]);
			}
		}
		
		unset($data[0]);
		return $data;
	}

	private function strip_overload_data($data = array())
	{
		# Ambil maksimum baris yang diperbolehkan
		$max = $this->config->item('import_max_rows');
		# Ambil data dalam jangka batas
		if (count($data) > $max + 1) {
			return array_slice($data, 0, $max + 1);
		}
		return $data;
	}

	private function delete_old_temp_files()
	{
		# Ambil daftar nama file temp
		$temp = $this->session->userdata('import');

		# Jika ada isinya
		if (is_array($temp)) {
			# Hapus semua file lama
			foreach ($temp as $key => $value) {
				if (file_exists(realpath(FCPATH.'res/docs/temp/'.$value['file_name']))) {
					unlink(realpath(FCPATH.'res/docs/temp/'.$value['file_name']));
				}
			}
		}
		return;
	}
}