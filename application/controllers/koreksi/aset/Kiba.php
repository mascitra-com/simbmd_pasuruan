<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kiba extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kiba_model', 'kib');
        $this->load->model('aset/Temp_kiba_model', 'kib_temp');
        $this->load->model('Koreksi_model', 'koreksi');
        $this->load->model('Koreksi_detail_model', 'koreksi_detail');
        $this->load->library('Pagination');
    }

    public function koreksi_nilai($id_koreksi = NULL)
    {
    	if(empty($id_koreksi))
    		show_404();

    	$data['koreksi'] = $this->koreksi->get($id_koreksi);

        # INI DUPLIKAT!!!
        if ($data['koreksi']->status_pengajuan !== '0' AND $data['koreksi']->status_pengajuan !== '3') {
            $this->message('Data sedang menunggu persetujuan atau telah disetujui');
            $this->go('koreksi/nilai/rincian/'.$id_koreksi);
        }

        # PENTING!!!
        // $where_not_in = $this->kib_temp->select('id_aset')->join('koreksi','temp_aset_a.id_koreksi=koreksi.id')->or_where(array('id_koreksi'=>$id_koreksi, 'status_pengajuan<>'=>2))->as_array()->get_all();
        $where_not_in = $this->kib_temp->select('id_aset')->join('koreksi','temp_aset_a.id_koreksi=koreksi.id')->where(array('id_koreksi'=>$id_koreksi))->as_array()->get_all();
        $where_not_in = array_column($where_not_in, 'id_aset');
        
        # FILTER
        $filter = $this->input->get();
        $filter['id_organisasi'] =  $data['koreksi']->id_organisasi;

        $result = $this->kib->where_not_in('id', !empty($where_not_in)?$where_not_in:'')->get_data($filter);

        $data['filter']         = $filter;
        $data['kib']            = $result['data'];
        $data['terpilih_count'] = count($where_not_in);
        $data['pagination']     = $this->pagination->get_pagination($result['data_count'], $filter, 'koreksi/aset/koreksi_nilai');

        $this->render('modules/koreksi/nilai/kiba', $data);
    }

    public function insert_nilai()
    {
        $data = $this->input->post();
        $id_koreksi = $data['id_koreksi'];
        $id_aset    = $data['id_aset'];
        unset($data['id_koreksi'], $data['id_aset']);

        # Prepare data koreksi_detail
        $data['original_value']  = unmonefy($data['original_value']);
        $data['corrected_value'] = unmonefy($data['corrected_value']);
        unset($data['id_koreksi'], $data['id_aset']);

        $sukses = $this->koreksi_detail->insert($data);
        if($sukses) {
            # Prepare data kib_temp
            $data_kib = $this->kib->get($id_aset);
            $data_kib->id_aset    = $data_kib->id;
            $data_kib->id_koreksi = $id_koreksi;
            $data_kib->id_koreksi_detail = $sukses;
            unset($data_kib->id, $data_kib->id_spk, $data_kib->id_sp2d, $data_kib->id_hibah);

            $sukses2 = $this->kib_temp->insert((array)$data_kib);
            if($sukses2) {
                $this->message('Data berhasil ditambah','success');
                $this->go('koreksi/aset/kiba/koreksi_nilai/'.$id_koreksi);
            } else {
                # ROLL OUT
                $this->koreksi_nilai->delete($sukses);

                $this->message('Data gagal disimpan','danger');
                $this->go('koreksi/aset/kiba/koreksi_nilai/'.$id_koreksi);
            }

        } else {
            $this->message('Data gagal disimpan','danger');
            $this->go('koreksi/aset/kiba/koreksi_nilai/'.$id_koreksi);
        }
    }

    public function delete_nilai($id_temp = NULL)
    {
        if(empty($id_temp))
            show_404();

        $temp  = $this->kib_temp->get($id_temp);
        $temp_koreksi_detail = $this->koreksi_detail->get($temp->id_koreksi_detail);

        $sukses = $this->koreksi_detail->delete($temp_koreksi_detail->id);
        if($sukses) {

            $sukses2 = $this->kib_temp->delete($temp->id);
            if($sukses2) {
                $this->message('Data berhasil dihapus','success');
                $this->go('koreksi/nilai/rincian/'.$temp->id_koreksi);
            } else {
                # Roll out
                $this->koreksi_detail->insert($temp_koreksi_detail);

                $this->message('Data gagal dihapus','danger');
                $this->go('koreksi/nilai/rincian/'.$temp->id_koreksi);
            }

        } else {
            $this->message('Data gagal dihapus','danger');
            $this->go('koreksi/nilai/rincian/'.$temp->id_koreksi);
        }
    }
}