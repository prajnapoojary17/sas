<?php

# -----------------------------------------------------------------------------------------
# Created by: Glowtouch
# File description: vehiclefine Model
# -----------------------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Constraterural_model extends CI_model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function display_constraterural()
    {
        $query = $this->db->get('cons_rate_rural');
        return $query->result();
    }

    public function add_constraterural($data)
    {
        $this->db->insert('cons_rate_rural', $data);
    }
    
    /**
      # Function :	update_rural
      # Purpose  :	update construction 
      # Return   :	Array
     */
    public function update_rural($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('cons_rate_rural', $data);
    }

}