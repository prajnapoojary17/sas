<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class constratecity extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('constratecity_model','',TRUE);
    }

    public function index()
    {
        if(($this->session->userdata('logged_in'))&&($this->session->userdata('role')=='Admin'))
        {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['constratecity'] = $this->constratecity_model->display_constratecity();
            $this->load->view('constratecity_view',$data);
        }
        else
        {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
	
    public function add_constratecity()	
    {
        if (!$this->input->post('city_id')) {
            $data = array(
                'c_type' => $this->input->post('c_type'),
                'g_floor'=>$this->input->post('g_floor'),
                'u_floor'=>$this->input->post('u_floor')
            );
            $constratecity= $this->constratecity_model->display_constratecity();
            $result = array();
            foreach ($constratecity as $key => $value) 
            {
                $result[] = $value->c_type;
                if(($this->input->post('c_type'))==($value->c_type))
                {
                    $match=1;
                    break;
                }
                else
                {
                    $match=0;
                }
            }
            if($match==0)
            {
                $this->constratecity_model->add_constratecity($data);
            }
            if ($match == 1) {
                $this->session->set_flashdata('message', 'Already exists');
            }
        }else {
            $data = array(
                'c_type' => $this->input->post('c_type'),
                'g_floor'=>$this->input->post('g_floor'),
                'u_floor'=>$this->input->post('u_floor')
            );            
            $this->constratecity_model->update_city($data,$this->input->post('city_id'));
            $ctypeval = $this->input->post('c_type');
            $str = "Updated Construction Rate City of Type ". $ctypeval;
            newUserlog($str);
        }
        redirect('constratecity', 'refresh');
    }
}