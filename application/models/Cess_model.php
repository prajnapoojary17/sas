<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Cess Model
 *
 * Description : This is used to handle cess data 
 *
 * Created By : Reshma
 *
 * Created Date : 23/09/2014
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 13/04/2017
 *
 */
class Cess_model extends CI_model
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
    public function display_cess()
    {
        $query = $this->db->get('cess');
        return $query->result();
    }

    /**
      # Function :	add_cess
      # Purpose  :	Insert cess
      # Return   :	Array
     */
    public function add_cess($data)
    {
        $this->db->insert('cess', $data);
    }

}
