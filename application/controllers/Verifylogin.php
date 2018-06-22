<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : VerifyLogin Controller
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
class VerifyLogin extends CI_Controller
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
        $this->load->model('user', '', TRUE);
        $this->load->helper('string');
    }

    /**
      # Function 	:	index
      # Purpose  	:	Initial settings
      # params 	:	None
      # Return 	:	None
     */
    function index()
    {
        //This method will have the credentials validation
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
            $this->load->view('login_view');
        } else {
            //Go to private area
            $data = array();
            $data = $_SESSION['logged_in'];
            $result_get_role = $this->user->get_status($data['username']);
            $this->session->set_userdata('role', $result_get_role->role);
			$this->session->set_userdata('is_super_admin', $result_get_role->is_super_admin);			
           
			 $this->user->saveUserlog($data);
            redirect('home');
        }
    }

    /**
      # Function 	:	check_database
      # Purpose  	:	check_database for login user
      # params 	:	None
      # Return 	:	None
     */
    function check_database($password)
    {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        //query the database
        $result = $this->user->login($username, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $uniqueId = random_string('alnum', 16);
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'status' => $row->status,
                    'my_session_id' => $uniqueId
                );
                if ($sess_array['status'] == 'Inactive') {
                    $this->form_validation->set_message('check_database', 'Inactive User, Please contact the admin');
                    return false;
                } else {
                    //set session values
                    $this->session->set_userdata('logged_in', $sess_array);
                }
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

}
