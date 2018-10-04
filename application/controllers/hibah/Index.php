<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hibah_model', 'hibah');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kegiatan_model', 'kegiatan');

        $this->load->model('aset/Kiba_model', 'kiba');
        $this->load->model('aset/Kibb_model', 'kibb');
        $this->load->model('aset/Kibc_model', 'kibc');
        $this->load->model('aset/Kibd_model', 'kibd');
        $this->load->model('aset/Kibe_model', 'kibe');
        $this->load->model('aset/Kibg_model', 'kibg');
        $this->load->model('aset/Temp_kiba_model', 'kiba_temp');
        $this->load->model('aset/Temp_kibb_model', 'kibb_temp');
        $this->load->model('aset/Temp_kibc_model', 'kibc_temp');
        $this->load->model('aset/Temp_kibd_model', 'kibd_temp');
        $this->load->model('aset/Temp_kibe_model', 'kibe_temp');
        $this->load->model('aset/Temp_kibg_model', 'kibg_temp');
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

    }

    public function index()
    {
        $this->load->library('Pagination');

        $filter = $this->input->get();
        $result = $this->hibah->get_data($filter);
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        
        if(isset($filter['page']))
            $this->session->set_userdata('hibah_page', $filter['page']);
        else
            $this->session->set_userdata('hibah_page', '1');

        $data['hibah'] = $result['data'];
        $data['filter'] = $filter;
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'hibah/'.get_class($this));
        $data['kegiatan'] = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);
        $this->render('modules/hibah/index', $data);
    }

    public function add()
    {
        $data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
        $filter['id_organisasi'] = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi'] 	 = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }
        $this->render('modules/hibah/form', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah/index?id_organisasi=' . $data['id_organisasi']);
        }

        if ($_FILES['berkas']['size'] > 0) {
            $config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
            $config['file_name']         = 'hbh_'.uniqchar(5);
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
            $config['max_size']      = 1000;
            $config['overwrite']     = TRUE;

            $this->load->library('upload', $config);
            
            # Jika gagal
            if (!$this->upload->do_upload('berkas')) {
                $this->message($this->upload->display_errors(), 'danger');
                $this->go('hibah/index?id_organisasi='.$data['id_organisasi']);
            }

            $data['dokumen'] = $this->upload->data('file_name');
        }

        $sukses = $this->hibah->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('hibah/index/detail/' . $sukses);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index?id_organisasi=' . $data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id = $data['id'];

        unset($data['id']);

        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah/index/detail/' . $id);
        }

        # Upload
        $file_name = empty($this->hibah->get($id)->dokumen)?'hbh_'.uniqchar(5):explode('.', $this->hibah->get($id)->dokumen)[0];
        if ($_FILES['berkas']['size'] > 0) {
            $config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
            $config['file_name']     = $file_name;
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
            $config['max_size']      = 1000;
            $config['overwrite']     = TRUE;

            $this->load->library('upload', $config);
            
            # Jika gagal
            if (!$this->upload->do_upload('berkas')) {
                $this->message($this->upload->display_errors(), 'danger');
                $this->go('hibah/index/rincian/'.$id);
            }

            $data['dokumen'] = $this->upload->data('file_name');
        }

        $sukses = $this->hibah->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/index/detail/' . $id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/' . $id);
        }
    }

    public function detail($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['hibah']    = $this->hibah->subtitute($this->hibah->get($id));
        $data['kegiatan'] = $this->kegiatan->get_data_by_organisasi($data['hibah']->id_organisasi->id);
        $data['ref']      = !empty($this->input->get('ref')) ? 'true' : '';

        $this->render('modules/hibah/detail', $data);
    }

    public function rincian($id = NULL)
    {
        $data['hibah'] = $this->hibah->subtitute($this->hibah->get($id));
        # RINCIAN
        // # COUNT
        $data['kiba']['count'] = $this->kiba_temp->count_by(array('id_hibah'=>$id));
        $data['kiba']['sum']   = $this->kiba_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['kibb']['count'] = $this->kibb_temp->count_by(array('id_hibah'=>$id));
        $data['kibb']['sum']   = $this->kibb_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['kibc']['count'] = $this->kibc_temp->count_by(array('id_hibah'=>$id));
        $data['kibc']['sum']   = $this->kibc_temp->select("SUM(nilai+nilai_tambah) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['kibd']['count'] = $this->kibd_temp->count_by(array('id_hibah'=>$id));
        $data['kibd']['sum']   = $this->kibd_temp->select("SUM(nilai+nilai_tambah) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['kibe']['count'] = $this->kibe_temp->count_by(array('id_hibah'=>$id));
        $data['kibe']['sum']   = $this->kibe_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['kibg']['count'] = $this->kibg_temp->count_by(array('id_hibah'=>$id));
        $data['kibg']['sum']   = $this->kibg_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_hibah'=>$id))[0]->nilai;

        $data['kpt']['count'] = $this->kapitalisasi->count_by(array('id_hibah'=>$id));
        $data['kpt']['sum']   = $this->kapitalisasi->select("SUM(nilai) AS nilai")->get_many_by(array('id_hibah'=>$id))[0]->nilai;
        
        $data['ref']   = !empty($this->input->get('ref')) ? 'true' : '';

        $this->render('modules/hibah/rincian', $data);
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $id_organisasi = $this->hibah->get($id)->id_organisasi;

        $sukses = $this->hibah->delete($id);
        if($sukses) {
            $this->kiba_temp->delete_by(array('id_hibah'=>$id));
            $this->kibb_temp->delete_by(array('id_hibah'=>$id));
            $this->kibc_temp->delete_by(array('id_hibah'=>$id));
            $this->kibd_temp->delete_by(array('id_hibah'=>$id));
            $this->kibe_temp->delete_by(array('id_hibah'=>$id));
            $this->kibg_temp->delete_by(array('id_hibah'=>$id));
            $this->kapitalisasi->delete_by(array('id_hibah'=>$id));

            $this->message('Data berhasil dihapus','success');
        } else {
            $this->message('Data gagal dihapus','danger');
        }
        $this->go('hibah/index?id_organisasi='.$id_organisasi);
    }

    public function rincian_redirect($id = null)
    {
        if (empty($id))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
            $this->go('hibah/kiba/add/' . $id);
            break;
            case 'b':
            $this->go('hibah/kibb/add/' . $id);
            break;
            case 'c':
            $this->go('hibah/kibc/add/' . $id);
            break;
            case 'd':
            $this->go('hibah/kibd/add/' . $id);
            break;
            case 'e':
            $this->go('hibah/kibe/add/' . $id);
            break;
            case 'g':
            $this->go('hibah/kibg/add/' . $id);
            break;
            case 'tambah':
            $this->go('hibah/kapitalisasi/add/' . $id);
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
        $sukses = $this->hibah->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil','success');
            $this->go('hibah/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->hibah->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil dibatalkan','success');
            $this->go('hibah/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/'.$id);
        }
    }

    public function abort_transaction($id_hibah = NULL)
    {
        # JIKA KOSONG
        if (empty($id_hibah)) {
            $this->message('Pilih data hibah yang akan dibatalkan', 'danger');
            $this->go('hibah/index/');
        }

        # AMBIL DATA hibah
        $hibah = $this->hibah->get($id_hibah);

        # CEK KETERSEDIAAN PEMBATALAN
        $abort_status = $this->check_abort_status($hibah->id);
        if (!$abort_status['status']) {
            $this->message($abort_status['reason'], 'danger');
            $this->go('hibah/index?id_organisasi='.$hibah->id_organisasi);
        }

        # ABOOORT - HAPUS RINCIAN
        $this->kiba->delete_by(array('id_hibah'=>$id_hibah));
        $this->kibb->delete_by(array('id_hibah'=>$id_hibah));
        $this->kibc->delete_by(array('id_hibah'=>$id_hibah));
        $this->kibd->delete_by(array('id_hibah'=>$id_hibah));
        $this->kibe->delete_by(array('id_hibah'=>$id_hibah));
        $this->kibg->delete_by(array('id_hibah'=>$id_hibah));

        # KAPIPTALISASI
        $kap = $this->kapitalisasi->get_many_by('id_hibah', $id_hibah);
        foreach ($kap as $item) {
            # Update data pada aset utama
            $kib  = ($item->golongan==='3') ? 'kibc' : 'kibd';
            $temp = $this->{$kib}->get($item->id_aset);
            $nilai_kurang = $this->nol($item->jumlah) * $this->nol($item->nilai);
            $total = $temp->nilai_tambah - $nilai_kurang;
            $total = $total < 0 ? 0 : $total;
            
            $this->{$kib}->update($item->id_aset, array('nilai_tambah'=>$total));
        }

        $this->hibah->update($id_hibah, array('status_pengajuan'=>0));

        $this->message('hibah berhasil dibatalkan','success');
        $this->go('hibah/index?id_organisasi='.$hibah->id_organisasi);
    }

    private function check_abort_status($id_hibah = NULL)
    {
        if (empty($id_hibah)) {
            return array('status'=>FALSE, 'reason'=>'id hibah kosong');
        }

        $hibah = $this->hibah->get($id_hibah);

        if (empty($hibah)) {
            return array('status'=>FALSE, 'reason'=>'id hibah tidak valid');
        }

        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            # SET MODEL
            $model_kib  = "kib{$item}";
            $model_kib_temp  = "kib{$item}_temp";

            $result = $this->{$model_kib}->select("COUNT(id) AS total, SUM(nilai) AS jumlah")->get_by(array('id_hibah'=>$hibah->id, 'id_organisasi'=>$hibah->id_organisasi));
            $result_temp = $this->db->query("SELECT COUNT(id) AS total, SUM(nilai) AS jumlah FROM ".$this->{$model_kib_temp}->_table." WHERE id_aset IN(SELECT id FROM ".$this->{$model_kib}->_table." WHERE id_hibah = {$hibah->id} AND id_organisasi = {$hibah->id_organisasi}) OR id_hibah = {$hibah->id}")->row();

            if ($result->total!==$result_temp->total OR $result->jumlah!==$result_temp->jumlah) {
                return array('status'=>FALSE, 'reason'=>'Rincian hibah terikat dengan transaksi lainnya.');
            }
        }

        return array('status'=>TRUE);
    }

    public function get_abort_status($id_hibah = NULL) {
        if (empty($id_hibah)) {
            echo json_encode(array('status'=>FALSE, 'reason'=>'ID hibah KOSONG'));
        } else {
            echo json_encode($this->check_abort_status($id_hibah));
        }
    }

    private function nol($var)
    {
        return (empty($var)) ? 0 : $var;
    }
}