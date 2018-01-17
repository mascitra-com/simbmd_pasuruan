<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/16/2018
 * Time: 2:24 PM
 */

class Notifikasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notifikasi_model', 'notifikasi');
    }

    public function index()
    {
        $this->render('modules/notifikasi/index');
    }
}