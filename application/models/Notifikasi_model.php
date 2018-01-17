<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/16/2018
 * Time: 6:04 PM
 */

class Notifikasi_model extends MY_Model
{
    public $_table = 'notifikasi';
    public $required = array('title', 'to', 'type');
    public function __construct()
    {
        parent::__construct();
    }
}