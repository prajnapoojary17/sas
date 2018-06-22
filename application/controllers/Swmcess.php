<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Swmcess Controller
 *
 * Description : This is used to handle SWM data
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
class Swmcess extends CI_Controller
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
        $this->load->model('swmcess_model', '', TRUE);
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
            $data['getswmcess'] = $this->swmcess_model->display_swmcess();
			$year=getcurrentYear();
			 $data['checkyear'] =$check=$this->swmcess_model->select_swmcess($year);
			 
            $this->load->view('swmcess_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function    :    add_swmcess
      # Purpose     :    Insert swm cess
      # params      :    None
      # Return      :    None
     */
    public function add_swmcess()
    {
        if (!$this->input->post('swm_id')) {
            if ($this->input->post('area_building') == 500) {
                $max = 500;
                $min = 0;
            } elseif ($this->input->post('area_building') == 501) {
                $max = 1000;
                $min = 501;
            } elseif ($this->input->post('area_building') == 1001) {
                $max = 2000;
                $min = 1001;
            } else {
                $max = '';
                $min = 2001;
            }
            $data = array(
                'year' => $this->input->post('year'),
                'p_type' => $this->input->post('p_type'),
                'area_building' => $this->input->post('area_building'),
                'amt' => $this->input->post('amt'),
                'max' => $max,
                'min' => $min
            );
            $display_swmcess = $this->swmcess_model->display_swmcess();
            $result = array();
            foreach ($display_swmcess as $key => $value) {
                $result[] = $value->p_type;
                if ((($this->input->post('p_type')) == ($value->p_type)) && (($this->input->post('area_building')) == ($value->area_building)) && (($this->input->post('year')) == ($value->year))) {
                    $match = 1;
                    break;
                } else {
                    $match = 0;
                }
            }
            if ($match == 0) {
                $this->swmcess_model->add_swmcess($data);
                $swmcessyear = $this->input->post('year');
                $str = "Added SWM CESS for " . $swmcessyear;
                newUserlog($str);
            }
            if ($match == 1) {
                $this->session->set_flashdata('message', 'Property Type and Sq ft Already  Exists');
            }
        } else {
            if ($this->input->post('area_building') == 500) {
                $max = 500;
                $min = 0;
            } elseif ($this->input->post('area_building') == 501) {
                $max = 1000;
                $min = 501;
            } elseif ($this->input->post('area_building') == 1001) {
                $max = 2000;
                $min = 1001;
            } else {
                $max = '';
                $min = 2001;
            }
            $data = array(
                'year' => $this->input->post('year'),
                'p_type' => $this->input->post('p_type'),
                'area_building' => $this->input->post('area_building'),
                'amt' => $this->input->post('amt'),
                'max' => $max,
                'min' => $min
            );
            $this->swmcess_model->update_swmcess($data, $this->input->post('swm_id'));
            $swmcessyear = $this->input->post('year');
            $str = "Updated SWM CESS for " . $swmcessyear;
            newUserlog($str);
        }
        redirect('swmcess', 'refresh');
    }
	
    /**
      # Function    :    checkswm
      # Purpose     :    select swm cess
      # params      :    None
      # Return      :    None
     */
    public function checkswm()
    {	                        
		 $year=getcurrentYear();						
		$check=$this->swmcess_model->select_swmcess($year);
		echo $check;
	}
	
	 /**
      # Function    :    insertdata
      # Purpose     :    select swm cess
      # params      :    None
      # Return      :    None
     */
    public function insertdata()
    {	  
		echo $prevyear=getprevYear();
		$check=$this->swmcess_model->check_swmcess($prevyear);
		//print_r($check);
		$year=getcurrentYear();	
		foreach ($check as $checks)
		{		
			$p_type=$checks->p_type;
			$area_building=$checks->area_building	;
			$amt=$checks->amt;
			$min=$checks->min;
			$max=$checks->max;
			 $array2[] = array("p_type" => "$p_type", "area_building" => $area_building, "amt" => $amt, "min" => $min, "max" => $max,"year"=>"$year");
		}
		$this->swmcess_model->insertdata($array2);
							
		//$check=$this->swmcess_model->select_swmcess($year);
		
	}
	

}
