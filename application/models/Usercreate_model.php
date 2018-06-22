<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Usercreate_model Model
 *
 * Description : This is used to handle User data 
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
class Usercreate_model extends CI_model
{

    /**
      # Function 	:	__construct
      # Purpose  	:	Class constructor
      # params 	:	None
      # Return 	:	None
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
      # Function 	:	add_user
      # Purpose  	:	to add users
      # params 	:	$ifo array
      # Return 	:	none
     */
    public function add_user($info)
    {
        $this->db->insert('users', $info);
    }

}
