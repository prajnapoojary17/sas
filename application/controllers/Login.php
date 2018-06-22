<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Login Controller
 *
 * Description : This is used to handle user logins
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
class Login extends CI_Controller
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
      # Function 	:	index
      # Purpose  	:	Initial settings
      # params 	:	None
      # Return 	:	None
     */
    function index()
    {
        $this->load->helper(array('form'));
        $this->load->view('login_view');
    }

}
