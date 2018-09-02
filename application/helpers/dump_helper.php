<?php
/**
 * CodeIgniter Dump Helpers
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Youssef JLIDAT (jlidat@gmail.com)
 * @version 1.0
 */
 
if ( ! function_exists('dump'))
{
    function dump($array=array())
    {
        echo '<pre>'; print_r($array); echo '</pre>';
        die();
    }
}

/* End of file dump_helper.php */
/* Location: ./application/helpers/dump_helper.php */
