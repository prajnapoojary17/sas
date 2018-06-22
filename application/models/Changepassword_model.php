<?php

/**
 * File Name : change password Model
 *
 * Description : This is used to handle depreciation data 
 *
 * Created By : Gauthami
 *
 * Created Date : 12/04/2017
 *
 * Last Modified By : Gauthami
 *
 * Last Modified Date : 14/04/2017
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Changepassword_model extends CI_model
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
    public function verifycurrentpassword($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));


        foreach ($query->result() as $password) {
            return $password->password;
        }
    }

    public function updatepassword($data, $username)
    {

        $this->db->where('username', $username);
        $this->db->update('users', $data);
    }

}
