<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kibd_model extends MY_Model
{
	public $_table = 'aset_d';
	public $required = array('id_organisasi','id_kategori','nilai');

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
		foreach ($filter as $key => $value)
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

    public function get_statistic($id_organisasi = NULL, $is_kdp = false)
    {
        if (empty($id_organisasi)) {
            return array();
        }

        # JUMLAH ASET
        $query = "AND kd_golongan <> 6";
        if ($is_kdp) {
            $query = "AND kd_golongan = 6";
        }

        $val = $this->db->query("SELECT COUNT({$this->_table}.id) AS jumlah FROM {$this->_table} JOIN kategori ON {$this->_table}.id_kategori = kategori.id WHERE id_organisasi='{$id_organisasi}' AND {$this->_table}.is_deleted = 0 {$query}")->result()[0]->jumlah;
        $result[0]['title'] = 'Jumlah Aset';
        $result[0]['value'] = $val.' Buah';

        # JUMLAH NILAI ASET
        $val = $this->db->query("SELECT SUM(nilai) AS jumlah FROM {$this->_table} JOIN kategori ON {$this->_table}.id_kategori = kategori.id WHERE id_organisasi='{$id_organisasi}' AND {$this->_table}.is_deleted = 0 {$query}")->result()[0]->jumlah;
        $result[1]['title'] = 'Jumlah Nilai Aset';
        $result[1]['value'] = 'Rp '.(monefy($val)).',-';

        # JUMLAH NILAI ASET TERTINGGI
        $val = $this->db->query("SELECT MAX(nilai) AS jumlah FROM {$this->_table} JOIN kategori ON {$this->_table}.id_kategori = kategori.id WHERE id_organisasi='{$id_organisasi}' AND {$this->_table}.is_deleted = 0 {$query}")->result()[0]->jumlah;
        $result[2]['title'] = 'Nilai Aset Tertinggi';
        $result[2]['value'] = 'Rp '.(monefy($val)).',-';

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
            
            # Jika kategori tak ada
            if (empty($result_kat)) {
                $temp['data_error'][] = array('baris_ke'=>$key+1, 'data'=>$value);
                continue;
            }

            $temp['data'][] = array(
            'reg_barang' => $value[12],
            'tgl_perolehan' => $value[14],
            'tgl_pembukuan' => $value[38],
            'kontruksi' => $value[15],
            'panjang' => $value[16],
            'lebar' => $value[17],
            'luas' => $value[18],
            'lokasi' => $value[19],
            'dokumen_tgl' => $value[20],
            'dokumen_no' => $value[21],
            'status_tanah' => $value[22],
            'kode_tanah' => $value[28],
            'asal_usul' => $value[29],
            'kondisi' => $value[30],
            'nilai' => $value[31],
            'keterangan' => $value[34],
            'tahun' => $value[35],
            'kd_pemilik' => $value[10],
            'id_kategori' => $result_kat->id,
            'id_organisasi' => $id_organisasi,
            'is_deleted' => 0
            );
        }

        $this->session->set_userdata('temp_import', $temp);
        return;
    }
}