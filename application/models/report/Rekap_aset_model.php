<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_aset_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_rekapitulasi_aset_17($level = 1, $org = "")
	{
        if($org === '7.1' OR $org === '8.1') {
            $kode = explode('.', $org);
            $where 	  = "WHERE o.kd_bidang = {$kode[0]} AND kd_unit = {$kode[1]}";
            $whereKDP = "AND o.kd_bidang = {$kode[0]} AND kd_unit = {$kode[1]}";
        } else {
            $where 	  = ($org==='all') ? "" : "WHERE id_organisasi = {$org}";
		    $whereKDP = ($org==='all') ? "" : "AND id_organisasi = {$org}";
        }

		$querya = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' {$whereKDP} GROUP BY kd_golongan";
		$queryb = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan";
		$queryc = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' {$whereKDP} GROUP BY kd_golongan";
		$queryd = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' {$whereKDP} GROUP BY kd_golongan";
		$querye = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan";
		
		$querykdpa = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan";
		$querykdpc = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan";
		$querykdpd = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan";
		$queryf    = "SELECT kd_golongan, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";

		$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
		$lv1  = $this->db->query($query)->result();
		$lv1  = $this->kodefikasi($lv1);

		if ($level > 1) {
			$querya = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryb = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan, k.kd_bidang";
			$queryc = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryd = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querye = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan, k.kd_bidang";
			
			$querykdpa = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querykdpc = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querykdpd = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryf    = "SELECT kd_golongan, kd_bidang, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";

			$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
			$lv2  = $this->db->query($query)->result();
			$lv2  = $this->kodefikasi($lv2);
			
			foreach ($lv1 as $lv1_key => $lv1_value) {
				$lv1_value->detail = array();
				foreach ($lv2 as $lv2_key => $lv2_value) {
					if ($lv2_value->kd_golongan === $lv1_value->kd_golongan) {
						$lv1_value->detail[] = $lv2_value;
						unset($lv2_value);
					}
				}
			}
		}

		if ($level > 2) {
			$querya = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryb = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryc = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryd = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querye = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id {$where} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			
			$querykdpa = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querykdpc = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querykdpd = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryf    = "SELECT kd_golongan, kd_bidang, kd_kelompok, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";

			$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
			$lv3  = $this->db->query($query)->result();
			$lv3  = $this->kodefikasi($lv3);
			
			foreach ($lv1 as $lv1_key => $lv1_value) {
				foreach ($lv1_value->detail as $lv2_key => $lv2_value) {
					$lv2_value->detail = array();
					foreach ($lv3 as $lv3_key => $lv3_value) {
						if ($lv3_value->kd_golongan === $lv2_value->kd_golongan && $lv3_value->kd_bidang === $lv2_value->kd_bidang) {
							$lv2_value->detail[] = $lv3_value;
							unset($lv3_value);
						}
					}
				}
			}
		}
		
		return $lv1;
	}

	public function get_rekapitulasi_aset_13($level = 1, $org = "")
	{
        if($org === '7.1' OR $org === '8.1') {
            $kode = explode('.', $org);
            $where 	  = "WHERE o.k.kd_bidang = {$kode[0]} AND kd_unit = {$kode[1]}";
            $whereKDP = "AND o.k.kd_bidang = {$kode[0]} AND kd_unit = {$kode[1]}";
        } else {
            $where 	  = ($org==='all') ? "" : "WHERE id_organisasi = {$org}";
		    $whereKDP = ($org==='all') ? "" : "AND id_organisasi = {$org}";
        }
		
		$querya = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$queryb = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$queryc = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$queryd = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$querye = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		
		$querykdpa = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$querykdpc = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$querykdpd = "SELECT kd_golongan, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan";
		$queryf    = "SELECT kd_golongan, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";

		$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
		$lv1  = $this->db->query($query)->result();
		$lv1  = $this->kodefikasi($lv1);

		if ($level > 1) {
			$querya = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryb = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryc = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryd = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querye = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			
			$querykdpa = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querykdpc = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$querykdpd = "SELECT kd_golongan, k.kd_bidang, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang";
			$queryf    = "SELECT kd_golongan, kd_bidang, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";
			
			$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
			$lv2  = $this->db->query($query)->result();
			$lv2  = $this->kodefikasi($lv2);
			
			foreach ($lv1 as $lv1_key => $lv1_value) {
				$lv1_value->detail = array();
				foreach ($lv2 as $lv2_key => $lv2_value) {
					if ($lv2_value->kd_golongan === $lv1_value->kd_golongan) {
						$lv1_value->detail[] = $lv2_value;
						unset($lv2_value);
					}
				}
			}
		}

		if ($level > 2) {
			$querya = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '1' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryb = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryc = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '3' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryd = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '4' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querye = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			
			$querykdpa = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querykdpc = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_c JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$querykdpd = "SELECT kd_golongan, k.kd_bidang, kd_kelompok, COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_d JOIN kategori k ON id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE kd_golongan = '6' AND kondisi < 3 {$whereKDP} GROUP BY kd_golongan, k.kd_bidang, kd_kelompok";
			$queryf    = "SELECT kd_golongan, kd_bidang, kd_kelompok, SUM(jumlah_aset) AS jumlah_aset, SUM(jumlah_nilai) as jumlah_nilai FROM ({$querykdpa} UNION {$querykdpc} UNION {$querykdpd}) AS kdp";

			$query  = "SELECT * FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye} UNION {$queryf}) AS q";
			$lv3  = $this->db->query($query)->result();
			$lv3  = $this->kodefikasi($lv3);
			
			foreach ($lv1 as $lv1_key => $lv1_value) {
				foreach ($lv1_value->detail as $lv2_key => $lv2_value) {
					$lv2_value->detail = array();
					foreach ($lv3 as $lv3_key => $lv3_value) {
						if ($lv3_value->kd_golongan === $lv2_value->kd_golongan && $lv3_value->kd_bidang === $lv2_value->kd_bidang) {
							$lv2_value->detail[] = $lv3_value;
							unset($lv3_value);
						}
					}
				}
			}
		}

		$querya = "SELECT COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_a JOIN organisasi o ON id_organisasi = o.id WHERE kondisi = 3 {$whereKDP}";
		$queryb = "SELECT COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_b JOIN organisasi o ON id_organisasi = o.id WHERE kondisi = 3 {$whereKDP}";
		$queryc = "SELECT COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_c JOIN organisasi o ON id_organisasi = o.id WHERE kondisi = 3 {$whereKDP}";
		$queryd = "SELECT COUNT(nilai) AS jumlah_aset, SUM(nilai + nilai_tambah) as jumlah_nilai FROM aset_d JOIN organisasi o ON id_organisasi = o.id WHERE kondisi = 3 {$whereKDP}";
		$querye = "SELECT COUNT(nilai) AS jumlah_aset, SUM(nilai) as jumlah_nilai FROM aset_e JOIN organisasi o ON id_organisasi = o.id WHERE kondisi = 3 {$whereKDP}";

		$query  = "SELECT SUM(q.jumlah_aset) AS jumlah_aset, SUM(q.jumlah_nilai) AS jumlah_nilai FROM ({$querya} UNION {$queryb} UNION {$queryc} UNION {$queryd} UNION {$querye}) AS q";
		$result = $this->db->query($query)->result()[0];
		$result->kd_barang = '01.05.05';
		$result->kategori  = 'Aset Lainnya';
		$result->detail    = array();
		# Level 2
		$result->detail[0] = new stdClass();
		$result->detail[0]->jumlah_aset  = $result->jumlah_aset;
		$result->detail[0]->jumlah_nilai = $result->jumlah_nilai;
		$result->detail[0]->kd_barang 	= '01.05.05.01';
		$result->detail[0]->kategori  	= 'Aset Non Operasional';
		$result->detail[0]->detail 		= array();
		# Level 3
		$result->detail[0]->detail[0] = new stdClass();
		$result->detail[0]->detail[0]->jumlah_aset  	= $result->jumlah_aset;
		$result->detail[0]->detail[0]->jumlah_nilai 	= $result->jumlah_nilai;
		$result->detail[0]->detail[0]->kd_barang 		= '01.05.05.01.02';
		$result->detail[0]->detail[0]->kategori  		= 'Aset Dalam Proses Penghapusan';

		if ($result->jumlah_aset > 0) {
			$lv1[] = $result;
		}
		
		return $lv1;
	}

	public function kodefikasi($data)
	{
		if (empty($data[0]->jumlah_aset)) {
			return $data;
		}

		$this->load->model('Kategori_model','kategori');
		$temp = $this->kategori->get_many_by(array('jenis<'=>4));

		foreach ($data as $index=>$item) {

			if (empty($item->kd_golongan)) {
				unset($data[$index]);
			}

			$this->db->where('kd_golongan', $item->kd_golongan);

			if (isset($item->kd_bidang)) {
				$this->db->where('kd_bidang', $item->kd_bidang);
			}

			if (isset($item->kd_kelompok)) {
				$this->db->where('kd_kelompok', $item->kd_kelompok);
			}

			$item->kategori = $this->db->get('kategori')->result();
			$item->kategori = empty($item->kategori) ? '' : $item->kategori[0]->nama;
        }

		return $data;
	}
}