<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Home Controller
 *
 * Description : This is used to handle user
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
class Home extends CI_Controller
{

    /**
      # Function     :    __construct
      # Purpose      :    Class constructor
      # params     :    None
      # Return     :    None
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('sasdetails_model', 'sasdetails');
		  $this->load->model('usermanage_model', 'usermanage');
        $this->load->model('user', '', TRUE);
    }

    /**
      # Function     :    index
      # Purpose      :    Initial settings
      # params     :    None
      # Return     :    None
     */
    function index()
    {
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
			$data['is_super_admin'] = $is_super_admin = $this->usermanage->check_super_admin($userifo['username']);
			
			$year = date("Y");
            $str1 = substr($year, 2);
            $nextyear = $str1 + 1;
            $year = $year . "-" . $nextyear;						
			  $swmcess=$this->user->check_swmcess($year);
			 $cess=$this->user->check_cess($year);
			$enhance=$this->user->check_enhance($year);
			
			$data['swmcess'] = $swmcess;
			    $data['cess'] = $cess;
				$data['enhance'] = $enhance;
            if ($is_super_admin == 1) {
			 $users_count = $this->sasdetails->display_users();
			 $challan_count = $this->sasdetails->display_generated_challan();
			  $records_count = $this->sasdetails->display_sasdetails_count();
               $data['users'] = $users_count;
			    $data['sasdetails'] = $records_count;
				$data['challans'] = $challan_count;
            } else {
			 $users_counts = $this->sasdetails->display_user_admin($userifo['username']);
			 $challan_counts = $this->sasdetails->display_generated_challan_admin($userifo['username']);
			  $records_counts = $this->sasdetails->display_sasdetails_count_admin($userifo['username']);
               $data['users'] = $users_counts;
			    $data['sasdetails'] = $records_counts;
				$data['challans'] = $challan_counts;
				
            }
			
            $this->load->view('home_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    logout
      # Purpose      :    logout
      # params     :    None
      # Return     :    None
     */
    function logout()
    {
        if ($this->session->userdata('logged_in')) {
            $data = $this->session->userdata('logged_in');
            $this->user->updateUserlog($data);
            $this->session->unset_userdata('logged_in'); 
			unset($_SESSION['saw_js']);
            redirect('home', 'refresh');
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}
