<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pelunasan_model extends MY_Model
{

	public $_table = 'pelunasan';
	public $requred = array('id_aset', 'id_kdp', 'kib', 'id_organisasi');

	public function __construct()
	{
		parent::__construct();
	}

	public function  get_data($filter = array())
	{
		$id_organisasi = $filter['id_organisasi'];
		$data['kiba'] = $this->order_by('tgl_pelunasan', 'desc')->get_many_by(array('id_organisasi'=>$id_organisasi, 'kib'=>'a'));
		$data['kibc'] = $this->order_by('tgl_pelunasan', 'desc')->get_many_by(array('id_organisasi'=>$id_organisasi, 'kib'=>'c'));
		$data['kibd'] = $this->order_by('tgl_pelunasan', 'desc')->get_many_by(array('id_organisasi'=>$id_organisasi, 'kib'=>'d'));

		foreach ($data as $item) {
			
			if (empty($item))
					continue;

			foreach ($item as $pelunasan) {

				if (empty($pelunasan))
					continue;

				$pelunasan->id_aset = $this->db
				->join('kategori', 'id_kategori = kategori.id')
				->where('aset_'.$pelunasan->kib.'.id', $pelunasan->id_aset)
				->get('aset_'.$pelunasan->kib)->row();

				$pelunasan->id_kdp  = $this->db
				->join('kategori', 'id_kategori = kategori.id')
				->where('temp_aset_'.$pelunasan->kib.'.id_aset', $pelunasan->id_kdp)
				->get('temp_aset_'.$pelunasan->kib)->row();
			}
		}

		return $data;
	}

	public function get_json($conf)
	{
		$key = $conf['key'];
		$id_organisasi = $conf['id_organisasi'];
		$aset = $conf['aset'];

		$where_kdp = isset($conf['is_kdp']) && $conf['is_kdp'] ? 'k.kd_golongan = 6' : 'k.kd_golongan <> 6';
		$query = "SELECT a.id, CONCAT(k.kd_golongan,'.',k.kd_bidang,'.',k.kd_kelompok,'.',k.kd_subkelompok,'.',k.kd_subsubkelompok,'.',a.reg_barang) AS kode, 
		k.nama, a.nilai, a.keterangan FROM aset_{$aset} a JOIN kategori k ON a.id_kategori = k.id WHERE id_organisasi = {$id_organisasi} AND {$where_kdp}";
		$query = "SELECT * from ({$query}) AS q WHERE kode LIKE '{$key}%' OR nama LIKE '{$key}%' OR nilai LIKE '{$key}%' OR keterangan LIKE '%{$key}%' LIMIT 20";
		
		return $this->formating($this->db->query($query)->result());
	}

	private function formating($data)
	{
		foreach ($data as $item) {
			$item->nilai = monefy($item->nilai);
		}
		return $data;
	}
}