<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Saldo_kibc_model extends MY_Model_aset
{
	public $_table = 'saldo_aset_c';
    public $_kolom = array('tgl_perolehan', 'tgl_pembukuan', 'tingkat', 'beton', 'luas_lantai', 'lokasi', 'dokumen_tgl', 'dokumen_no', 'status_tanah', 'kode_tanah', 'asal_usul', 'kondisi', 'nilai');

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

        $this->join('kategori', $this->_table.'.id_kategori = kategori.id');
        $this->select("{$this->_table}.*");
        $this->where('id_organisasi', $filter['id_organisasi']);
        
        if ($filter['is_kdp']) {
            $this->where('kd_golongan', '6');
        } else {
            $this->where('kd_golongan<>', '6');
        }
        
		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi'], $filter['is_kdp']);

		$this->where("{$this->_table}.is_deleted",0);
		foreach (trim_empty_data($filter) as $key => $value)
			$this->like($key, $value);

    	# Get result count for pagination
		$tmp = clone $this->db;
		$result["data_count"] = $tmp->from("{$this->_table}")->count_all_results();

		# Limit & order
		$this->order_by($ord_by, $ord_pos);
		$this->limit($limit, ($page - 1) * $limit);

		# Return result
		;
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

            # Jika id organisasi tidak ada & Data Teraljor tidak kosong
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
            'tgl_perolehan' => $value[14],
            'tgl_pembukuan' => $value[37],
            'tingkat' => $value[15],
            'beton' => $value[16],
            'luas_lantai' => $value[17],
            'lokasi' => $value[18],
            'dokumen_tgl' => $value[19],
            'dokumen_no' => $value[20],
            'status_tanah' => $value[21],
            'kode_tanah' => $value[27],
            'asal_usul' => $value[28],
            'kondisi' => $value[29],
            'nilai' => unmonefy($value[30]),
            'keterangan' => $value[33],
            'tahun' => $value[34],
            'kd_pemilik' => $value[13],
            'id_kategori' => $result_kat->id,
            'id_organisasi' => ($id_organisasi==='all')?$value[count($value) - 1]:$id_organisasi,
            'is_deleted' => 0
            );
        }

        $this->session->set_userdata('temp_import', $temp);
        return;
    }

    public function get_rincian_widget($id_organisasi, $is_kdp)
    {
        $where_kdp = $is_kdp ? 'kd_golongan = 6' : 'kd_golongan <> 6';
        $query = "SELECT COUNT(a.id) AS total, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS total_rusak, SUM(nilai) AS nilai, SUM(CASE WHEN(kondisi=3) THEN nilai ELSE 0 END) AS nilai_rusak
        FROM {$this->_table} a JOIN kategori k ON a.id_kategori = k.id 
        WHERE id_organisasi = {$id_organisasi} AND {$where_kdp}";
        return $this->db->query($query)->result()[0];
    }
}