<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibc extends MY_Controller
{
    public $_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Saldo_kibc_model', 'kib_saldo');
        $this->load->model('aset/Kibc_model', 'kib_berjalan');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['id_organisasi'] = $this->organisasi->get_id_by_auth( $this->input->get('id_organisasi') );
        $data['organisasi']    = $this->organisasi->get_data_by_auth();
        $data['is_kdp']        = !empty($this->input->get('is_kdp'))?$this->input->get('is_kdp'):0;
        $data['source']        = $this->input->get('source');

        if ($data['source']!=='saldo' && $data['source']!=='berjalan') {
            show_404();
        }

        $this->render('modules/aset/kibc/index', $data);
    }

    public function get($id_organisasi = null, $source = null)
    {
        if (empty($id_organisasi) OR empty($source)) {
            return;
        }

        $this->_model = 'kib_'.$source;

        $filter = $this->input->get();
        $filter['id_organisasi'] = $id_organisasi;

        $result = $this->{$this->_model}->get_data_aset($this->finalize_filter($filter));
        echo json_encode($this->finalize_result($result));
    }

    public function get_rincian_widget($id_organisasi = null, $is_kdp = 0, $source = null)
    {
        if (empty($id_organisasi) OR empty($source)) {
            return;
        }

        $this->_model = 'kib_'.$source;
        
        $result = $this->{$this->_model}->get_rincian_widget($id_organisasi, $is_kdp);
        $result->total = monefy($result->total, FALSE);
        $result->nilai = monefy($result->nilai);
        $result->total_rusak = monefy($result->total_rusak, FALSE);
        $result->nilai_rusak = monefy($result->nilai_rusak);
        echo json_encode($result);
    }

    private function finalize_filter($filter = array())
    {
        if (!empty($filter['search'])) {
            foreach ($this->{$this->_model}->_kolom as $kolom) {
                $filter[$kolom] = $filter['search'];
            }
        }
        
        return $filter;
    }

    private function finalize_result($data = array())
    {
        foreach ($data['rows'] as $key => $value) {
            $value = (array)$value;

            foreach ($value as $index => $item) {
                switch ($index) {
                    case 'beton':
                    case 'tingkat':
                    $value[$index] = $item==='1'?'iya':'tidak';
                    break;
                    case 'dokumen_tgl':
                    case 'tgl_pembukuan':
                    case 'tgl_perolehan':
                    $value[$index] = datify($item);
                    break;
                    case 'nilai':
                    $value[$index] = monefy($item);
                    break;
                    case 'kondisi':
                    $kondisi = array('kosong','Sangat Baik', 'Baik', 'Rusak Berat');
                    $value[$index] = $kondisi[$item];
                    break;
                }
            }
            
            # KODE BARANG
            $value['kode_barang'] = zerofy($value['id_kategori']->kd_golongan, 2);
            $value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_bidang, 2);
            $value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_kelompok, 2);
            $value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_subkelompok, 2);
            $value['kode_barang'] .= '.'.zerofy($value['id_kategori']->kd_subsubkelompok, 2);
            # NAMA BARANG
            $value['id_kategori'] = $value['id_kategori']->nama;

            $data['rows'][$key] = (object)$value;
        }
        return $data;
    }
}