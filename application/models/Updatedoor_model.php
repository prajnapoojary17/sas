<?php
# -----------------------------------------------------------------------------------------
# Created by: Glowtouch
# File description: SWM CESS Model
# -----------------------------------------------------------------------------------------
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updatedoor_model extends CI_model{    
public function __construct() {
    parent::__construct();
}
public function getdoornum()
{
    $sql = "SELECT * from prop_detail where door_no like '%dec%'";
    $query = $this->db->query($sql);
    return $query->result_array();
}

public function updatedoornum($data)
{
    $this->db->update_batch('prop_detail', $data,'sl_no'); 
}

public function getyears()
{
    $sql = "SELECT sl_no,p_year FROM prop_detail WHERE p_year like '____-____'";
    $query = $this->db->query($sql);
    return $query->result_array();
}

public function updateyear($data)
{
    $this->db->update_batch('prop_detail', $data,'sl_no'); 
}

}
	?>
