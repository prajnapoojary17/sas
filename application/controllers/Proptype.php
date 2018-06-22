<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Proptype Controller
 *
 * Description : This is used to handle Property type
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
class Proptype extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('proptype_model', '', TRUE);
    }

    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['displayproptype'] = $this->proptype_model->display_proptype();
            $this->load->view('propertytype_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function InsertUser()
    {
        $data = array('p_type' => $this->input->post('p_type'), 'p_use' => $this->input->post('p_use'));
        $displayproptype = $this->proptype_model->display_proptype();
        $result = array();
        $data = array(
            'p_type' => $this->input->post('p_type'), 'p_use' => $this->input->post('p_use')
        );
        $displayproptype = $this->proptype_model->display_proptype();
        $result = array();
        foreach ($displayproptype as $key => $value) {
            $result[] = $value->p_type;
            $result1[] = $value->p_use;
            if ((($this->input->post('p_type')) == ($value->p_type)) && (($this->input->post('p_use')) == ($value->p_use))) {
                $this->session->set_flashdata('message', 'Property type and Use of property Already Exists');
                $match = 1;
                break;
            } elseif (($this->input->post('p_type')) == ($value->p_type)) {
                $this->session->set_flashdata('message', 'Property type Exists');
                $match = 1;
                break;
            } elseif (($this->input->post('p_use')) == ($value->p_use)) {
                $this->session->set_flashdata('message', 'Use of property Already Exists');
                $match = 1;
                break;
            } else {
                $match = 0;
            }
        }
        if ($match == 0) {
            $this->proptype_model->add_proptype_data($data);
            $proptype = $this->input->post('p_type');
            $str = "Added Property type " . $proptype;
            newUserlog($str);
        }
        redirect('proptype', 'refresh');
    }

}
