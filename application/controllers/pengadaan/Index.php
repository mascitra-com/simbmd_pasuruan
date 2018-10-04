<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Spk_model', 'spk');
		$this->load->model('Sp2d_model', 'sp2d');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Kegiatan_model', 'kegiatan');

		$this->load->model('aset/Kiba_model', 'kiba');
		$this->load->model('aset/Kibb_model', 'kibb');
		$this->load->model('aset/Kibc_model', 'kibc');
		$this->load->model('aset/Kibd_model', 'kibd');
		$this->load->model('aset/Kibe_model', 'kibe');
		$this->load->model('aset/Kibg_model', 'kibg');
		$this->load->model('aset/Temp_kiba_model','temp_kiba');
		$this->load->model('aset/Temp_kibb_model','temp_kibb');
		$this->load->model('aset/Temp_kibc_model','temp_kibc');
		$this->load->model('aset/Temp_kibd_model','temp_kibd');
		$this->load->model('aset/Temp_kibe_model','temp_kibe');
		$this->load->model('aset/Temp_kibg_model','temp_kibg');
		$this->load->model('aset/Kibnon_model','kibnon');
		$this->load->model('Kapitalisasi_model','kapitalisasi');
	}
	
	public function index()
	{
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$result = $this->spk->get_data($filter);
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		$data['spks'] 		= $result['data'];
		$data['filter']  	= $filter;
		$data['organisasi'] = $this->organisasi->get_data_by_auth();
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'pengadaan/' . get_class($this));
		$data['kegiatan']   = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);

		$this->render('modules/pengadaan/index', $data);
	}

	public function insert()
	{
		$data = $this->input->post();
		$data['nilai'] = unmonefy($data['nilai']);
		$data['addendum_nilai'] = unmonefy($data['addendum_nilai']);
		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}

		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
			$config['file_name']     = 'pgd_'.uniqchar(5);
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['max_size']      = 1000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);

         # Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
			}

			$data['dokumen'] = $this->upload->data('file_name');
		}

		$sukses = $this->spk->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/detail/'.$sukses);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$data['nilai'] 	= unmonefy($data['nilai']);
		$data['addendum_nilai'] 	= unmonefy($data['addendum_nilai']);
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan/index/detail/'.$id);
		}

		# Upload
		$file_name = empty($this->spk->get($id)->dokumen)?'pgd_'.uniqchar(5):explode('.', $this->spk->get($id)->dokumen)[0];
		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
			$config['file_name']     = $file_name;
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['max_size']      = 1000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);

         # Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('pengadaan/index/detail/'.$id);
			}

			$data['dokumen'] = $this->upload->data('file_name');
		}

		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/index/detail/'.$id);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/index/detail/'.$id);
		}
	}

	public function delete($id = null)
	{
		if(empty($id))
			show_404();

		$id_organisasi = $this->spk->get($id)->id_organisasi;
		$sukses 	   = $this->spk->delete($id);
		if($sukses) {

			# HAPUS RINCIAN
			$this->temp_kiba->delete_by(array('id_spk'=>$id));
			$this->temp_kibb->delete_by(array('id_spk'=>$id));
			$this->temp_kibc->delete_by(array('id_spk'=>$id));
			$this->temp_kibd->delete_by(array('id_spk'=>$id));
			$this->temp_kibe->delete_by(array('id_spk'=>$id));
			$this->temp_kibg->delete_by(array('id_spk'=>$id));
			$this->kibnon->delete_by(array('id_spk'=>$id));
			$this->sp2d->delete_by(array('id_spk'=>$id));
			$this->kapitalisasi->delete_by(array('id_spk'=>$id));

			$this->message('Data berhasil dihapus','success');
			$this->go('pengadaan/index?id_organisasi='.$id_organisasi);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/index?id_organisasi='.$id_organisasi);
		}

	}

	public function detail($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']			  = $this->spk->get($id);
		$data['sp2d']['data']  = $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total'] = $this->sp2d->total($data['sp2d']['data']);
		$data['kegiatan'] 	  = $this->kegiatan->get_data_by_organisasi($data['spk']->id_organisasi);
		$data['ref']			  = !empty($this->input->get('ref')) ? 'true' : '';

		$this->render('modules/pengadaan/detail', $data);
	}

	public function rincian($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']  		= $this->spk->get($id);
		$data['nilai_sp2d'] = $this->sp2d->select("SUM(nilai) AS nilai")->get_many_by(array('id_spk'=>$id))[0]->nilai;

		# FIXED
		$data['kiba']['count'] = $this->temp_kiba->count_by(array('id_spk'=>$id));
		$data['kiba']['sum']   = $this->temp_kiba->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-B
		$data['kibb']['count'] = $this->temp_kibb->count_by(array('id_spk'=>$id));
		$data['kibb']['sum']   = $this->temp_kibb->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-C
		$data['kibc']['count'] = $this->temp_kibc->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan<>', '6')->count_by(array('id_spk'=>$id));
		$data['kibc']['sum']   = $this->temp_kibc->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan<>', '6')->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-D
		$data['kibd']['count'] = $this->temp_kibd->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan<>', '6')->count_by(array('id_spk'=>$id));
		$data['kibd']['sum']   = $this->temp_kibd->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan<>', '6')->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-E
		$data['kibe']['count'] = $this->temp_kibe->count_by(array('id_spk'=>$id));
		$data['kibe']['sum']   = $this->temp_kibe->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-F
		$data['kibg']['count'] = $this->temp_kibg->count_by(array('id_spk'=>$id));
		$data['kibg']['sum']   = $this->temp_kibg->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KIB-NON
		$data['kibnon']['count'] = $this->kibnon->count_by(array('id_spk'=>$id));
		$data['kibnon']['sum']   = $this->kibnon->select("SUM(nilai) AS nilai")->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KDP-C
		$data['kdpc']['count'] = $this->temp_kibc->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan', '6')->count_by(array('id_spk'=>$id));
		$data['kdpc']['sum']   = $this->temp_kibc->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan', '6')->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#KDP-D
		$data['kdpd']['count'] = $this->temp_kibd->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan', '6')->count_by(array('id_spk'=>$id));
		$data['kdpd']['sum']   = $this->temp_kibd->join('kategori', 'id_kategori = kategori.id')->where('kd_golongan', '6')->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_spk'=>$id))[0]->nilai;
		#PENAMBAHAN NILAI
		$data['kpt']['count'] = $this->kapitalisasi->count_by(array('id_spk'=>$id));
		$data['kpt']['sum']   = $this->kapitalisasi->select("SUM(nilai) AS nilai")->get_many_by(array('id_spk'=>$id))[0]->nilai;

		$data['ref'] = !empty($this->input->get('ref')) ? 'true' : '';
		$this->render('modules/pengadaan/rincian', $data);
	}

	public function rincian_redirect($id = null)
	{
		if(empty($id))
			show_404();

		$jenis = $this->input->post('jenis');

		switch ($jenis) {
			case 'a':
			$this->go('pengadaan/kiba/add/'.$id);
			break;
			case 'b':
			$this->go('pengadaan/kibb/add/'.$id);
			break;
			case 'c':
			$this->go('pengadaan/kibc/add/'.$id);
			break;
			case 'd':
			$this->go('pengadaan/kibd/add/'.$id);
			break;
			case 'e':
			$this->go('pengadaan/kibe/add/'.$id);
			break;
			case 'g':
			$this->go('pengadaan/kibg/add/'.$id);
			break;
			case 'non':
			$this->go('pengadaan/kibnon/add/'.$id);
			break;
			case 'c_kdp':
			$this->go('pengadaan/kdpc/add/'.$id);
			break;
			case 'd_kdp':
			$this->go('pengadaan/kdpd/add/'.$id);
			break;
			case 'tambah':
			$this->go('pengadaan/kapitalisasi/add/'.$id);
			break;

			default:
			show_404();
			break;
		}
	}

	public function finish_transaction($id = NULL)
	{
		if(empty($id))
			show_404();

		$data   = array('status_pengajuan'=>1);
		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil diajukan','success');
			$this->go('pengadaan/index/detail/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('pengadaan/index/detail/'.$id);
		}
	}

	public function cancel_transaction($id = NULL)
	{
		if(empty($id))
			show_404();

		$data   = array('status_pengajuan'=>0);
		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil dibatalkan','success');
			$this->go('pengadaan/index/detail/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('pengadaan/index/detail/'.$id);
		}
	}

	public function abort_transaction($id_spk = NULL)
	{
    	# JIKA KOSONG
		if (empty($id_spk)) {
			$this->message('Pilih data pengadaan yang akan dibatalkan', 'danger');
			$this->go('pengadaan/index/');
		}

    	# AMBIL DATA SPK
		$spk = $this->spk->get($id_spk);

    	# CEK KETERSEDIAAN PEMBATALAN
		$abort_status = $this->check_abort_status($spk->id);
		if (!$abort_status['status']) {
			$this->message($abort_status['reason'], 'danger');
			$this->go('pengadaan/index?id_organisasi='.$spk->id_organisasi);
		}

		# ABOOORT - HAPUS RINCIAN
		$this->kiba->delete_by(array('id_spk'=>$id_spk));
		$this->kibb->delete_by(array('id_spk'=>$id_spk));
		$this->kibc->delete_by(array('id_spk'=>$id_spk));
		$this->kibd->delete_by(array('id_spk'=>$id_spk));
		$this->kibe->delete_by(array('id_spk'=>$id_spk));
		$this->kibg->delete_by(array('id_spk'=>$id_spk));

		# KAPIPTALISASI
		$kap = $this->kapitalisasi->get_many_by('id_spk', $id_spk);
		foreach ($kap as $item) {
			# Update data pada aset utama
			$kib  = ($item->golongan==='3') ? 'kibc' : 'kibd';
			$temp = $this->{$kib}->get($item->id_aset);
			$nilai_kurang = $this->nol($item->jumlah) * $this->nol($item->nilai);
			$total = $temp->nilai_tambah - $nilai_kurang;
			$total = $total < 0 ? 0 : $total;
			
			$this->{$kib}->update($item->id_aset, array('nilai_tambah'=>$total));
		}

		$this->spk->update($id_spk, array('status_pengajuan'=>0));

		$this->message('Pengadaan berhasil dibatalkan','success');
		$this->go('pengadaan/index?id_organisasi='.$spk->id_organisasi);
	}

	private function check_abort_status($id_spk = NULL)
	{
		if (empty($id_spk)) {
			return array('status'=>FALSE, 'reason'=>'id spk kosong');
		}

		$spk = $this->spk->get($id_spk);

		if (empty($spk)) {
			return array('status'=>FALSE, 'reason'=>'id spk tidak valid');
		}

		# AMBIL DATA
		$alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
		foreach ($alfabet as $item) {
			$kib = "kib{$item}";
			$kib_temp = "temp_kib{$item}";
			
			$data[$item]['saldo'] = $this->{$kib}->get_many_by(array('id_spk'=>$spk->id, 'id_organisasi'=>$spk->id_organisasi));
			$data[$item]['temp']  = $this->{$kib_temp}->get_many_by(array('id_spk'=>$spk->id));
		}

		foreach ($data as $index=>$kib) {
    		# ==============================================================================
    		# CEK TRANSFER!
			if (count($kib['saldo']) !== count($kib['temp'])) {
				return array('status'=>FALSE, 'reason'=>"Terdapat rincian pada kib-{$index} yang telah ditransfer, dikoreksi, dihapus, maupun terikat dengan pelunasan KDP.");
			}

			# ===============================================================================
			# CEK KOREKSI NILAI / KAPITALISASI
			$sum_saldo = 0;
			$id_saldo = array();
			foreach ($kib['saldo'] as $item) {
				$sum_saldo += $item->nilai;
				if ($index == 'c' OR $index == 'd') {
					$sum_saldo += $item->nilai_tambah;
				}
				array_push($id_saldo, $item->id);
			}

			$sum_temp = 0;
			foreach ($kib['temp'] as $item) {
				$sum_temp += $item->nilai;
				if ($index == 'c' OR $index == 'd') {
					$sum_temp += $item->nilai_tambah;
				}
			}

			if ($sum_saldo !== $sum_temp) {
				return array('status'=>FALSE, 'reason'=>"Terdapat rincian pada kib-{$index} yang telah dikoreksi atau ditambah nilainya.");
			}

			#=========================================================================
			# CEK KOREKSI KODE
			if (!empty($id_saldo)) {
				$koreksi_id_saldo = implode(',', array_unique($id_saldo));
				$query = "SELECT COUNT(id) AS jumlah FROM temp_aset_{$index} WHERE id_aset IN({$koreksi_id_saldo}) AND (id_transfer IS NOT NULL OR id_hapus IS NOT NULL OR id_koreksi IS NOT NULL)";
				if ($this->db->query($query)->result()[0]->jumlah > 0) {
					return array('status'=>FALSE, 'reason'=>"Terdapat rincian pada kib-{$index} yang telah direklas.");
				}
			}

			#==========================================================================
			# CEK PELUNASAN
			if (!empty($id_saldo)) {
				$pelunasan_id_saldo = implode(',', array_unique($id_saldo));
				$query = "SELECT * FROM pelunasan WHERE kib = '{$index}' AND (id_aset IN({$pelunasan_id_saldo}) OR id_kdp IN({$pelunasan_id_saldo}))";
				if ($this->db->query($query)->num_rows() > 0) {
					return array('status'=>FALSE, 'reason'=>"Terdapat rincian pada kib-{$index} yang terikat dengan pelunasan.");
				}
			}
		}

		return array('status'=>TRUE);
	}

	public function get_abort_status($id_spk = NULL) {
		if (empty($id_spk)) {
			echo json_encode(array('status'=>FALSE, 'reason'=>'ID SPK KOSONG'));
		} else {
			echo json_encode($this->check_abort_status($id_spk));
		}
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}