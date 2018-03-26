<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/13/2018
 * Time: 3:25 PM
 */

class Label_model extends MY_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function get_data_label($id_ruangan)
    {
        $select = 'sast.id, sast.kd_pemilik, o.kd_unit, kd_subunit, kd_upb, sast.tgl_perolehan, sast.reg_barang, sast.id_ruangan, sast.keterangan, kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama';
        $select2 = 'ast.id, ast.kd_pemilik, o.kd_unit, kd_subunit, kd_upb, ast.tgl_perolehan, ast.reg_barang, ast.id_ruangan, ast.keterangan, kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama';
        $where  = "sast.is_deleted = 0 AND id_ruangan = {$id_ruangan}";
        $where2  = "ast.is_deleted = 0 AND id_ruangan = {$id_ruangan}";
        $qA  = "SELECT {$select} FROM saldo_aset_b sast JOIN kategori k ON sast.id_kategori = k.id JOIN organisasi o ON sast.id_organisasi = o.id WHERE {$where}";
        $qB  = "SELECT {$select2} FROM aset_b ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON ast.id_organisasi = o.id WHERE {$where2}";
        $query = "SELECT * FROM ({$qA} UNION {$qB}) as q";
        return $this->db->query($query)->result();
    }
}