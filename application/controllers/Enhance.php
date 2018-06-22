<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Enhance Controller
 *
 * Description : This is used to handle enhance data 
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
class Enhance extends CI_Controller
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
        $this->load->model('enhance_model', '', TRUE);
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
            $data['displayenhance'] = $this->enhance_model->display_enhance();
            $this->load->view('enhance_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    add_enhance
      # Purpose      :    Insert enhance
      # params       :    None
      # Return       :    None
     */
    public function add_enhance()
    {
        $data = array('e_year' => $this->input->post('e_year'), 'e_rate' => $this->input->post('e_rate'));
        $displayenhance = $this->enhance_model->display_enhance();
        $result = array();
        foreach ($displayenhance as $key => $value) {
            $result[] = $value->e_year;
            if (($this->input->post('e_year')) == ($value->e_year)) {
                $match = 1;
                break;
            } else {
                $match = 0;
            }
        }
        if ($match == 0) {
            $this->enhance_model->add_enhance($data);
            $e_year = $this->input->post('e_year');
            $str = "Added Enhance % for year " . $e_year;
            newUserlog($str);
        }
        if ($match == 1) {
            $this->session->set_flashdata('message', 'Year Already exists');
        }
        redirect('enhance', 'refresh');
    }

}
