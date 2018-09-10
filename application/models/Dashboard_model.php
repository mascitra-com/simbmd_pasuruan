<?php
class Dashboard_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_notification()
    {
    	$data['inventarisasi']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM inventarisasi WHERE status_pengajuan = 1")->row()->jumlah;
    	$data['inventarisasi']['icon']  = 'archive';
    	$data['inventarisasi']['link']  = site_url('persetujuan/inventarisasi');

        $data['pengadaan']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM spk WHERE status_pengajuan = 1")->row()->jumlah;
        $data['pengadaan']['icon']  = 'cart-plus';
        $data['pengadaan']['link']  = site_url('persetujuan/pengadaan');

    	$data['hibah']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM hibah WHERE status_pengajuan = 1")->row()->jumlah;
    	$data['hibah']['icon']  = 'cubes';
    	$data['hibah']['link']  = site_url('persetujuan/hibah');

    	$data['transfer']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM transfer WHERE status_pengajuan = 1")->row()->jumlah;
    	$data['transfer']['icon']  = 'exchange';
    	$data['transfer']['link']  = site_url('persetujuan/transfer');

    	$data['penghapusan']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM penghapusan WHERE status_pengajuan = 1")->row()->jumlah;
    	$data['penghapusan']['icon']  = 'trash';
    	$data['penghapusan']['link']  = site_url('persetujuan/penghapusan');

        $data['koreksi_nilai']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM koreksi WHERE status_pengajuan = 1 AND jenis_koreksi = 1")->row()->jumlah;
        $data['koreksi_nilai']['icon']  = 'money';
        $data['koreksi_nilai']['link']  = site_url('persetujuan/koreksi_nilai');

        $data['koreksi_kepemilikan']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM koreksi WHERE status_pengajuan = 1 AND jenis_koreksi = 2")->row()->jumlah;
        $data['koreksi_kepemilikan']['icon']  = 'user';
        $data['koreksi_kepemilikan']['link']  = site_url('persetujuan/koreksi_kepemilikan');

        $data['reklas_kode']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM koreksi WHERE status_pengajuan = 1 AND jenis_koreksi = 3")->row()->jumlah;
        $data['reklas_kode']['icon']  = 'tag';
        $data['reklas_kode']['link']  = site_url('persetujuan/koreksi_kode');

        $data['koreksi_hapus']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM koreksi WHERE status_pengajuan = 1 AND jenis_koreksi = 4")->row()->jumlah;
        $data['koreksi_hapus']['icon']  = 'times';
        $data['koreksi_hapus']['link']  = site_url('persetujuan/koreksi_hapus');

        $data['koreksi_atribut']['count'] = $this->db->query("SELECT COUNT(id) AS jumlah FROM koreksi WHERE status_pengajuan = 1 AND jenis_koreksi = 5")->row()->jumlah;
        $data['koreksi_atribut']['icon']  = 'puzzle-piece';
        $data['koreksi_atribut']['link']  = site_url('persetujuan/koreksi_atribut');

    	foreach ($data as $key => $value) {
    		if (empty($value['count'])) {
    			unset($data[$key]);
    		}
    	}

    	return $data;
    }
}