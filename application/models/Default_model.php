<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Default Model
 *
 * Description : This is used to handle Defaulters report 
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
class Default_model extends CI_model
{

    /**
      # Function :	__construct
      # Purpose  :	Class constructor
      # params 	 :	None
      # Return   :	None
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
      # Function :	sidedisplay_data
      # Purpose  :	get
      # Return   :	Array
     */
    public function sidedisplay_data($ward, $limit = 0, $per_page = 0, $forcount = 0)
    {
        $query_str = "SELECT upi
			FROM  openingbalance WHERE  p_ward = '{$ward}' GROUP BY upi";
        if ($per_page != 0) {
            $query_str .= " LIMIT " . $limit . "," . $per_page;
        }
        $query = $this->db->query($query_str);
        if ($forcount == 0) {
            return $query->result();
        } else {
            return $query->num_rows();
        }
    }

    /**
      # Function :	selectyear
      # Purpose  :	get
      # Return   :	Array
     */
    public function selectyear()
    {
        $query = $this->db->query("Select e_year from enhance");
        return $query->result();
    }

    /**
      # Function :	ward
      # Purpose  :	get ward
      # Return   :	Array
     */
    public function ward()
    {
        $query = $this->db->query("Select ward_name from ward");
        return $query->result();
    }

    /**
      # Function :	display_default
      # Purpose  :	get upi based on ward
      # Return   :	Array
     */
    public function display_default($ward)
    {
        $query = $this->db->query("Select upi from  tbl_generalinfo where p_ward='" . $ward . "'");
        return $query->result_array();
    }

    /**
      # Function :	getMissingYear
      # Purpose  :	get
      # Return   :	Array
     */
    public function getMissingYear($upi, $pyear)
    {
        $query = $this->db->query("SELECT id FROM `prop_details` WHERE upi='" . $upi . "'  and p_year='" . $pyear . "'");
        $ql = $query->result_array();
        if ($ql) {
            return $ql[0];
        } else {
            return false;
        }
    }

    /**
      # Function :	getMissingYearFromPayment
      # Purpose  :	get
      # Return   :	Array
     */
    public function getMissingYearFromPayment($upi, $pyear)
    {
        $query = $this->db->query("SELECT `p_year` FROM `payment_details` WHERE upi='" . $upi . "'  and p_year='" . $pyear . "' GROUP BY p_year");
        return $query->result();
    }

    /**
      # Function :	getbuildtax
      # Purpose  :	get
      # Return   :	Array
     */
    public function getbuildtax($pid)
    {
        $query = $this->db->query("SELECT SUM(`b_cess`) as b_cess, SUM(`b_enhc_tax`) as b_enhc_tax FROM `building_taxcal` WHERE prop_id='" . $pid . "' GROUP BY prop_id");

        $qry = $query->result_array();
        if ($qry) {
            return $qry[0];
        } else {
            return false;
        }
    }

    /**
      # Function :	checkward
      # Purpose  :	get
      # Return   :	Array
     */
    public function checkward($ward)
    {
        $query = $this->db->query("SELECT p_ward from openingbalance where p_ward='" . $ward . "'");
        return $query->result();
    }

    /**
      # Function :	insertobcb
      # Purpose  :	get
      # Return   :	Array
     */
    public function insertobcb($result, $upi, $missyear)
    {
        $sql1 = "Select upi from openingbalance  WHERE  upi='$upi' and p_year='$missyear'";
        $query1 = $this->db->query($sql1);
        if (!$query1->result()) {
            $this->db->insert_batch('openingbalance', $result);
        }        
    }
	
	 /**
      # Function :	insertobcb
      # Purpose  :	get
      # Return   :	Array
     */
    public function delete_opening_balance($ward)
    {      
		$this->db->where('p_ward', $ward);
		$this->db->delete('openingbalance');
    }

}
