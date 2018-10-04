<?php
/**
* Created by PhpStorm.
* User: Rizki Herdatullah
* Date: 10/12/2017
* Time: 21.20
*/

class Index extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transfer_model', 'transfer');
        $this->load->model('Organisasi_model', 'organisasi');
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
    }

    public function index() {
        show_404();
    }

    public function keluar() {
        $this->load->library('pagination');

        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $result = $this->transfer->get_data($filter);
        $data['transfer'] 	= $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'],$filter,'transfer/index/keluar?id_organisasi='.$filter['id_organisasi']);
        $data['filter']   	= $filter;
        $this->render('modules/transfer/keluar', $data);
    }

    public function masuk() {
        $this->load->library('pagination');

        $filter = $this->input->get();
        $filter['id_tujuan'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $data['organisasi']  = $this->organisasi->get_data_by_auth();

        unset($filter['id_organisasi']);

        $result = $this->transfer->get_data_masuk($filter);
        $data['transfer']   = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'],$filter,'transfer/index/masuk?id_organisasi='.$filter['id_tujuan']);
        $data['filter']     = $filter;
        $this->render('modules/transfer/masuk', $data);
    }

    public function add($id = null) {
        if (empty($id)) {
            $this->message('Pilih UPB Terlebih Dahulu', 'warning');
            $this->go('transfer/index/keluar');
        }

        $data['organisasi'] = $this->organisasi->get_many_by(array('jenis' => 4, 'id<>'=>$this->auth->get_id_organisasi()));
        $data['org'] = $this->organisasi->get($id);

        $this->render('modules/transfer/form', $data);
    }

    public function detail($id = null) {
        $data['ref'] = $this->input->get('ref');

        if (empty($id) OR ($data['ref'] !== 'keluar' && $data['ref'] !== 'masuk' && $data['ref'] !== 'persetujuan')) {
            show_404();
        }

        $data['transfer']   = $this->transfer->subtitute($this->transfer->get($id));
        $data['organisasi'] = $this->organisasi->get_many_by(array('jenis' => 4, 'id<>'=>$this->auth->get_id_organisasi()));

        $this->render('modules/transfer/detail', $data);
    }

    public function rincian($id = null) {
        $data['ref'] = $this->input->get('ref');

        if (empty($id) OR ($data['ref'] !== 'keluar' && $data['ref'] !== 'masuk' && $data['ref'] !== 'persetujuan'))
            show_404();

        $data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));

        # COUNT
        $data['kiba']['count'] = $this->kiba_temp->count_by(array('id_transfer'=>$id));
        $data['kibb']['count'] = $this->kibb_temp->count_by(array('id_transfer'=>$id));
        $data['kibc']['count'] = $this->kibc_temp->join('kategori','id_kategori=kategori.id')->count_by(array('id_transfer'=>$id,'kd_golongan<>'=>6));
        $data['kibd']['count'] = $this->kibd_temp->join('kategori','id_kategori=kategori.id')->count_by(array('id_transfer'=>$id,'kd_golongan<>'=>6));
        $data['kibe']['count'] = $this->kibe_temp->count_by(array('id_transfer'=>$id));
        $data['kibg']['count'] = $this->kibg_temp->count_by(array('id_transfer'=>$id));
        $data['kdpc']['count'] = $this->kibc_temp->join('kategori','id_kategori=kategori.id')->count_by(array('id_transfer'=>$id,'kd_golongan'=>6));
        $data['kdpd']['count'] = $this->kibd_temp->join('kategori','id_kategori=kategori.id')->count_by(array('id_transfer'=>$id,'kd_golongan'=>6));
        # SUM
        $data['kiba']['sum'] = $this->kiba_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_transfer'=>$id))[0]->nilai;
        $data['kibb']['sum'] = $this->kibb_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_transfer'=>$id))[0]->nilai;
        $data['kibc']['sum'] = $this->kibc_temp->join('kategori','id_kategori=kategori.id')->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_transfer'=>$id,'kd_golongan<>'=>6))[0]->nilai;
        $data['kibd']['sum'] = $this->kibd_temp->join('kategori','id_kategori=kategori.id')->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_transfer'=>$id,'kd_golongan<>'=>6))[0]->nilai;
        $data['kibe']['sum'] = $this->kibe_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_transfer'=>$id))[0]->nilai;
        $data['kibg']['sum'] = $this->kibg_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_transfer'=>$id))[0]->nilai;
        $data['kdpc']['sum'] = $this->kibc_temp->join('kategori','id_kategori=kategori.id')->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_transfer'=>$id,'kd_golongan'=>6))[0]->nilai;
        $data['kdpd']['sum'] = $this->kibd_temp->join('kategori','id_kategori=kategori.id')->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_transfer'=>$id,'kd_golongan'=>6))[0]->nilai;

        $this->render('modules/transfer/rincian', $data);
    }

    public function rincian_redirect($id = null)
    {
        if(empty($id))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
            $this->go('transfer/kiba/add/'.$id);
            break;
            case 'b':
            $this->go('transfer/kibb/add/'.$id);
            break;
            case 'c':
            $this->go('transfer/kibc/add/'.$id);
            break;
            case 'd':
            $this->go('transfer/kibd/add/'.$id);
            break;
            case 'e':
            $this->go('transfer/kibe/add/'.$id);
            break;
            case 'g':
            $this->go('transfer/kibg/add/'.$id);
            break;
            case 'kdpc':
            $this->go('transfer/kibc/add/'.$id.'/TRUE');
            break;
            case 'kdpd':
            $this->go('transfer/kibd/add/'.$id.'/TRUE');
            break;
            default:
            show_404();
            break;
        }
    }

    public function insert()
    {
        $data = $this->input->post();

        if (!$this->transfer->form_verify($data)) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('transfer/index/add/'.$data['id_organisasi']);
        }

        if ($_FILES['berkas']['size'] > 0) {
            $config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
            $config['file_name']         = 'tfr_'.uniqchar(5);
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
            $config['max_size']      = 1000;
            $config['overwrite']     = TRUE;

            $this->load->library('upload', $config);
            
            # Jika gagal
            if (!$this->upload->do_upload('berkas')) {
                $this->message($this->upload->display_errors(), 'danger');
                $this->go('transfer/index/add/'.$data['id_organisasi']);
            }

            $data['dokumen'] = $this->upload->data('file_name');
        }

        $sukses = $this->transfer->insert($data);
        if($sukses) {
            $this->message('Data berhasil ditambah','success');
            $this->go('transfer/index/detail/'.$sukses.'?ref=keluar');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/add/'.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);

        if (!$this->transfer->form_verify($data)) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('transfer/index/detail/'.$data['id'].'?ref=keluar');
        }

        # Upload
        $file_name = empty($this->transfer->get($id)->dokumen)?'trf_'.uniqchar(5):explode('.', $this->transfer->get($id)->dokumen)[0];
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
                $this->go('transfer/index/detail/'.$data['id'].'?ref=keluar');
            }

            $data['dokumen'] = $this->upload->data('file_name');
        }

        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil ditambah','success');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        }
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $id_organisasi = $this->transfer->get($id)->id_organisasi;
        $sukses        = $this->transfer->delete($id);
        if($sukses) {
            $this->kiba_temp->delete_by(array('id_transfer'=>$id));
            $this->kibb_temp->delete_by(array('id_transfer'=>$id));
            $this->kibc_temp->delete_by(array('id_transfer'=>$id));
            $this->kibd_temp->delete_by(array('id_transfer'=>$id));
            $this->kibe_temp->delete_by(array('id_transfer'=>$id));
            $this->kibg_temp->delete_by(array('id_transfer'=>$id));

            $this->message('Data berhasil ditransfer','success');
            $this->go('transfer/index/keluar?id_organisasi='.$id_organisasi);
        } else {
            $this->message('Data gagal ditransfer','danger');
            $this->go('transfer/index/keluar?id_organisasi='.$id_organisasi);
        }

    }

    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil diajukan','success');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil dibatalkan','success');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/detail/'.$id.'?ref=keluar');
        }
    }

    public function abort_transaction($id_transfer = NULL)
    {
        # JIKA KOSONG
        if (empty($id_transfer)) {
            $this->message('Pilih data transfer yang akan dibatalkan', 'danger');
            $this->go('transfer/index/');
        }

        # AMBIL DATA transfer
        $transfer = $this->transfer->get($id_transfer);

        # CEK KETERSEDIAAN PEMBATALAN
        $abort_status = $this->check_abort_status($transfer->id);
        if (!$abort_status['status']) {
            $this->message($abort_status['reason'], 'danger');
            $this->go('transfer/index/keluar?id_organisasi='.$transfer->id_organisasi);
        }

        # ABOOORT - KEMBALIKAN RINCIAN
        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            $model_kib = "kib{$item}";
            $model_kib_temp = "kib{$item}_temp";
            
            $temp = $this->{$model_kib_temp}->as_array()->get_many_by(array('id_transfer'=>$id_transfer));

            if (!empty($temp)) {
                $where_in = array_column($temp, 'id_aset');
                $this->{$model_kib}->batch_update($where_in, array('id_organisasi'=>$transfer->id_organisasi));
            }
        }

        $this->transfer->update($id_transfer, array('status_pengajuan'=>0));

        $this->message('transfer berhasil dibatalkan','success');
        $this->go('transfer/index/keluar?id_organisasi='.$transfer->id_organisasi);
    }

    private function check_abort_status($id_transfer = NULL)
    {
        if (empty($id_transfer)) {
            return array('status'=>FALSE, 'reason'=>'id transfer kosong');
        }

        $transfer = $this->transfer->get($id_transfer);

        if (empty($transfer)) {
            return array('status'=>FALSE, 'reason'=>'id transfer tidak valid');
        }

        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            # SET MODEL
            $model_kib  = "kib{$item}";
            $model_kib_temp  = "kib{$item}_temp";

            # AMBIL DATA PADA KIB TEMP
            $data_temp = $this->{$model_kib_temp}->as_array()->order_by('id_aset')->get_many_by(array('id_transfer'=>$id_transfer));
            
            if (!empty($data_temp)) {

                $where_in = array_column($data_temp, 'id_aset');
                
                # CHECK HAPUS/KOREKSI
                $temp = $this->{$model_kib_temp}->where_in('id_aset', $where_in)->get_many_by(array('id_transfer'=>NULL, 'log_time>'=>$transfer->log_time));
                if (count($temp) > 0) {
                    return array('status'=>FALSE, 'reason'=>'Rincian transfer terikat dengan transaksi hapus/koreksi.');
                }

                # CEK TRANSFER
                $temp = $this->{$model_kib_temp}->where_in('id_aset', $where_in)->get_many_by(array('id_organisasi'=>$transfer->id_tujuan));                
                if (count($temp) > 0) {
                    return array('status'=>FALSE, 'reason'=>'Beberapa atau semua rincian pada transfer ini telah ditransfer ke UPB lainnya');
                }
            }
        }

        return array('status'=>TRUE);
    }

    public function get_abort_status($id_transfer = NULL) {
        if (empty($id_transfer)) {
            echo json_encode(array('status'=>FALSE, 'reason'=>'ID transfer KOSONG'));
        } else {
            echo json_encode($this->check_abort_status($id_transfer));
        }
    }
}