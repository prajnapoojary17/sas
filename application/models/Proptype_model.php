<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Property type Model
 *
 * Description : This is used to handle Property data 
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
class Proptype_model extends CI_model
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
      # Function :	display_proptype
      # Purpose  :	display proptype
      # Return   :	Array
     */
    public function display_proptype()
    {
        $query = $this->db->get('proptype');
        return $query->result();
    }

    /**
      # Function :	add_proptype_data
      # Purpose  :	Insert proptype
      # Return   :	Array
     */
    public function add_proptype_data($data)
    {
        $this->db->insert('proptype', $data);
    }

}
