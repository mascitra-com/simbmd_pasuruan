<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibg extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aset/Kibg_model', 'kib');
		$this->load->model('aset/Temp_kibg_model', 'kib_temp');
		$this->load->model('Koreksi_model', 'koreksi');
		$this->load->model('Koreksi_detail_model', 'koreksi_detail');
	}

	public function index($id_koreksi = null)
	{
		if (empty($id_koreksi)) {
			show_404();
		}

		$data['koreksi'] = $this->koreksi->get($id_koreksi);
		$this->render('modules/koreksi/atribut/kibg', $data);
	}

	public function get($id_koreksi = null)
	{
		if (empty($id_koreksi)) {
			return;
		}

		$koreksi = $this->koreksi->get($id_koreksi);
		$filter  = $this->input->get();

		if(isset($filter['search']))
			$filter = array_merge($filter, $this->set_filter($filter['search']));

		unset($filter['search']);

		# FILTER
		$temp = $this->kib_temp->select('id_aset')->as_array()->get_many_by(array('id_koreksi'=>$id_koreksi));
		$filter['id_organisasi']  = $koreksi->id_organisasi;
		$filter['excludes']['id'] = array_column($temp, 'id_aset');

		echo json_encode( $this->finalize_data( $this->kib->get_data_aset($filter) ) );
	}

	public function get_rincian($id_koreksi = null)
	{
		if (empty($id_koreksi)) {
			return;
		}

		$koreksi = $this->koreksi->get($id_koreksi);
		$filter  = $this->input->get();

		if(isset($filter['search']))
			$filter = array_merge($filter, $this->set_filter($filter['search']));

		unset($filter['search']);

		# FILTER
		$filter['id_organisasi'] = $koreksi->id_organisasi;
		$filter['id_koreksi'] = $id_koreksi;
		echo json_encode($this->finalize_data($this->kib_temp->get_data_aset($filter), TRUE));
	}

	private function set_filter($q)
	{
		foreach ($this->kib->_kolom as $key => $value) {
			$temp[$value] = $q;
		}

		return $temp;
	}

	private function finalize_data($data, $is_rincian = FALSE)
	{
		foreach ($data['rows'] as $key => $value) {
			$value = (array)$value;

			if ($is_rincian) {
				$corrected = (array)json_decode($this->koreksi_detail->get($value['id_koreksi_detail'])->corrected_value);
			}

			foreach ($value as $index => $item) {
				switch ($index) {
					case 'tgl_perolehan':
					$value[$index] = datify($item);
					break;
					case 'tgl_pembukuan':
					$value[$index] = datify($item);
					if ($is_rincian && $value[$index] !== datify($corrected[$index])) {
						$value[$index] = empty($item)?'':"<b class='text-danger'>-(".$value[$index].")</b>";
						$value[$index] .= empty($corrected[$index])?'':"<b class='text-success'> +(".datify($corrected[$index]).")</b>";
					}
					break;
					case 'nilai':
					$value[$index] = monefy($item);
					break;
					case 'kondisi':
					$kondisi = array('kosong','Baik', 'Kurang Baik', 'Rusak Berat');
					$value[$index] = $kondisi[$item];
					break;
					default:
					if ($is_rincian && array_key_exists($index, $corrected) && $item !== $corrected[$index]) {
						$value[$index] = empty($item)?'':"<b class='text-danger'>-(".$item.")</b>";
						$value[$index] .= empty($corrected[$index])?'':"<b class='text-success'> +(".$corrected[$index].")</b>";
					}
					break;
				}
			}
			
			# KODE BARANG
			$value['kode_barang'] = zerofy($value['id_kategori']->kd_golongan, 2);
			$value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_bidang, 2);
			$value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_kelompok, 2);
			$value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_subkelompok, 2);
			$value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_subsubkelompok, 2);
			# NAMA BARANG
			$value['id_kategori'] = $value['id_kategori']->nama;
			$value['id_ruangan']  = !empty($value['id_ruangan'])?$value['id_ruangan']->nama:'';

			# AKSI
			if (!$is_rincian) {
				$value['aksi'] = "<button class='btn btn-sm btn-success btn-block' data-id='".$value['id']."'><i class='fa fa-plus'></i></button>";
			}else{
				$value['aksi'] = "<a href='".site_url('koreksi/atribut/kibg/delete/'.$value['id'])."' class='btn btn-sm btn-danger btn-block'><i class='fa fa-times'></i></a>";
			}

			$data['rows'][$key] = (object)$value;
		}
		return $data;
	}

	public function insert()
	{
		# SET DATA
		$data = $this->input->post();
		$id_koreksi = $data['id_koreksi'];
		$id = $data['id'];
		$data['nilai'] = unmonefy($data['nilai']);
		# CLEAR DATA
		unset($data['id_koreksi'], $data['id']);
		# GET DATA
		$temp = $this->kib->as_array()->get($id);
		foreach ($data as $key => $value) {
			$original_value[$key] = $temp[$key];
		}

		# INSERT KOREKSI DETAIL
		$id_koreksi_detail = $this->koreksi_detail->insert(array('original_value'=>json_encode($original_value), 'corrected_value'=>json_encode($data)));
		# INSERT TEMP
		$temp['id_aset'] = $id;
		$temp['id_koreksi'] = $id_koreksi;
		$temp['id_koreksi_detail'] = $id_koreksi_detail;
		unset($temp['id'], $temp['id_spk'], $temp['id_sp2d'], $temp['id_hibah'], $temp['id_inventarisasi']);

		$this->kib_temp->insert($temp);

		$this->message('Data berhasil ditambah', 'success');
		$this->go('koreksi/atribut/kibg/index/'.$id_koreksi);
	}

	public function delete($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$temp = $this->kib_temp->get($id);
		$this->koreksi_detail->delete($temp->id_koreksi_detail);
		$this->kib_temp->delete($id);

		$this->message('Data berhasil dihapus', 'success');
		$this->go('koreksi/atribut/index/rincian/'.$temp->id_koreksi);
	}
}