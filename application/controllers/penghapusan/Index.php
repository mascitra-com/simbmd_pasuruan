<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 12/12/2017
 * Time: 13.59
 */

class Index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Temp_kiba_model', 'kiba_temp');
        $this->load->model('aset/Temp_kibb_model', 'kibb_temp');
        $this->load->model('aset/Temp_kibc_model', 'kibc_temp');
        $this->load->model('aset/Temp_kibd_model', 'kibd_temp');
        $this->load->model('aset/Temp_kibe_model', 'kibe_temp');
        $this->load->model('aset/Temp_kibg_model', 'kibg_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Penghapusan_model', 'hapus');
    }

    public function index()
    {
        $this->load->library('Pagination');
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        $result = $this->hapus->get_data($filter);

        $data['hapus'] = $result['data'];
        $data['filter'] = $filter;
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'penghapusan/' . get_class($this));
        $this->render('modules/penghapusan/index', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        if (!$this->hapus->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('penghapusan?id_organisasi='.$data['id_organisasi']);
        }

        $id_insert = $this->hapus->insert($data);
        if($id_insert) {
            $this->message('Data berhasil disimpan','success');
            $this->go('penghapusan/index/detail/'.$id_insert);
        } else {
            $this->message('Terjadi kesalahan','danger');
            $this->go('penghapusan/index?id_organisasi='.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        
        $id = $data['id'];
        unset($data['id']);

        if (!$this->hapus->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('penghapusan/index/detail/'.$id);
        }

        $sukses = $this->hapus->update($id, $data);

        if($sukses) {
            $this->message('Data berhasil disimpan','success');
        } else {
            $this->message('Terjadi kesalahan','danger');
        }
        
        $this->go('penghapusan/index/detail/'.$id);
    }

    public function detail($id = null) {
        if (empty($id)) {
            show_404();
        }

        $data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));
        $data['ref']   = !empty($this->input->get('ref')) ? 'true' : '';
        $this->render('modules/penghapusan/detail', $data);
    }

    public function rincian($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        
        $data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));

        # COUNT
        $data['kiba']['count'] = $this->kiba_temp->count_by(array('id_hapus'=>$id));
        $data['kibb']['count'] = $this->kibb_temp->count_by(array('id_hapus'=>$id));
        $data['kibc']['count'] = $this->kibc_temp->count_by(array('id_hapus'=>$id));
        $data['kibd']['count'] = $this->kibd_temp->count_by(array('id_hapus'=>$id));
        $data['kibe']['count'] = $this->kibe_temp->count_by(array('id_hapus'=>$id));
        $data['kibg']['count'] = $this->kibg_temp->count_by(array('id_hapus'=>$id));
        # SUM
        $data['kiba']['sum'] = $this->kiba_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;
        $data['kibb']['sum'] = $this->kibb_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;
        $data['kibc']['sum'] = $this->kibc_temp->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;
        $data['kibd']['sum'] = $this->kibd_temp->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;
        $data['kibe']['sum'] = $this->kibe_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;
        $data['kibg']['sum'] = $this->kibg_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_hapus'=>$id))[0]->nilai;

        $data['ref'] = !empty($this->input->get('ref')) ? 'true' : '';

        $this->session->unset_userdata('hapus_aset');
        $this->render('modules/penghapusan/rincian', $data);
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $id_organisasi = $this->hapus->get($id)->id_organisasi;

        $sukses = $this->hapus->delete($id);
        if($sukses) {
            $this->kiba_temp->delete_by(array('id_hapus'=>$id));
            $this->kibb_temp->delete_by(array('id_hapus'=>$id));
            $this->kibc_temp->delete_by(array('id_hapus'=>$id));
            $this->kibd_temp->delete_by(array('id_hapus'=>$id));
            $this->kibe_temp->delete_by(array('id_hapus'=>$id));
            $this->kibg_temp->delete_by(array('id_hapus'=>$id));

            $this->message('Data berhasil dihapus','success');
            $this->go('penghapusan/index?id_organisasi='.$id_organisasi);
        } else {
            $this->message('Data gagal dihapus','danger');
            $this->go('penghapusan/index?id_organisasi='.$id_organisasi);
        }

    }

    public function rincian_redirect($id_hapus = null)
    {
        if(empty($id_hapus))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
            $this->go('penghapusan/kiba/add/'.$id_hapus);
            break;
            case 'b':
            $this->go('penghapusan/kibb/add/'.$id_hapus);
            break;
            case 'c':
            $this->go('penghapusan/kibc/add/'.$id_hapus);
            break;
            case 'd':
            $this->go('penghapusan/kibd/add/'.$id_hapus);
            break;
            case 'e':
            $this->go('penghapusan/kibe/add/'.$id_hapus);
            break;
            case 'g':
            $this->go('penghapusan/kibg/add/'.$id_hapus);
            break;
            default:
            show_404();
            break;
        }
    }
    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->hapus->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil','success');
            $this->go('penghapusan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('penghapusan/index/detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->hapus->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil dibatalkan','success');
            $this->go('penghapusan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('penghapusan/index/detail/'.$id);
        }
    }

    public function abort_transaction($id_hapus = NULL)
    {
        # JIKA KOSONG
        if (empty($id_hapus)) {
            $this->message('Pilih data penghapusan yang akan dibatalkan', 'danger');
            $this->go('penghapusan/index/');
        }

        # AMBIL DATA hapus
        $hapus = $this->hapus->get($id_hapus);

        # CEK KETERSEDIAAN PEMBATALAN
        $abort_status = $this->check_abort_status($hapus->id);
        if (!$abort_status['status']) {
            $this->message($abort_status['reason'], 'danger');
            $this->go('penghapusan/index?id_organisasi='.$hapus->id_organisasi);
        }

        # ABOOORT - KEMBALIKAN RINCIAN
        $this->load->model('aset/Kiba_model', 'kiba');
        $this->load->model('aset/Kibb_model', 'kibb');
        $this->load->model('aset/Kibc_model', 'kibc');
        $this->load->model('aset/Kibd_model', 'kibd');
        $this->load->model('aset/Kibe_model', 'kibe');
        $this->load->model('aset/Kibg_model', 'kibg');
        
        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            $kib = "kib{$item}";
            $kib_temp = "kib{$item}_temp";
            
            $temp = $this->{$kib_temp}->get_many_by(array('id_hapus'=>$id_hapus));

            if (!empty($temp)) {
                foreach ($temp as $key => $value) {
                    $value->id = $value->id_aset;
                    unset($value->id_aset,$value->id_transfer,$value->id_hapus,$value->id_koreksi,$value->id_koreksi_detail,$value->log_action,$value->log_user,$value->log_time);
                }
                $this->{$kib}->batch_insert($temp);
            }
        }

        $this->hapus->update($id_hapus, array('status_pengajuan'=>0));

        $this->message('Penghapusan berhasil dibatalkan','success');
        $this->go('penghapusan/index?id_organisasi='.$hapus->id_organisasi);
    }

    private function check_abort_status($id_hapus = NULL)
    {
        if (empty($id_hapus)) {
            return array('status'=>FALSE, 'reason'=>'id hapus kosong');
        }

        $hapus = $this->hapus->get($id_hapus);

        if (empty($hapus)) {
            return array('status'=>FALSE, 'reason'=>'id hapus tidak valid');
        }

        return array('status'=>TRUE);
    }

    public function get_abort_status($id_hapus = NULL) {
        if (empty($id_hapus)) {
            echo json_encode(array('status'=>FALSE, 'reason'=>'ID hapus KOSONG'));
        } else {
            echo json_encode($this->check_abort_status($id_hapus));
        }
    }
}