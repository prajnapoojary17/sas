<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Changepassword Controller
 *
 * Description : This is used to handle password change
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
class Changepassword extends CI_Controller
{

    /**
      # Function    :    __construct
      # Purpose     :    Class constructor
      # params      :    None
      # Return      :    None
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('changepassword_model', '', TRUE);
        $this->load->library('pagination');
        $this->load->helper('user');
    }

    /**
      # Function     :    index
      # Purpose      :    Initial settings
      # params       :    None
      # Return       :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_POST['txtPassword'])) {
                $txtPassword = (md5($this->input->post('txtPassword')));
                $data1 = array('password' => $txtPassword);
                $txtPassword . $userifo['username'];
                $this->changepassword_model->updatepassword($data1, $userifo['username']);
                $str = $userifo['username']." Changed Password";
                newUserlog($str);
            } else {

                $this->load->view('changepassword_view', $data);
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function verifycurrentpassword()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $verifycurrentpassword = $this->changepassword_model->verifycurrentpassword($userifo['username']);
            $val = (md5($this->input->post('val')));
            if (($val) == ($verifycurrentpassword)) {
                echo 'match';
            } else {
                echo 'notmatch';
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}
