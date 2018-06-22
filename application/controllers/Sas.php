<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Sas Controller
 *
 * Description : This is used to handle SAS data
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
class Sas extends CI_Controller
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
        $this->load->model('sasdetails_model', 'sasdetails');
        $uri = $this->uri->segment(1, 0);
        //Load the pagination library
        $this->load->library('pagination');
    }

    /**
      # Function 	:	index
      # Purpose  	:	Initial settings
      # params 	:	None
      # Return 	:	None
     */
    function index()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_GET['id'])) {
                $search_by = $_GET['search_by'];
                $sas_search = $_GET['sas_search'];
                $condition['search_by'] = $search_by;
                $condition['sas_search'] = $sas_search;
                $config['base_url'] = base_url() . '/sas/index?search_by=' . $search_by . '&sas_search=' . $sas_search . '&id=';
            } else {
                $condition['search_by'] = '';
                $condition['sas_search'] = '';
                $config['base_url'] = base_url() . '/sas/index/';
            }
            if (isset($_GET['per_page'])) {
                $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                $uri_segments = $_GET['per_page'];
            } else {
                $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                $uri_segments = '';
            }
            $uri_segment = ($uri_segments == '' ? '0' : $uri_segments);
            // SET DATA FOR PAGINATION
            $config['page_query_string'] = TRUE;
            $config['uri_segment'] = 3;
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;
            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="curve_right">';
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = 'Prev';
            $config['prev_tag_open'] = '<li class="curve">';
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li><a class="active">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            if ($condition['sas_search'] != '') {
                $records_array = $this->sasdetails->get_search($condition, $uri_segment, $config['per_page'], 0);
                $records_array_totrec = $this->sasdetails->get_search($condition, 0, 0, 1);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $data['sas_search'] = $condition['sas_search'];
                $data['search_by'] = $condition['search_by'];
                $this->session->unset_userdata('pd_search');
                $this->load->view('sas_view', $data);
            } else {
                $records_array_totrec = $this->sasdetails->display_sasdetails(0, 0, 1);
                $records_array = $this->sasdetails->display_sasdetails($uri_segment, $config['per_page'], 0);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $this->session->unset_userdata('pd_search');
                $this->load->view('sas_view', $data);
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

}