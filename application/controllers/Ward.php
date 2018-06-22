<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Ward Controller
 *
 * Description : This is used to handle ward data 
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
class Ward extends CI_Controller
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
        $this->load->model('ward_model', '', TRUE);
    }

    /**
      # Function    :    index
      # Purpose     :    Initial settings
      # params      :    None
      # Return      :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['ward'] = $this->ward_model->display_ward();
            $this->load->view('ward_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    add_ward
      # Purpose      :    Insert ward
      # params       :    None
      # Return       :    None
     */
    public function add_ward()
    {
        $data = array(
            'ward_name' => $this->input->post('ward_name')
        );
        $ward = $this->ward_model->display_ward();
        $result = array();
        foreach ($ward as $key => $value) {
            $result1[] = $value->ward_name;
            if (($this->input->post('ward_name')) == ($value->ward_name)) {
                $match = 1;
                break;
            } else {
                $match = 0;
            }
        }

        if ($match == 0) {
            $this->ward_model->add_ward($data);
            $wardname = $this->input->post('ward_name');
            $str = "Added Ward " . $wardname;
            newUserlog($str);
        }
        if ($match == 1) {
            $this->session->set_flashdata('message', 'Ward Name Already exists');
        }
        redirect('ward', 'refresh');
    }

}
