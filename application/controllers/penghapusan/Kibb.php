<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/8/2018
 * Time: 4:49 PM
 */

class Kibb extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibb_model', 'kib');
        $this->load->model('aset/Temp_kibb_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');
        $this->load->model('Penghapusan_model', 'hapus');
        $this->load->library('pagination');
    }


    public function add($id_hapus = NULL)
    {
        $this->load->model('Penghapusan_model', 'hapus');
        if (empty($id_hapus))
            show_404();

        $data['hapus'] = $this->hapus->get($id_hapus);
        $where_not_in = $this->kib_temp->select('id_aset')->as_array()->get_many_by('id_hapus', $id_hapus);
        $where_not_in = array_column($where_not_in, 'id_aset');

        $filter = $this->input->get();
        $filter['id_organisasi'] = $data['hapus']->id_organisasi;

        $result = $this->kib->where_not_in('id', !empty($where_not_in) ? $where_not_in : "")->get_data($filter);

        $data['filter'] = $filter;
        $data['kib'] = $result['data'];
        $data['terpilih_count'] = count($where_not_in);
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this) . '/add_penghapusan');
        $this->render('modules/penghapusan/kibb', $data);
    }

    public function insert()
    {
        $input = $this->input->post();
        $kib = $this->kib->as_array()->get($input['id_aset']);
        $kib['id_hapus'] = $input['id_hapus'];
        $kib['id_aset']  = $input['id_aset'];
        unset($kib['id']);
        $sukses = $this->kib_temp->insert($kib);
        if($sukses) {
            $terpilih_count = $this->kib_temp->count_by('id_hapus', $input['id_hapus']);
            echo json_encode(array('status'=>'sukses', 'terpilih_count'=> $terpilih_count));
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_hapus = $this->kib_temp->get($id)->id_hapus;
        $sukses = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('penghapusan/rincian/' . $id_hapus);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('penghapusan/rincian/' . $id_hapus);
        }
    }
}