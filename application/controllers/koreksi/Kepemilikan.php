<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepemilikan extends MY_Controller {

    protected $jenis_koreksi = 2;

    public function __construct()
    {
        parent::__construct();

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

        $this->load->model('Koreksi_model', 'koreksi');
        $this->load->model('Koreksi_detail_model', 'koreksi_detail');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $filter['jenis_koreksi'] = $this->jenis_koreksi;
        $filter['ord_by']  		 = 'log_time';

        $result = $this->koreksi->get_data($filter);

        $data['koreksi'] 	= $result['data'];
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['filter'] 	= !empty($filter) ? $filter : array('id_organisasi' => '');
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'koreksi/' . get_class($this));

        $this->render('modules/koreksi/kepemilikan/index', $data);
    }

    public function rincian($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['koreksi'] = $this->koreksi->get($id);
        $data['rincian'] = $this->subtitute($this->koreksi->get_data_rincian($id));

        if (empty($data['koreksi'])) {
            show_404();
        }

        $this->render('modules/koreksi/kepemilikan/rincian', $data);
    }

    public function rincian_redirect()
    {
        $jenis = $this->input->post('jenis');
        $id    = $this->input->post('id');

        if(empty($id))
            show_404();

        switch ($jenis) {
            case 'a':
            $this->go('koreksi/aset/kiba/koreksi_kepemilikan/'.$id);
            break;
            case 'b':
            $this->go('koreksi/aset/kibb/koreksi_kepemilikan/'.$id);
            break;
            case 'c':
            $this->go('koreksi/aset/kibc/koreksi_kepemilikan/'.$id);
            break;
            case 'd':
            $this->go('koreksi/aset/kibd/koreksi_kepemilikan/'.$id);
            break;
            case 'e':
            $this->go('koreksi/aset/kibe/koreksi_kepemilikan/'.$id);
            break;
            case 'g':
            $this->go('koreksi/aset/kibg/koreksi_kepemilikan/'.$id);
            break;

            default:
            show_404();
            break;
        }
    }

    public function insert()
    {
        $data = $this->input->post();

        if (!$this->koreksi->form_verify($data)) {
            $this->message('Isi data yang perlu diisi.', 'warning');
            $this->go('koreksi/kepemilikan?id_organisasi='.$data['id_organisasi']);
        }

        $data['jenis_koreksi'] = $this->jenis_koreksi;
        $sukses = $this->koreksi->insert($data);

        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('koreksi/kepemilikan/rincian/'.$sukses);
        } else {
            $this->message('Data gagal disimpan','danger');
            $this->go('koreksi/kepemilikan?id_organisasi='.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);

        if(empty($id))
            show_404();

        if (!$this->koreksi->form_verify($data)) {
            $this->message('Isi data yang perlu diisi.', 'warning');
            $this->go('koreksi/kepemilikan/rincian/'.$id);
        }

        $sukses = $this->koreksi->update($id, $data);

        if($sukses) {
            $this->message('Data berhasil disunting','success');
        } else {
            $this->message('Data gagal disunting','danger');
        }

        $this->go('koreksi/kepemilikan/rincian/'.$id);
    }

    public function delete($id_koreksi = null)
    {
        if (empty($id_koreksi)) {
            show_404();
        }

        $koreksi = $this->koreksi->get($id_koreksi);

        if ($koreksi->status_pengajuan == 1 OR $koreksi->status_pengajuan == 2) {
            $this->message('data menunggu atau telah disetujui', 'warning');
            $this->go('koreksi/kepemilikan?id_organisasi='.$koreksi->id_organisasi);
            die();
        }

        $model = array('kiba_temp','kibb_temp','kibc_temp','kibd_temp','kibe_temp','kibg_temp');
        foreach ($model as $m) {
            $temp = $this->{$m}->get_many_by('id_koreksi', $id_koreksi);
            foreach ($temp as $key => $value) {
                $this->koreksi_detail->delete($value->id_koreksi_detail);
            }
            $this->{$m}->delete_by('id_koreksi', $id_koreksi);
        }

        $this->koreksi->delete($id_koreksi);
        $this->message('data berhasil dihapus', 'success');
        $this->go('koreksi/kepemilikan?id_organisasi='.$koreksi->id_organisasi);
    }

    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->koreksi->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil diajukan','success');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
        }
        $this->go('koreksi/kepemilikan/rincian/'.$id);
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->koreksi->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil dibatalkan','success');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
        }
        $this->go('koreksi/kepemilikan/rincian/'.$id);
    }

    private function subtitute($data)
    {
    	foreach ($data AS $kib) {
    		foreach ($kib as $item) {
    			$item->corrected_value = $this->organisasi->get($item->corrected_value);
    		}
    	}
    	return $data;
    }

    public function abort_transaction($id_koreksi = NULL)
    {
        # JIKA KOSONG
        if (empty($id_koreksi)) {
            $this->message('Pilih data koreksi kepemilikan yang akan dibatalkan', 'danger');
            $this->go('koreksi/kepemilikan/');
        }

        # AMBIL DATA koreksi
        $koreksi = $this->koreksi->get($id_koreksi);

        # CEK KETERSEDIAAN PEMBATALAN
        $abort_status = $this->check_abort_status($koreksi->id);
        if (!$abort_status['status']) {
            $this->message($abort_status['reason'], 'danger');
            $this->go('koreksi/kepemilikan?id_organisasi='.$koreksi->id_organisasi);
        }

        # ABOOORT - KEMBALIKAN RINCIAN
        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            # SET MODEL
            $model_kib  = "kib{$item}";
            $model_kib_temp  = "kib{$item}_temp";

            $temp = $this->{$model_kib_temp}->get_many_by('id_koreksi', $id_koreksi);

            foreach ($temp as $aset) {
                $orginal_value = $this->koreksi_detail->get($aset->id_koreksi_detail)->original_value;
                $this->{$model_kib}->update($aset->id_aset, array('id_organisasi'=>$orginal_value));
            }
        }

        $this->koreksi->update($id_koreksi, array('status_pengajuan'=>0));

        $this->message('koreksi berhasil dibatalkan','success');
        $this->go('koreksi/kepemilikan?id_organisasi='.$koreksi->id_organisasi);
    }

    private function check_abort_status($id_koreksi = NULL)
    {
        if (empty($id_koreksi)) {
            return array('status'=>FALSE, 'reason'=>'id koreksi kosong');
        }

        $koreksi = $this->koreksi->get($id_koreksi);

        if (empty($koreksi)) {
            return array('status'=>FALSE, 'reason'=>'id koreksi tidak valid');
        }

        $alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
        foreach ($alfabet as $item) {
            # SET MODEL
            $model_kib = "kib{$item}";
            $model_kib_temp = "kib{$item}_temp";

            $data_temp = $this->{$model_kib_temp}->as_array()->order_by('id_aset')->get_many_by(array('id_koreksi'=>$id_koreksi));
            
            if (!empty($data_temp)) {

                $where_in = array_column($data_temp, 'id_aset');
                
                # CHECK HAPUS/KOREKSI
                $temp = $this->{$model_kib_temp}
                ->where_in('id_aset', $where_in)
                ->group_start()
                ->where('id_koreksi !=', $id_koreksi)
                ->or_where("id_koreksi IS NULL", NULL, FALSE)
                ->group_end()
                ->get_many_by(array('log_time>'=>$koreksi->log_time));
                
                if (count($temp) > 0) {
                    return array('status'=>FALSE, 'reason'=>'Rincian koreksi terikat dengan transaksi lain.');
                }
            }
        }

        return array('status'=>TRUE);
    }

    public function get_abort_status($id_koreksi = NULL) {
        if (empty($id_koreksi)) {
            echo json_encode(array('status'=>FALSE, 'reason'=>'ID koreksi KOSONG'));
        } else {
            echo json_encode($this->check_abort_status($id_koreksi));
        }
    }
}