<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Cess Controller
 *
 * Description : This is used to handle cess data 
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
class Cess extends CI_Controller
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
        $this->load->model('cess_model', '', TRUE);
    }

    /**
      # Function     :    index
      # Purpose      :    Initial settings
      # params       :    None
      # Return       :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['getcess'] = $this->cess_model->display_cess($data);
            $this->load->view('cess_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    add_cess
      # Purpose      :    Insert cess
      # params       :    None
      # Return       :    None
     */
    public function add_cess()
    {
        $data = array('cess_id' => $this->input->post('cess_id'),
            'cess_amt' => $this->input->post('cess_amt'));
        $display_cess = $this->cess_model->display_cess($data);
        $result = array();
        foreach ($display_cess as $key => $value) {
            $result[] = $value->cess_amt;
            if (($this->input->post('cess_id')) == ($value->cess_id)) {
                $match = 1;
                break;
            } else {
                $match = 0;
            }
        }
        if ($match == 0) {
            $this->cess_model->add_cess($data);
            $cessyear = $this->input->post('cess_id');
            $str = "Added CESS % for " . $cessyear;
            newUserlog($str);
        }
        if ($match == 1) {
            $this->session->set_flashdata('message', 'Year Already  Exists');
        }
        redirect('cess', 'refresh');
    }

}