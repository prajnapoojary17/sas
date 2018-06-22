<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Sasdetails Model
 *
 * Description : This is used to handle SAS data 
 *
 * Created By : Reshma
 *
 * Created Date : 23/09/2014
 *
 * Last Modified By : Gauthami
 *
 * Last Modified Date : 13/04/2017
 *
 */
class Reports_model extends CI_Model {

    /**
      # Function 	:	__construct
      # Purpose  	:	Class constructor
      # params 	:	None
      # Return 	:	None
     */
    function __construct() {
        parent::__construct();
    }

    /**
      # Function 	:	search sas
      # Purpose  	:	get_search for exiting payer
      # params 	:
      # Return 	:	Array
     */
    public function get_search($condition = "", $limit = 0, $per_page = 0, $forcount = 0)
    {
        $userifo = $this->session->userdata('logged_in');
        $username = $userifo['username'];
       // $query_str = "SELECT is_super_admin from users where username = '" . $username . "'";
       // $query = $this->db->query($query_str);
       // $ql = $query->result();
       // $adminstatus = $ql[0]->is_super_admin;
        
        $fromdate = date('Y-m-d', strtotime($condition['search_from']));
        $todate = date('Y-m-d', strtotime($condition['search_to'])); 
        //if ($adminstatus == 1) {
          //  $query_str = "SELECT * FROM user_logtime WHERE ( login_date BETWEEN '" . $fromdate . "' AND '" . $todate . "' ) AND username <> '" . $username . "' ORDER BY id ASC";  
       // }
        
          $query_str = "SELECT username, login_date, time, action FROM user_logtime WHERE ( login_date BETWEEN '" . $fromdate . "' AND '" . $todate . "' ) AND (action LIKE 'Added Owner info of%' OR action LIKE 'Added SAS detail of%' OR action LIKE 'Generated Challan of%') ORDER BY id ASC";  
          
        if ($per_page != 0) {
            $query_str .= " LIMIT " . $limit . "," . $per_page;
        }
        $query = $this->db->query($query_str);
        if ($forcount == 0) {
            return $query->result_array();
        } else {
            return $query->num_rows();
        }
    }

    public function get_searchcount($condition = "", $limit = 0, $per_page = 0, $forcount = 0)
    {
        $userifo = $this->session->userdata('logged_in');
        $username = $userifo['username'];
       // $query_str = "SELECT is_super_admin from users where username = '" . $username . "'";
       // $query = $this->db->query($query_str);
       // $ql = $query->result();
       // $adminstatus = $ql[0]->is_super_admin;
        
        $fromdate = date('Y-m-d', strtotime($condition['search_from']));
        $todate = date('Y-m-d', strtotime($condition['search_to'])); 
        //if ($adminstatus == 1) {
          //  $query_str = "SELECT * FROM user_logtime WHERE ( login_date BETWEEN '" . $fromdate . "' AND '" . $todate . "' ) AND username <> '" . $username . "' ORDER BY id ASC";  
       // }
        
        $query_str = "SELECT username, login_date, SUM(action LIKE 'Added Owner info of%') AS UPICount, SUM(action LIKE 'Added SAS detail of%') AS SASCount, SUM(action LIKE 'Generated Challan of%') AS ChallanCount FROM user_logtime WHERE ( login_date BETWEEN '" . $fromdate . "' AND '" . $todate . "' ) group by username, login_date";           
        if ($per_page != 0) {
            $query_str .= " LIMIT " . $limit . "," . $per_page;
        }
        $query = $this->db->query($query_str);

        if ($forcount == 0) {
           // return array('UPICount' => $query1->result_array(), 'SASCount' => $query2->result_array(), 'ChallanCount' => $query3->result_array());
            return $query->result_array();
        } else {
            return $query->num_rows();
        }
        
        
    }
}
