<?php
function is_admin() {
    $CI =& get_instance();
    return $CI->session->userdata('role') === 'admin';
}

function require_admin() {
    if (!is_admin()) {
        redirect('auth/login');
    }
}
