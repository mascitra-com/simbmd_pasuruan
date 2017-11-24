<?php
class Migration_organisasi_user_data extends CI_Migration {

    public function up() {
        $data = array(
            array('kd_bidang'=>'1', 'nama'=>'Sekwan/DPRD', 'jenis'=>1),
            array('kd_bidang'=>'2', 'nama'=>'Gubernur/Bupati/Walikota', 'jenis'=>1),
            array('kd_bidang'=>'3', 'nama'=>'Wakil Gubernur/Bupati/Walikota', 'jenis'=>1),
            array('kd_bidang'=>'4', 'nama'=>'Sekretariat Daerah', 'jenis'=>1),
            array('kd_bidang'=>'5', 'nama'=>'Bidang Kimpraswil', 'jenis'=>1),
            array('kd_bidang'=>'6', 'nama'=>'Bidang Perhubungan', 'jenis'=>1),
            array('kd_bidang'=>'7', 'nama'=>'Bidang Kesehatan', 'jenis'=>1),
            array('kd_bidang'=>'8', 'nama'=>'Bidang Pendidikan dan Kebudayaan', 'jenis'=>1),
            array('kd_bidang'=>'9', 'nama'=>'Bidang Sosial', 'jenis'=>1),
            array('kd_bidang'=>'10', 'nama'=>'Bidang Kependudukan', 'jenis'=>1),
            array('kd_bidang'=>'11', 'nama'=>'Bidang Pertanian', 'jenis'=>1),
            array('kd_bidang'=>'12', 'nama'=>'Bidang Perindustrian', 'jenis'=>1),
            array('kd_bidang'=>'13', 'nama'=>'Bidang Pendapatan', 'jenis'=>1),
            array('kd_bidang'=>'14', 'nama'=>'Bidang Pengawasan', 'jenis'=>1),
            array('kd_bidang'=>'15', 'nama'=>'Bidang Perencanaan', 'jenis'=>1),
            array('kd_bidang'=>'16', 'nama'=>'Bidang Lingkungan Hidup', 'jenis'=>1),
            array('kd_bidang'=>'17', 'nama'=>'Bidang Pariwisata', 'jenis'=>1),
            array('kd_bidang'=>'18', 'nama'=>'Bidang Kesatuan Bangsa', 'jenis'=>1),
            array('kd_bidang'=>'19', 'nama'=>'Bidang Kepegawaian', 'jenis'=>1),
            array('kd_bidang'=>'20', 'nama'=>'Bidang Penghubung', 'jenis'=>1),
            array('kd_bidang'=>'21', 'nama'=>'Bidang Kminfo dan Dokumentasi', 'jenis'=>1),
            array('kd_bidang'=>'22', 'nama'=>'Bidang BUMD', 'jenis'=>1),
            array('kd_bidang'=>'50', 'nama'=>'Kecamatan', 'jenis'=>1),
            );
        $this->db->insert_batch('organisasi', $data);

        $data = array(
        array('kd_bidang'=>'13','kd_unit'=>'1','kd_subunit'=>NULL,'kd_upb'=>NULL,'nama'=>'Dinas Pengelolaan Keuangan Daerah', 'jenis'=>2,'sub_dari'=>13),
        array('kd_bidang'=>'13','kd_unit'=>'1','kd_subunit'=>'1','kd_upb'=>NULL,'nama'=>'Dinas Pengelolaan Keuangan Daerah', 'jenis'=>3,'sub_dari'=>24),
        array('kd_bidang'=>'13','kd_unit'=>'1','kd_subunit'=>'1','kd_upb'=>'1','nama'=>'Dinas Pengelolaan Keuangan Daerah', 'jenis'=>4,'sub_dari'=>25),
        );
        $this->db->insert_batch('organisasi', $data);

        $data = array('nama'=>'Ainul Yaqin', 'nip'=>'10001', 'Jabatan'=>'Ketua', 'id_organisasi'=>26, 'username'=>'admin', 'password'=>password_hash('admin123', PASSWORD_BCRYPT), 'is_admin'=>1, 'is_superadmin'=>1);
        $this->db->insert('user', $data);
    }

    public function down() {
        $this->db->truncate('organisasi');
        $this->db->truncate('user');
    }
}