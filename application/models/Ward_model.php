<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : ward_model Model
 *
 * Description : This is used to handle Ward data 
 *
 * Created By : Gauthami
 *
 * Created Date : 01/03/2017
 *
 * Last Modified By : Gauthami
 *
 * Last Modified Date : 13/04/2017
 *
 */
class Ward_model extends CI_model
{

    /**
      # Function 	:	__construct
      # Purpose  	:	Class constructor
      # params 	:	None
      # Return 	:	None
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
      # Function :	display_ward
      # Purpose  :	display ward
      # Return   :	Array
     */
    public function display_ward()
    {
        $this->db->from('ward');
        $this->db->order_by("ward_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    /**
      # Function :	add_ward
      # Purpose  :	Insert ward
      # Return   :	Array
     */
    public function add_ward($data)
    {
        $this->db->insert('ward', $data);
    }

}
