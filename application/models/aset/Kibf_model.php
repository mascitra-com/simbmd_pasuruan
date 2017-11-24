<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kibf_model extends MY_Model
{
	public $_table = 'aset_f';
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

        $this->where('id_organisasi', $filter['id_organisasi']);

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi']);

		$this->where('is_deleted',0);
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

    public function get_statistic($id_organisasi = NULL)
    {
        if (empty($id_organisasi)) {
            return array();
        }

        # JUMLAH ASET
        $val = $this->db->query("SELECT COUNT(id) AS jumlah FROM {$this->_table} WHERE id_organisasi='{$id_organisasi}' AND is_deleted = 0")->result()[0]->jumlah;
        $result[0]['title'] = 'Jumlah Aset';
        $result[0]['value'] = $val.' Buah';

        # JUMLAH NILAI ASET
        $val = $this->db->query("SELECT SUM(nilai) AS jumlah FROM {$this->_table} WHERE id_organisasi='{$id_organisasi}' AND is_deleted = 0")->result()[0]->jumlah;
        $result[1]['title'] = 'Jumlah Nilai Aset';
        $result[1]['value'] = 'Rp '.(monefy($val)).',-';

        # JUMLAH NILAI ASET TERTINGGI
        $val = $this->db->query("SELECT MAX(nilai) AS jumlah FROM {$this->_table} WHERE id_organisasi='{$id_organisasi}' AND is_deleted = 0")->result()[0]->jumlah;
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
            $kode['kd_golongan']  = $value[6];
            $kode['kd_bidang']  = $value[7];
            $kode['kd_kelompok']  = $value[8];
            $kode['kd_subkelompok']  = $value[9];
            $kode['kd_subsubkelompok']  = $value[10];

            $result_kat = $this->kategori->get_by($kode);
            
            # Jika kategori tak ada
            if (empty($result_kat)) {
                $temp['data_error'][] = array('baris_ke'=>$key+1, 'data'=>$value);
                continue;
            }

            $temp['data'][] = array(
            'reg_barang' => $value[11],
            'tgl_perolehan' => $value[13],
            'tgl_pembukuan' => $value[33],
            'tingkat' => $value[14],
            'beton' => $value[15],
            'panjang' => $value[16],
            'lebar' => $value[17],
            'luas_lantai' => $value[18],
            'lokasi' => $value[19],
            'dokumen_tgl' => $value[20],
            'dokumen_no' => $value[21],
            'status_tanah' => $value[22],
            'kode_tanah' => $value[28],
            'asal_usul' => $value[29],
            'kondisi' => $value[30],
            'nilai' => $value[31],
            'keterangan' => $value[32],
            'kd_pemilik' => $value[12],
            'id_kategori' => $result_kat->id,
            'id_organisasi' => $id_organisasi,
            'is_deleted' => 0
            );
        }

        $this->session->set_userdata('temp_import', $temp);
        return;
    }
}