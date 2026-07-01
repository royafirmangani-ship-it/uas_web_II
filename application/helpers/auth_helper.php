<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $CI =& get_instance();
        return $CI->session->userdata('id_user') ? true : false;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $CI =& get_instance();
        return $CI->session->userdata('role') === 'admin';
    }
}

if (!function_exists('is_petugas')) {
    function is_petugas()
    {
        $CI =& get_instance();
        return $CI->session->userdata('role') === 'petugas';
    }
}
