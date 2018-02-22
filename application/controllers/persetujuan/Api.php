<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Persetujuan_model', 'persetujuan');
    }

    public function get_persetujuan_pengadaan($id)
    {
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_spk', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_hibah($id)
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_hibah', $id);

		if (!empty($data))
		{
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_hapus($id)
	{
        $data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_hapus', $id);

        if (!empty($data)) {
            $data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
            $data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
        }

        echo json_encode($data);
    }

    public function get_persetujuan_transfer($id) 
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_transfer', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_koreksi_hapus($id) 
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_koreksi', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_koreksi_kepemilikan($id) 
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_koreksi', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_koreksi_kode($id) 
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_koreksi', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}

	public function get_persetujuan_koreksi_nilai($id) 
	{
		$data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_koreksi', $id);

		if (!empty($data)) {
			$data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
			$data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
		}

		echo json_encode($data);
	}
}