<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Usermanage Controller
 *
 * Description : This is used to handle User data 
 *
 * Created By : Gauthami
 *
 * Created Date : 01/02/2017
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 13/04/2017
 *
 */
class Usermanage extends CI_Controller
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
        $this->load->model('usermanage_model', 'usermanage');
        $this->load->helper('form');
		$this->load->helper('user');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">', '</div>');
    }

    /**
      # Function 	:	index
      # Purpose  	:	Initial settings
      # params 	:	None
      # Return 	:	None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['is_super_admin'] = $is_super_admin = $this->usermanage->check_super_admin($userifo['username']);

            if ($is_super_admin == 1) {
                $records_array = $this->usermanage->get_main_result();
            } else {
                $records_array = $this->usermanage->get_main_result_admin($userifo['username']);
            }
            $data['records'] = $records_array;
            $this->load->view('members_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function 	:	create
      # Purpose  	:	create user
      # params 	:	None
      # Return 	:	None
     */
    public function create()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['success'] = '';
            $this->load->model('usercreate_model', 'usercreate');
            $info = array();
            $status = $this->input->post('status');
            $info['username'] = $this->input->post('username');
            $pass = $this->input->post('password');
            $info['password'] = md5($this->input->post('password'));
            $info['role'] = $this->input->post('role');
            $info['email'] = $this->input->post('email');
            $info['contact'] = $this->input->post('contact');
            $info['created_by'] = $userifo['username'];
            $info['status'] = ($status == "true") ? 'Active' : 'Inactive';
            $this->usercreate->add_user($info);
            $str = "Added new User " . $info['username'];
            newUserlog($str);
            $email = $this->input->POST('email');
            $message = '<html>
                        <head><title>Created User</title></head>
                        <body>
                            <p><b>Your Account has been created.</b></p>                           
                             
                            <h4>Here are your credentials:</h4>
                            User Name :  ' . $info['username'] . '<br>
                            Password :  ' . $pass . '<br><br>
                            
                            Thanks<br>
                        </body>
                    </html>';
            if ($this->input->POST('email')) {
                $this->email->from('gauthami.r@glowtouch.com', 'MCC');
                $this->email->to($email);
                $this->email->subject('Account Created');
                $this->email->message($message);
                $this->email->send();
            }
            $data['success'] = 'Added Successfully';
            echo 'sucess';            
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function 	:	edit_user
      # Purpose  	:	edit_user
      # params 	:	None
      # Return 	:	None
     */
    public function edit_user()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $id = $this->input->POST('id');
            $username = $this->input->POST('username');
            //query the database            
            $data = array(
                'username' => $this->input->POST('username'),
                'role' => $this->input->POST('role'),
                'email' => $this->input->POST('email'),
                'contact' => $this->input->POST('contact'),
                'status' => $this->input->POST('status'),
                'created_by' => $userifo['username']);
            $this->usermanage->update_role($data, $id);
            $usename = $this->input->POST('username');
            $str = "Updated User " . $usename;
            newUserlog($str);
            $email = $this->input->POST('email');
            if ($this->input->POST('email')) {
                $this->email->from('gauthami.r@glowtouch.com', 'MCC');
                $this->email->to($email);
                $this->email->subject('Account details updated');
                $this->email->message('Your Account details are updated.');
                $this->email->send();
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function 	:	delete_user
      # Purpose  	:	delete_user
      # params 	:	None
      # Return 	:	None
     */
    public function delete_user()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $username = $userifo['username'];
            $id = $this->input->POST('id');
            $checklogs = $this->db->get_where('user_logtime', array('user_id =' => $id))->num_rows();
            if ($checklogs == 0) {
                $deletedusername = $this->usermanage->getUsername($id);
                $this->db->where('id', $id);
                $this->db->delete('users');
                $str = "Deleted User " . $deletedusername;
                newUserlog($str);
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function 	:	check_database
      # Purpose  	:	check_database for existing user
      # params 	:	None
      # Return 	:	None
     */
    function check_database($password)
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            //Field validation succeeded.  Validate against database
            $username = $this->input->post('username');
            //query the database
            $result = $this->usermanage->check_user($username);
            if ($result) {
                $this->form_validation->set_message('check_database', 'User Already Exist');
                return false;
            } else {
                return TRUE;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function userlogs()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');           
            $userlogs = $this->usermanage->getLogs($userifo['username']);
            $data['userlogs'] = $userlogs;
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $this->load->view('userlogs', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function checkuser()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');           
            $username = $this->input->post('val');
            $result = $this->usermanage->check_user($username);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function checkemail()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');          
            $email = $this->input->post('email');
            $id = $this->input->post('id');
            $userid = substr($id, strpos($id, "_") + 1);
            $result = $this->usermanage->checkemail($email, $userid);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function check_email()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');         
            $email = $this->input->post('email');
            $result = $this->usermanage->check_email($email);
            if ($result) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}