<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitalisasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kapitalisasi_model', 'kapitalisasi');
		$this->load->model('Spk_model', 'spk');
        $this->load->model('Hibah_model', 'hibah');
        $this->load->model('Kategori_model', 'kategori');
		$this->load->model('aset/Kibc_model', 'kibc');
		$this->load->model('aset/Kibd_model', 'kibd');
	}
	
	public function index()
	{
		show_404();
	}

	public function add_pengadaan($step = null, $id_spk = null)
	{
		if (empty($id_spk )) {
			show_404();
		}

		$data = $this->input->get();
		$data['spk'] = $this->spk->get($id_spk);

		switch ($step) {
			case 'langkah_1':
			$this->render('modules/pengadaan/form_kapitalisasi_1', $data);
			break;

			case 'langkah_2':
			if (empty($data['golongan']) OR empty($data['subsubkelompok'])) {
				$this->message('Pilih kode barang terlebih dahulu', 'danger');
				$this->go('kapitalisasi/add_pengadaan/langkah_1/'.$id_spk);
			}

			$where = array(
				'id_organisasi'	=> $data['spk']->id_organisasi,
				'id_kategori'	=> $data['subsubkelompok']
			);

			$kib 		 = ($data['golongan']==='3') ? 'kibc' : 'kibd';
			$data['kib'] = $this->{$kib}->get_many_by($where);
			$data['kib'] = $this->{$kib}->subtitute($data['kib']);

			$this->render('modules/pengadaan/form_kapitalisasi_2', $data);
			break;

			case 'langkah_3':
			if (empty($data['golongan']) OR empty($data['subsubkelompok'])) {
				$this->message('Pilih kode barang terlebih dahulu', 'danger');
				$this->go('kapitalisasi/add_pengadaan/langkah_1/'.$id_spk);
			}

			$kib 			  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
			$data['kib'] 	  = $this->{$kib}->get($data['id_aset']);
			$data['kategori'] = $this->kategori->get($data['subsubkelompok']);

			$this->render('modules/pengadaan/form_kapitalisasi_3', $data);
			break;

			default:
			show_404();
			break;
		}
	}

	public function add_hibah($step = null, $id_hibah = null)
	{
		if (empty($id_hibah )) {
			show_404();
		}

		$data = $this->input->get();
		$data['hibah'] = $this->hibah->get($id_hibah);

		switch ($step) {
			case 'langkah_1':
			$this->render('modules/hibah/form_kapitalisasi_1', $data);
			break;

			case 'langkah_2':
			if (empty($data['golongan']) OR empty($data['subsubkelompok'])) {
				$this->message('Pilih kode barang terlebih dahulu', 'danger');
				$this->go('kapitalisasi/add_hibah/langkah_1/'.$id_hibah);
			}

			$where = array(
				'id_organisasi'	=> $data['hibah']->id_organisasi,
				'id_kategori'	=> $data['subsubkelompok']
			);

			$kib 		 = ($data['golongan']==='3') ? 'kibc' : 'kibd';
			$data['kib'] = $this->{$kib}->get_many_by($where);
			$data['kib'] = $this->{$kib}->subtitute($data['kib']);

			$this->render('modules/hibah/form_kapitalisasi_2', $data);
			break;

			case 'langkah_3':
			if (empty($data['golongan']) OR empty($data['subsubkelompok'])) {
				$this->message('Pilih kode barang terlebih dahulu', 'danger');
				$this->go('kapitalisasi/add_hibah/langkah_1/'.$id_hibah);
			}

			$kib 			  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
			$data['kib'] 	  = $this->{$kib}->get($data['id_aset']);
			$data['kategori'] = $this->kategori->get($data['subsubkelompok']);

			$this->render('modules/hibah/form_kapitalisasi_3', $data);
			break;

			default:
			show_404();
			break;
		}
	}

	public function edit_pengadaan($id = null)
	{
		if(empty($id))
			show_404();

		$data['kpt'] = $this->kapitalisasi->get($id);

		if(empty($data['kpt']))
			show_404();


		$data['id_aset'] 		= $data['kpt']->id_aset;
		$data['golongan'] 		= $data['kpt']->golongan;
		$data['subsubkelompok'] = $data['kpt']->id_kategori;

		$kib 			  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$data['kib'] 	  = $this->{$kib}->get($data['id_aset']);
		$data['kategori'] = $this->kategori->get($data['subsubkelompok']);
		$data['spk'] 	  = $this->spk->get($data['kpt']->id_spk);

		$this->render('modules/pengadaan/form_kapitalisasi_3', $data);
	}

	public function edit_hibah($id = null)
	{
		if(empty($id))
			show_404();

		$data['kpt'] = $this->kapitalisasi->get($id);

		if(empty($data['kpt']))
			show_404();


		$data['id_aset'] 		= $data['kpt']->id_aset;
		$data['golongan'] 		= $data['kpt']->golongan;
		$data['subsubkelompok'] = $data['kpt']->id_kategori;

		$kib 			  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$data['kib'] 	  = $this->{$kib}->get($data['id_aset']);
		$data['kategori'] = $this->kategori->get($data['subsubkelompok']);
		$data['hibah'] 	  = $this->hibah->get($data['kpt']->id_hibah);

		$this->render('modules/hibah/form_kapitalisasi_3', $data);
	}

	public function insert_pengadaan()
	{
		$data = $this->input->post();
		$data['reg_induk']  = $this->kapitalisasi->get_reg_induk();

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('kapitalisasi/add/langkah_3/'.$data['id_spk'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
		}

		# Update data pada aset utama
		$kib  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$temp = $this->{$kib}->get($data['id_aset']);
		$nilai_tambah = ($this->nol($data['jumlah']) * $this->nol($data['nilai'])) + $this->nol($data['nilai_penunjang']);
		$total 		  = $nilai_tambah + $temp->nilai_tambah;
		$sukses 	  = $this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$total));

		if($sukses) {
			# Insert kapitalisasi
			$sukses = $this->kapitalisasi->insert($data);
			if($sukses) {
				$this->message('Data berhasil disimpan','success');
				$this->go('pengadaan/rincian/'.$data['id_spk']);
			} else {
				# Rollback update
				$this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$temp->nilai_tambah));
				$this->message('Data gagal disimpan');
				$this->go('kapitalisasi/add/langkah_3/'.$data['id_spk'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
			}
		} else {
			$this->message('Terjadi kesalahan');
			$this->go('kapitalisasi/add/langkah_3/'.$data['id_spk'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
		}
	}

	public function insert_hibah()
	{
		$data = $this->input->post();
		$data['reg_induk']  = $this->kapitalisasi->get_reg_induk();

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('kapitalisasi/add_hibah/langkah_3/'.$data['id_hibah'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
		}

		# Update data pada aset utama
		$kib  = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$temp = $this->{$kib}->get($data['id_aset']);
		$nilai_tambah = ($this->nol($data['jumlah']) * $this->nol($data['nilai'])) + $this->nol($data['nilai_penunjang']);
		$total 		  = $nilai_tambah + $temp->nilai_tambah;
		$sukses 	  = $this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$total));

		if($sukses) {
			# Insert kapitalisasi
			$sukses = $this->kapitalisasi->insert($data);
			if($sukses) {
				$this->message('Data berhasil disimpan','success');
				$this->go('hibah/rincian/'.$data['id_hibah']);
			} else {
				# Rollback update
				$this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$temp->nilai_tambah));
				$this->message('Data gagal disimpan');
				$this->go('kapitalisasi/add_hibah/langkah_3/'.$data['id_hibah'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
			}
		} else {
			$this->message('Terjadi kesalahan');
			$this->go('kapitalisasi/add_hibah/langkah_3/'.$data['id_hibah'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
		}
	}

	public function update_pengadaan()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('kapitalisasi/edit_pengadaan/'.$id);
		}

		# Update data pada aset utama
		$kib   = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$temp1 = $this->kapitalisasi->get($id);
		$temp2 = $this->{$kib}->get($data['id_aset']);
		$nilai_kurang = ($this->nol($temp1->jumlah) * $this->nol($temp1->nilai)) + $this->nol($temp1->nilai_penunjang);
		$nilai_tambah = ($this->nol($data['jumlah']) * $this->nol($data['nilai'])) + $this->nol($data['nilai_penunjang']);
		$total 		  = ($temp2->nilai_tambah - $nilai_kurang) + $nilai_tambah;
		$sukses 	  = $this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$total));

		if($sukses) {
			# update kapitalisasi
			$sukses = $this->kapitalisasi->update($id, $data);
			if($sukses) {
				$this->message('Data berhasil disimpan','success');
				$this->go('pengadaan/rincian/'.$data['id_spk']);
			} else {
				# Rollback update
				$this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$temp2->nilai_tambah));
				$this->message('Data gagal disimpan');
				$this->go('kapitalisasi/edit_pengadaan/'.$id);
			}
		} else {
			$this->message('Terjadi kesalahan');
			$this->go('kapitalisasi/edit_pengadaan/'.$id);
		}
	}

	public function update_hibah()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('kapitalisasi/edit_hibah/'.$id);
		}

		# Update data pada aset utama
		$kib   = ($data['golongan']==='3') ? 'kibc' : 'kibd';
		$temp1 = $this->kapitalisasi->get($id);
		$temp2 = $this->{$kib}->get($data['id_aset']);
		$nilai_kurang = ($this->nol($temp1->jumlah) * $this->nol($temp1->nilai)) + $this->nol($temp1->nilai_penunjang);
		$nilai_tambah = ($this->nol($data['jumlah']) * $this->nol($data['nilai'])) + $this->nol($data['nilai_penunjang']);
		$total 		  = ($temp2->nilai_tambah - $nilai_kurang) + $nilai_tambah;
		$sukses 	  = $this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$total));

		if($sukses) {
			# update kapitalisasi
			$sukses = $this->kapitalisasi->update($id, $data);
			if($sukses) {
				$this->message('Data berhasil disimpan','success');
				$this->go('pengadaan/rincian/'.$data['id_hibah']);
			} else {
				# Rollback update
				$this->{$kib}->update($data['id_aset'], array('nilai_tambah'=>$temp2->nilai_tambah));
				$this->message('Data gagal disimpan');
				$this->go('kapitalisasi/edit_hibah/'.$id);
			}
		} else {
			$this->message('Terjadi kesalahan');
			$this->go('kapitalisasi/edit_hibah/'.$id);
		}
	}

	public function delete_pengadaan($id = null)
	{
		if(empty($id))
			show_404();

		$kpt = $this->kapitalisasi->get($id);
		
		# Update data aset
		$kib  = ($kpt->golongan==='3') ? 'kibc' : 'kibd';
		$temp = $this->{$kib}->get($kpt->id_aset);
		$nilai_kurang = ($kpt->jumlah * $kpt->nilai) + $kpt->nilai_penunjang;
		$total		  = $temp->nilai_tambah - $nilai_kurang;
		$sukses 	  = $this->{$kib}->update($kpt->id_aset, array('nilai_tambah'=>$total));

		if($sukses) {
			$sukses = $this->kapitalisasi->delete($id);
			if($sukses) {
				$this->message('Data berhasil dihapus','success');
				$this->go('pengadaan/rincian/'.$kpt->id_spk);
			} else {
				# Rollback
				$this->{$kib}->update($kpt->id_aset, array('nilai_tambah'=>$temp->nilai_tambah));
				$this->message('Data gagal dihapus','danger');
				$this->go('pengadaan/rincian/'.$kpt->id_spk);
			}
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/rincian/'.$kpt->id_spk);
		}
	}

	public function delete_hibah($id = null)
	{
		if(empty($id))
			show_404();

		$kpt = $this->kapitalisasi->get($id);

		# Update data aset
		$kib  = ($kpt->golongan==='3') ? 'kibc' : 'kibd';
		$temp = $this->{$kib}->get($kpt->id_aset);
		$nilai_kurang = ($kpt->jumlah * $kpt->nilai) + $kpt->nilai_penunjang;
		$total		  = $temp->nilai_tambah - $nilai_kurang;
		$sukses 	  = $this->{$kib}->update($kpt->id_aset, array('nilai_tambah'=>$total));

		if($sukses) {
			$sukses = $this->kapitalisasi->delete($id);
			if($sukses) {
				$this->message('Data berhasil dihapus','success');
				$this->go('hibah/rincian/'.$kpt->id_hibah);
			} else {
				# Rollback
				$this->{$kib}->update($kpt->id_aset, array('nilai_tambah'=>$temp->nilai_tambah));
				$this->message('Data gagal dihapus','danger');
				$this->go('hibah/rincian/'.$kpt->id_hibah);
			}
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('hibah/rincian/'.$kpt->id_hibah);
		}
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}