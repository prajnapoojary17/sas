<?php

# -----------------------------------------------------------------------------------------
# Created by: Glowtouch
# File description: SWM CESS Model
# -----------------------------------------------------------------------------------------
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Change_model extends CI_model
{

    /**
      # Function :	__construct
      # Purpose  :	Class constructor
      # params 	 :	None
      # Return   :	None
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
      # Function :	display_cess
      # Purpose  :	Display cess
      # Return   :	Array
     */
    public function index()
    {
        $query = $this->db->get('cess');
        return $query->result();
    }

}
