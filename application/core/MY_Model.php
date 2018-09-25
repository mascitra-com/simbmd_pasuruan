<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends MY_Base_model {

    public $before_create = array( 'log_create' );
    public $before_update = array( 'log_update' );
    public $empty_substitution = "-";
    public $required = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function select($field) {
        $this->_database->select($field);
        return $this;
    }

    public function join($with, $on) {
        $this->_database->join($with, $on);
        return $this;
    }

    public function group_start()
    {
        $this->_database->group_start();
        return $this;
    }

    public function group_end()
    {
        $this->_database->group_end();
        return $this;
    }

    public function like($field, $match = NULL, $side = 'both', $escape = NULL) {
        $this->_database->like($field, $match, $side, $escape);
        return $this;
    }

    public function or_like($field, $match = NULL, $side = 'both', $escape = NULL) {
        $this->_database->or_like($field, $match, $side, $escape);
        return $this;
    }

    public function where($field, $match = NULL) {
        $this->_database->where($field, $match);
        return $this;
    }

    public function or_where($field, $match = NULL) {
        $this->_database->or_where($field, $match);
        return $this;
    }

    public function where_in($field, $match = NULL) {
        $this->_database->where_in($field, $match);
        return $this;
    }
    public function where_not_in($field, $match = NULL) {
        $this->_database->where_not_in($field, $match);
        return $this;
    }

    public function batch_insert($data)
    {
        return $this->db->insert_batch($this->_table, $data);
    }

    public function batch_update($id, $data)
    {
        $this->db->where_in('id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function batch_delete($id)
    {
        $this->db->where_in('id', $id);
        return $this->db->delete($this->_table);
    }

    protected function log_create($data)
    {
        $data['log_time']   = date('Y-m-d H:i:s');
        $data['log_action'] = 'INSERT';
        $data['log_user'] = isset($this->session->auth['id']) ? $this->session->auth['id'] : '';
        return $data;
    }

    protected function log_update($data)
    {
        $data['log_time']   = date('Y-m-d H:i:s');
        $data['log_action'] = 'UPDATE';
        $data['log_user'] = isset($this->session->auth['id']) ? $this->session->auth['id'] : '';
        return $data;
    }

    public function form_verify($data)
    {
        $data = (array)$data;
        foreach ($this->required as $key) {
            if (array_key_exists($key, $data)) {
                if ($data[$key] !== "0" AND empty($data[$key])){
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function fill_empty_data($data = array())
    {
        if (empty($data)) {
            return $data;
        }

        foreach ($data as $key => $value)
        {
            foreach ($value as $index => $item)
            {
                if (empty($item) && $item !== '0')
                {
                    $data[$key]->{$index} = $this->empty_substitution;
                }
            }
        }
        return $data;
    }

    public function subtitute($data)
    {
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');

        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                $value = $this->do_substitute($value);
            }
        }
        else
        {
            $data = $this->do_substitute($data);
        }

        return $data;
    }

    private function do_substitute($data)
    {
        if (isset($data->id_kategori)) {
            $data->id_kategori = $this->kategori->get($data->id_kategori);
        }

        if (isset($data->id_organisasi)) {
            $data->id_organisasi = $this->organisasi->get($data->id_organisasi);
        }

        if (isset($data->id_tujuan)) {
            $data->id_tujuan = $this->organisasi->get($data->id_tujuan);
        }

        if (isset($data->id_ruangan)) {
            $data->id_ruangan = $this->ruangan->get($data->id_ruangan);
        }

        return $data;
    }

    public function get_regBarang($id_kategori)
    {
        # SET INDIVIDUAL QUERY
        $qa    = "SELECT MAX(reg_barang) AS reg FROM aset_a WHERE id_kategori = {$id_kategori}";
        $qb    = "SELECT MAX(reg_barang) AS reg FROM aset_b WHERE id_kategori = {$id_kategori}";
        $qc    = "SELECT MAX(reg_barang) AS reg FROM aset_c WHERE id_kategori = {$id_kategori}";
        $qd    = "SELECT MAX(reg_barang) AS reg FROM aset_d WHERE id_kategori = {$id_kategori}";
        $qe    = "SELECT MAX(reg_barang) AS reg FROM aset_e WHERE id_kategori = {$id_kategori}";
        # SET QUERY KESELURUAHN
        $query = "SELECT MAX(reg) as reg FROM ({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe}) AS q";

        $result = $this->db->query($query);

        if ($result->num_rows() > 1) {
            return $result->result()[0]->reg + 1;
        } else {
            return ((empty($result->result()[0]->reg)) ? 1 : $result->result()[0]->reg + 1);
        }
    }

    // public function get_regInduk()
    // {
    //     while (true) {
    //         $reg = strtoupper(uniqid().'.'.date('dmYhis'));

    //         $qa = "SELECT id FROM aset_a WHERE reg_induk = '{$reg}'";
    //         $qb = "SELECT id FROM aset_b WHERE reg_induk = '{$reg}'";
    //         $qc = "SELECT id FROM aset_c WHERE reg_induk = '{$reg}'";
    //         $qd = "SELECT id FROM aset_d WHERE reg_induk = '{$reg}'";
    //         $qe = "SELECT id FROM aset_e WHERE reg_induk = '{$reg}'";
    //         $qk = "SELECT id FROM aset_kapitalisasi WHERE reg_induk = '{$reg}'";
    //         $query  = "SELECT * FROM ({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe} UNION {$qk}) AS q";
    //         $result = $this->db->query($query);

    //         if ($result->num_rows() < 1) {
    //             break;
    //         }
    //     }

    //     return $reg;
    // }
}