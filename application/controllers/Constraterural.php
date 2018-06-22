<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class constraterural extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('constraterural_model', '', TRUE);
    }

    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['constraterural'] = $this->constraterural_model->display_constraterural();
            $this->load->view('constraterural_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function add_constraterural()
    {
        if (!$this->input->post('rural_id')) {
            $data = array(
                'c_type' => $this->input->post('c_type'),
                'g_floor' => $this->input->post('g_floor'),
                'u_floor' => $this->input->post('u_floor')
            );
            $constraterural = $this->constraterural_model->display_constraterural();
            $result = array();
            foreach ($constraterural as $key => $value) {
                $result[] = $value->c_type;
                if (($this->input->post('c_type')) == ($value->c_type)) {
                    $match = 1;
                    break;
                } else {
                    $match = 0;
                }
            }
            if ($match == 0) {
                $this->constraterural_model->add_constraterural($data);
            }
            if ($match == 1) {
                $this->session->set_flashdata('message', 'Already exists');
            }
        } else {
            $data = array(
                'c_type' => $this->input->post('c_type'),
                'g_floor' => $this->input->post('g_floor'),
                'u_floor' => $this->input->post('u_floor')
            );            
            $this->constraterural_model->update_rural($data,$this->input->post('rural_id'));
            $ctypeval = $this->input->post('c_type');
            $str = "Updated Construction Rate Rural of Type ". $ctypeval;
            newUserlog($str);
        }
        redirect('constraterural', 'refresh');
    }

}
