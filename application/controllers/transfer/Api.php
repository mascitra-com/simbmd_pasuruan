<?php
class Api extends MY_Controller
{
    public $kolom;
    public $transfer;
    public $kib;
    public $is_kdp = FALSE;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Transfer_model', 'transfer');
    }

    public function get_kiba($id_transfer = NULL)
    {
        $this->load->model('aset/Temp_kiba_model', 'kiba');

        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib   = "kiba";
        $this->kolom = array('id', 'id_transfer', 'luas','alamat','sertifikat_tgl','sertifikat_no','hak','pengguna',
            'tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul','id_kategori','id_organisasi');
        
        $data['total'] = $this->{$this->kib}->group_start()->or_like($this->get_like_array($filter['search']))->group_end()->count_by(array('id_transfer'=>$id_transfer));
        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }

    public function get_kibb($id_transfer = NULL)
    {
        $this->load->model('aset/Temp_kibb_model', 'kibb');
        
        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib   = "kibb";
        $this->kolom = array('id', 'id_transfer', 'merk','tipe','ukuran','bahan','no_pabrik','no_rangka',
            'no_mesin','no_polisi','no_bpkb','tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul',
            'id_ruangan','id_kategori','id_organisasi');
        
        $data['total'] = $this->{$this->kib}->group_start()->or_like($this->get_like_array($filter['search']))->group_end()->count_by(array('id_transfer'=>$id_transfer));
        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }

    public function get_kibc($id_transfer = NULL, $is_kdp = FALSE)
    {
        $this->load->model('aset/Temp_kibc_model', 'kibc');
        
        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib      = "kibc";
        $this->is_kdp   = $is_kdp;
        $this->kolom    = array('id', 'id_transfer', 'tingkat','beton','luas_lantai','lokasi','dokumen_tgl','dokumen_no',
            'status_tanah','kode_tanah','tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul','id_kategori','id_organisasi');
        
        $this->{$this->kib}
        ->group_start()
        ->or_like($this->get_like_array($filter['search']))
        ->group_end()
        ->join('kategori', 'kategori.id = id_kategori');

        // jika KDP
        if ($this->is_kdp) {
            $this->{$this->kib}->where('kd_golongan', 6);
        }else{
            $this->{$this->kib}->where('kd_golongan<>', 6);
        }

        $data['total'] = $this->{$this->kib}->count_by(array('id_transfer'=>$this->transfer->id));

        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }

    public function get_kibd($id_transfer = NULL, $is_kdp = FALSE)
    {
        $this->load->model('aset/Temp_kibd_model', 'kibd');
        
        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib    = "kibd";
        $this->is_kdp = $is_kdp;
        $this->kolom  = array('id', 'id_transfer', 'kontruksi','panjang','lebar','luas','lokasi','dokumen_tgl','dokumen_no',
            'status_tanah','kode_tanah','tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul','id_kategori','id_organisasi');
        
        $this->{$this->kib}
        ->group_start()
        ->or_like($this->get_like_array($filter['search']))
        ->group_end()
        ->join('kategori', 'kategori.id = id_kategori');

        // jika KDP
        if ($this->is_kdp) {
            $this->{$this->kib}->where('kd_golongan', 6);
        }else{
            $this->{$this->kib}->where('kd_golongan<>', 6);
        }

        $data['total'] = $this->{$this->kib}->count_by(array('id_transfer'=>$this->transfer->id));

        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }

    public function get_kibe($id_transfer = NULL)
    {
        $this->load->model('aset/Temp_kibe_model', 'kibe');
        
        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib   = "kibe";
        $this->kolom = array('id', 'id_transfer', 'judul','pencipta','bahan','ukuran',
            'tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul','id_kategori','id_organisasi');
        
        $data['total'] = $this->{$this->kib}->group_start()->or_like($this->get_like_array($filter['search']))->group_end()->count_by(array('id_transfer'=>$id_transfer));
        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }

    public function get_kibg($id_transfer = NULL)
    {
        $this->load->model('aset/Temp_kibg_model', 'kibg');
        
        # SET INIT
        $filter = $this->input->get();
        $this->transfer = $this->transfer->get($id_transfer);
        $this->kib   = "kibg";
        $this->kolom = array('id', 'id_transfer', 'merk','tipe','ukuran',
            'tgl_perolehan','tgl_pembukuan', 'kondisi','nilai','asal_usul','id_kategori','id_organisasi');
        
        $data['total'] = $this->{$this->kib}->group_start()->or_like($this->get_like_array($filter['search']))->group_end()->count_by(array('id_transfer'=>$id_transfer));
        $data['rows']  = $this->set_data($filter);
        echo json_encode($data);
    }



    # =================================================================
    # PRIVATE FUNCTION
    # PROSES DATA

    private function set_data($filter)
    {
        # Ambil data
        $this->{$this->kib}
        ->select($this->{$this->kib}->_table.'.*')
        ->group_start()
        ->or_like($this->get_like_array($filter['search']))
        ->group_end()
        ->limit($filter['limit'], $filter['offset'])
        ->join('kategori', 'kategori.id = id_kategori');

        // jika KDP
        if ($this->is_kdp) {
            $this->{$this->kib}->where('kd_golongan', 6);
        }else{
            $this->{$this->kib}->where('kd_golongan<>', 6);
        }

        $data = $this->{$this->kib}->get_many_by(array('id_transfer'=>$this->transfer->id));
        
        $data = $this->{$this->kib}->subtitute($data);
        $data = $this->{$this->kib}->fill_empty_data($data);
        
        $final = array();
        
        # Formatting
        foreach ($data as $index=>$value) {
            $temp = array();
            
            # Tombol
            $temp['aksi'] = '-';
            if ($this->transfer->status_pengajuan === '0' || $this->transfer->status_pengajuan === '3') {
                $link = site_url("transfer/{$this->kib}/delete/{$value->id}");
                $temp['aksi'] = "<a href='{$link}' class='btn btn-sm btn-danger' onclick=\"return confirm('Apakah anda yakin?')\"><i class='fa fa-trash'></i></a>";
            }

            # Kode barang
            $temp['kode_barang'] = zerofy($value->id_kategori->kd_golongan).'.'.zerofy($value->id_kategori->kd_bidang).'.'.
            zerofy($value->id_kategori->kd_kelompok).'.'.zerofy($value->id_kategori->kd_subkelompok).'.'.
            zerofy($value->id_kategori->kd_subsubkelompok).'.'.zerofy($value->reg_barang);

            $temp['no'] = $filter['offset'] + $index + 1;

            foreach ($this->kolom as $item) {
                switch ($item) {
                    case 'kondisi':
                    $temp[$item] = $value->kondisi==='1' ? 'Baik':($value->kondisi==='2'?'Kurang Baik':'Rusak Berat');
                    break;

                    case 'sertifikat_tgl':
                    case 'dokumen_tgl':
                    case 'tgl_perolehan':
                    case 'tgl_perolehan':
                    case 'tgl_pembukuan':
                    $temp[$item] = datify($value->{$item}, 'd-m-Y');
                    break;

                    case 'nilai':
                    $temp[$item] = monefy($value->{$item});
                    break;

                    case 'tingkat':
                    case 'beton':
                    $temp[$item] = $value->{$item}==='1'?'Ya':'Tidak';
                    break;

                    case 'id_organisasi':
                    case 'id_kategori':
                    case 'id_ruangan':
                    $temp[$item] = is_object($value->{$item})?$value->{$item}->nama:'';
                    break;

                    default:
                    $temp[$item] = $value->{$item};
                    break;
                }
            }
            $final[] = $temp;
        }
        return $final;
    }

    private function get_like_array($key)
    {
        $result = array();
        foreach ($this->kolom as $item) {
            if ($item !== 'id' && $item !== 'id_organisasi' && $item !== 'id_kategori') {
                $result[$item] = $key;
            }
        }
        return $result;
    }
}