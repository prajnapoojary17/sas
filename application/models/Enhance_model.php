<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Enhance Model
 *
 * Description : This is used to handle Enhance data 
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
class Enhance_model extends CI_model
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
      # Function :	display_enhance
      # Purpose  :	display enhance
      # Return   :	Array
     */
    public function display_enhance()
    {
        $query = $this->db->get('enhance');
        return $query->result();
    }

    /**
      # Function :	add_enhance
      # Purpose  :	Insert enhance
      # Return   :	Array
     */
    public function add_enhance($data)
    {
        $this->db->insert('enhance', $data);
    }

}
