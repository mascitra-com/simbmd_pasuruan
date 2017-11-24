<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excel 
{
	protected $file;
	protected $startRow = 1;
	protected $result;
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		# Panggil library
		require_once APPPATH . 'libraries/PHPExcel.php';
	}

	public function init($config = array())
	{
		if (isset($config['file'])) {
			$this->file = $config['file'];
		}

		if (isset($config['startRow'])) {
			$this->startRow = $config['startRow'];
		}
	}

	public function import($config = array())
	{
		if (!empty($config)) {
			$this->init($config);
		}

		try 
		{
			# Cek tipe file
			$inputFileType = PHPExcel_IOFactory::identify($this->file);

			# Membuat objek pembaca file
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$excel 	   = $objReader->load($this->file);
		}
		catch (Exception $e) 
		{
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}

		$sheet 		= $excel->getSheet(0);
		$maxCell 	= $sheet->getHighestRowAndColumn();
		$startRow 	= $this->startRow;
		$result 	= array();

		# Jika file tidak kosong
		if ( $maxCell > 1 )
		{	
			$result = $sheet->rangeToArray('A'.$startRow.':'.$maxCell['column'].$maxCell['row']);
			return $this->eleminate_empty_rows($result);
		}
		else
		{
			return;
		}
	}

	private function eleminate_empty_rows($data)
	{
		foreach ($data as $key => $value) {
			if(!array_filter($value)) {
				unset($data[$key]);
			}
		}
		return $data;
	}
}