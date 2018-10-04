<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Inventarisasi_model extends MY_Model
{
	public $_table = 'inventarisasi';

	public function __construct()
	{
		parent::__construct();
	}

	public function api_get_data($id_organisasi, $filter = array())
	{
		$q = $filter['search'];

		$this->group_start();
		$this->or_like(array('no_ba'=>$q, 'tgl_ba'=>$q, 'keterangan'=>$q));
		$this->group_end();

		$clone = clone $this;

		$this->limit($filter['limit'], $filter['offset']);

		$data['rows']  = $this->as_array()->get_many_by('id_organisasi', $id_organisasi);
		$data['rows']  = $this->subtitute($data['rows']);
		$data['total'] = $clone->count_by('id_organisasi', $id_organisasi);

		foreach ($data['rows'] as $index => $value) 
		{
			$value['tgl_ba'] = datify($value['tgl_ba']);
			$value['aksi']  = "<div class='btn-group'><a class='btn btn-primary btn-sm' href='".site_url('inventarisasi/index/rincian/'.$value['id'])."'><i class='fa fa-eye mr-2'></i>rincian</a>";
			$value['aksi'] .= "<button class='btn btn-danger btn-sm' data-id='".$value['id']."' ".($value['status_pengajuan']!=='0' && $value['status_pengajuan']!=='3' ?'disabled':'')."><i class='fa fa-trash'></i></button></div>";

			switch ($value['status_pengajuan']) {
				case 0:
				$value['status_pengajuan'] = "<button class='btn btn-secondary btn-sm'>draf</button>";
				break;
				case 1:
				$value['status_pengajuan'] = "<button class='btn btn-warning btn-sm'>menunggu</button>";
				break;
				case 2:
				$value['status_pengajuan']  = "<div class='btn-group'>";
				$value['status_pengajuan'] .= "<button class='btn btn-success btn-sm' data-id-inventarisasi='".$value['id']."'><i class='fa fa-comment-o mr-2'></i>disetujui</button>";
				$value['status_pengajuan'] .= "<button class='btn btn-warning' data-id-batal='".$value['id']."'><i class='fa fa-times'></i></button>";
				$value['status_pengajuan'] .= "</div>";
				break;
				case 3:
				$value['status_pengajuan'] = "<button class='btn btn-danger btn-sm' data-id-inventarisasi='".$value['id']."'><i class='fa fa-comment-o mr-2'></i>ditolak</button>";
				break;
			}

			# Dokumen
			if (!empty($value['dokumen'])) {
				$value['dokumen'] = "<a href='".site_url('res/docs/temp/'.$value['dokumen'])."' class='btn btn-success btn-sm'><i class='fa fa-file-o mr-2'></i>unduh</a>";
			}

			$data['rows'][$index] = $value;
		}

		return $data;
	}

	public function api_get_data_persetujuan($filter = array())
	{
		$q = $filter['search'];

		$this->group_start();
		$this->or_like(array('no_ba'=>$q, 'tgl_ba'=>$q, 'keterangan'=>$q));
		$this->group_end();

		$clone = clone $this;

		$this->limit($filter['limit'], $filter['offset']);

		$data['rows']  = $this->as_array()->get_many_by('status_pengajuan', 1);
		$data['rows']  = $this->subtitute($data['rows']);
		$data['total'] = $clone->count_by('status_pengajuan', 1);

		foreach ($data['rows'] as $index => $value) 
		{
			$value['tgl_ba'] = datify($value['tgl_ba']);
			
			$value['aksi'] = "<div class='btn-group'>";
			$value['aksi'] .= "<a href='".site_url('inventarisasi/index/rincian/'.$value['id'].'?ref=true')."' class='btn btn-primary btn-sm'><i class='fa fa-eye mr-2'></i>rincian</a>";
			$value['aksi'] .= "<button class='btn btn-sm btn-success btn-setuju' data-id='".$value['id']."'><i class='fa fa-check mr-2'></i>Setuju</button>";
			$value['aksi'] .= "<button class='btn btn-sm btn-danger btn-tolak' data-id='".$value['id']."'><i class='fa fa-times mr-2'></i>Tolak</button>";
			$value['aksi'] .= "</div>";

			if (!empty($value['dokumen'])) {
				$value['dokumen'] = "<a href='".site_url('res/docs/temp/'.$value['dokumen'])."' class='btn btn-success btn-sm'><i class='fa fa-file-o mr-2'></i>unduh</a>";
			}

			$data['rows'][$index] = $value;
		}

		return $data;
	}
}