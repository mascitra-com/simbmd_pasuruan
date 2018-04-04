<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Saldo_kibe_model extends MY_Model
{
	public $_table = 'saldo_aset_e';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data($filter = array())
    {
    	if (!isset($filter['id_organisasi']) OR empty($filter['id_organisasi']))
    	{
    		return array('data'=>array(), 'data_count'=>0);
    	}

    	$result  = array();
		$page    = isset($filter['page']) ? $filter['page'] : 1;
		$limit	 = isset($filter['limit']) ? $filter['limit'] : 20;
		$ord_by	 = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
		$ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

        $this->where('id_organisasi', $filter['id_organisasi']);

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi']);

		$this->where('is_deleted',0);
		foreach (trim_empty_data($filter) as $key => $value)
			$this->like($key, $value);

    	# Get result count for pagination
		$tmp = clone $this->db;
		$result["data_count"] = $tmp->from("{$this->_table}")->count_all_results();

		# Limit & order
		$this->order_by($ord_by, $ord_pos);
		$this->limit($limit, ($page - 1) * $limit);

		# Return result
		$this->empty_substitution = "<span class='text-secondary'><i>kosong</i></span>";
		$result['data'] = $this->subtitute($this->get_all());
        $result['data'] = $this->fill_empty_data($result['data']);
		return $result;
    }

    public function fix_data_import($data)
    {
        $temp = $this->session->temp_import;

        $id_organisasi = $temp['id_organisasi'];
        $this->load->model("Kategori_model", "kategori");

        $temp['data_error'] = array(); 
        
        foreach ($data as $key => $value) {
            $kode['kd_golongan']  = $value[7];
            $kode['kd_bidang']  = $value[8];
            $kode['kd_kelompok']  = $value[9];
            $kode['kd_subkelompok']  = $value[10];
            $kode['kd_subsubkelompok']  = $value[11];

            $result_kat = $this->kategori->get_by($kode);

            # Jika id organisasi tidak ada
            if ($id_organisasi==='all' && empty($value[count($value) - 1])) {
                $temp['data_error'][] = array('baris_ke'=>$key+1, 'data'=>$value);
                continue;
            }
            
            # Jika kategori tak ada
            if (empty($result_kat)) {
                $temp['data_error'][] = array('baris_ke'=>$key+1, 'data'=>$value);
                continue;
            }

            $temp['data'][] = array(
            'reg_barang' => $value[12],
            'tgl_perolehan' => $value[15],
            'tgl_pembukuan' => $value[29],
            'judul' => $value[16],
            'pencipta' => $value[17],
            'bahan' => $value[18],
            'ukuran' => $value[19],
            'asal_usul' => $value[20],
            'kondisi' => $value[21],
            'nilai' => unmonefy($value[22]),
            'nilai_sisa' => unmonefy($value[24]),
            'masa_manfaat' => $value[23],
            'keterangan' => $value[25],
            'tahun' => $value[26],
            'kd_pemilik' => $value[14],
            'id_kategori' => $result_kat->id,
            'id_organisasi' => ($id_organisasi==='all')?$value[count($value) - 1]:$id_organisasi,
            'is_deleted' => 0
            );
        }

        $this->session->set_userdata('temp_import', $temp);
        return;
    }

    public function get_rincian_widget($id_organisasi)
    {
        $query = "SELECT COUNT(id) AS total, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS total_rusak, SUM(nilai) AS nilai, SUM(CASE WHEN(kondisi=3) THEN nilai ELSE 0 END) AS nilai_rusak
        FROM {$this->_table} WHERE id_organisasi = {$id_organisasi}";
        return $this->db->query($query)->result()[0];
    }
}