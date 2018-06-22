<?php

/**
 * File Name : Report Generate Controller
 *
 * Description : This is used to print reports of users work log
 *
 * Created By : Prajna P
 *
 * Created Date : 19/08/2017
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 19/08/2017
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Generatereport extends CI_Controller
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
        $this->load->library('excel');
        $this->load->model('reports_model','reports');
        $this->load->model('sasdetails_model', 'sasdetails');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    /**
      # Function     :    index
      # Purpose      :   Load Initial settings and show import view
      # params     :    None
      # Return     :    None
     */
    public function index()
    {
       // ini_set('memory_limit', '-1');
       // set_time_limit(0);
        $this->load->library('pagination');
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_GET['date1'])) {
                $search_from = $_GET['date1'];
                $search_to = $_GET['date2'];                
                $condition['search_from'] = $search_from;
                $condition['search_to'] = $search_to;
                $config['base_url'] = base_url() . '/generatereport/index?date1=' . $search_from . '&date2=' . $search_to . '&id=';
            } else {
                $condition['search_from'] = '';
                $condition['search_to'] = '';
                $config['base_url'] = base_url() . '/generatereport/index/';
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
            if ($condition['search_from'] != '') {
                $records_array = $this->reports->get_search($condition, $uri_segment, $config['per_page'], 0);
                $records_array_totrec = $this->reports->get_search($condition, 0, 0, 1);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                if($search_from > $search_to){
                    $data["page_links"] = $this->pagination->create_links();
                    $data['total_record'] = $records_array_totrec;
                    $data['records'] = $records_array;
                    $data['date1'] = $condition['search_from'];
                    $data['date2'] = $condition['search_to'];
                    $data['error'] = 'Invalid Date';
                    $this->load->view('reports', $data);                    
                }else{
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $data['date1'] = $condition['search_from'];
                $data['date2'] = $condition['search_to'];              
                $this->load->view('reports', $data);
                }
            } else {         
              
                $this->load->view('reports', $data);
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    importdataadd
      # Purpose      :   Upload data to database
      # params     :    None
      # Return     :    None
     */
    public function printreport()
    {
        $this->load->library('export');            
        $condition = array();
        $condition['search_from'] = $_GET['fromdate'];
        $condition['search_to'] = $_GET['todate'];
        if($condition['search_from']=='' || $condition['search_to']=='')
        {
            $heading = array("No Record Found");
            $new_array_for_excel = array (
                "0" => array ('')
                );
            $this->export->to_excel($heading, $new_array_for_excel, 'User_Report_'.date('d-m-Y-H-i-s'));
            exit;
        }
        $records_array = $this->reports->get_search($condition, 0, 0, 0);        
        $heading = array("User Name","Date", "Time", "Action");
        $i=0;
        $records_multi_array = array();
        foreach($records_array as $records_obj)
        {
            if(isset($records_obj->StartEndDate) && $records_obj->StartEndDate!='')
            {
                    $StartEndDate = explode("!!==!!",$records_obj->StartEndDate);
                    $BillingFrom = $StartEndDate[0];
                    $BillingTo = $StartEndDate[1];
            }else
            {
                    $BillingFrom = "";
                    $BillingTo = "";
            }
            $records_multi_array[$i]['username']      = $records_obj['username'];
            $records_multi_array[$i]['logindate']    = $records_obj['login_date'];
            $records_multi_array[$i]['time']          = $records_obj['time']; 
            $records_multi_array[$i]['action']          = $records_obj['action'];           
            $i++;
        }

        $this->export->to_excel($heading, $records_multi_array, 'User_Report_'.date('d-m-Y-H-i-s')); 
    }

    public function countReport()
    {        
        $this->load->library('pagination');
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_GET['date1'])) {
                $search_from = $_GET['date1'];
                $search_to = $_GET['date2'];                
                $condition['search_from'] = $search_from;
                $condition['search_to'] = $search_to;
                $config['base_url'] = base_url() . '/generatereport/countReport?date1=' . $search_from . '&date2=' . $search_to . '&id=';
            } else {
                $condition['search_from'] = '';
                $condition['search_to'] = '';
                $config['base_url'] = base_url() . '/generatereport/countReport/';
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
            if ($condition['search_from'] != '') {
                $records_array = $this->reports->get_searchcount($condition, $uri_segment, $config['per_page'], 0);
                $records_array_totrec = $this->reports->get_searchcount($condition, 0, 0, 1);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                if($search_from > $search_to){
                    $data["page_links"] = $this->pagination->create_links();
                    $data['total_record'] = $records_array_totrec;
                    $data['records'] = $records_array;
                    $data['date1'] = $condition['search_from'];
                    $data['date2'] = $condition['search_to'];
                    $data['error'] = 'Invalid Date';
                    $this->load->view('reports', $data);                    
                }else{
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $data['date1'] = $condition['search_from'];
                $data['date2'] = $condition['search_to'];              
                $this->load->view('countReports', $data);
                }
            } else {         
              
                $this->load->view('countReports', $data);
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    /**
      # Function     :    importdataadd
      # Purpose      :   Upload data to database
      # params     :    None
      # Return     :    None
     */
    public function printreportCount()
    {
        $this->load->library('export');            
        $condition = array();
        $condition['search_from'] = $_GET['fromdate'];
        $condition['search_to'] = $_GET['todate'];
        if($condition['search_from']=='' || $condition['search_to']=='')
        {
            $heading = array("No Record Found");
            $new_array_for_excel = array (
                "0" => array ('')
                );
            $this->export->to_excel($heading, $new_array_for_excel, 'User_Report_'.date('d-m-Y-H-i-s'));
            exit;
        }
        $records_array = $this->reports->get_searchcount($condition, 0, 0, 0);        
        $heading = array("User Name","Date", "UPICount", "SASCount", "ChallanCount");
        $i=0;
        $records_multi_array = array();
        foreach($records_array as $records_obj)
        {            
            $records_multi_array[$i]['username']      = $records_obj['username'];
            $records_multi_array[$i]['logindate']    = $records_obj['login_date'];
            $records_multi_array[$i]['UPICount']          = $records_obj['UPICount']; 
            $records_multi_array[$i]['SASCount']          = $records_obj['SASCount']; 
            $records_multi_array[$i]['ChallanCount']          = $records_obj['ChallanCount']; 
            $i++;
        }

        $this->export->to_excel($heading, $records_multi_array, 'User_Report_'.date('d-m-Y-H-i-s')); 
    }    
}