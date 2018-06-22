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
class Sasdetails_model extends CI_Model
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
    }

    /**
      # Function 	:	display_sasdetails
      # Purpose  	:	display_sasdetails
      # params 	:
      # Return 	:	Array
     */
    public function display_sasdetails($limit = 0, $per_page = 0, $forcount = 0)
    {

        if ($forcount == 0) {
            $query_str = "SELECT p.id as pid,b.id as bid,p.upi,p.p_name,g.p_ward,g.p_block,g.door_no,g.assmt_no,SUM(b.b_enhc_tax) as b_enhc_tax,p.p_year FROM prop_details p
left join tbl_generalinfo g on p.upi = g.upi
left join building_taxcal b on p.id = b.prop_id GROUP BY p.id";
            if ($per_page != 0) {
                $query_str .= " LIMIT " . $limit . "," . $per_page;
            }
            $query = $this->db->query($query_str);
            return $query->result_array();
        } else {
            $query_str = "SELECT count(p.id) as count FROM `prop_details` p
left join tbl_generalinfo g on p.upi = g.upi
left join building_taxcal b on p.id = b.prop_id GROUP BY p.id";
            $query = $this->db->query($query_str);
            $result = $query->num_rows();
            return $result;
        }
    }

    /**
      # Function 	:	display_sasdetails
      # Purpose  	:	display_sasdetails
      # params 	:
      # Return 	:	Array
     */
    public function display_sasdetails_count()
    {
        $query_str = "SELECT count(*) as count FROM prop_details";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
    }
	
	/**
      # Function 	:	display_sasdetails
      # Purpose  	:	display_sasdetails
      # params 	:
      # Return 	:	Array
     */
    public function display_sasdetails_count_admin($username)
    {
        $query_str = "SELECT count(*) as count FROM prop_details where created_by ='".$username."'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
    }
	
	
	
	 /**
      # Function 	:	display_sasdetails
      # Purpose  	:	display_sasdetails
      # params 	:
      # Return 	:	Array
     */
    public function display_user_admin($username)
    {
        $query_str = "SELECT count(*) as count FROM users where created_by ='".$username."'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
        
        //return $query->num_rows();
    }

    /**
      # Function 	:	display_users
      # Purpose  	:	display_users
      # params 	:
      # Return 	:	Array
     */
    public function display_users()
    {
        $query_str = "SELECT count(*) as count from tbl_generalinfo";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
    }

	/**
      # Function 	:	display_users
      # Purpose  	:	display_users
      # params 	:
      # Return 	:	Array
     */
    public function display_generated_challan()
    {
        $query_str = "SELECT count(*) as count from payment_details where is_payed=1";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
    }
	
	/**
      # Function 	:	display_users
      # Purpose  	:	display_users
      # params 	:
      # Return 	:	Array
     */
    public function display_generated_challan_admin($username)
    {
        $query_str = "SELECT count(*) as count from payment_details where is_payed=1 and created_by='".$username."'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['count'];
    }


	
    /**
      # Function 	:	check_doorno
      # Purpose  	:	check doorno for exiting payer
      # params 	:
      # Return 	:	Array
     */
    function check_doorno($ward, $block, $doorno)
    {

        $query_str = "SELECT pd.p_ward,pd.p_block
						FROM tbl_generalinfo AS pd
						WHERE pd.p_ward = '" . $ward . "' AND pd.p_block = '" . $block . "' AND pd.door_no = '" . $doorno . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result();
    }

    /**
      # Function 	:	check_payed_user
      # Purpose  	:	payed user
      # params 	:
      # Return 	:	Array
     */
    function check_payed_user($upi, $p_year)
    {
        $query_str = "SELECT prop_details.id FROM prop_details WHERE prop_details.upi = '" . $upi . "' and prop_details.p_year = '" . $p_year . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result();
    }

    /**
      # Function 	:	check_not_payed_user
      # Purpose  	:	check_not_payed_user
      # params 	:
      # Return 	:	Array
     */
    function check_not_payed_user($upi, $p_year)
    {
        $query_str = "SELECT prop_details.id,prop_details.p_year FROM prop_details WHERE prop_details.upi = '" . $upi . "' AND prop_details.p_year < '" . $p_year . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result_array();
    }

    /**
      # Function 	:	display_payerdetails
      # Purpose  	:	display_payerdetails for exiting payer
      # params 	:
      # Return 	:	Array
     */
    public function display_payerdetails($upi)
    {
        $query_str = "SELECT id, upi, area_cents, area_sqft, area_build, area_floors, area_ratio, undiv_right, p_use, stax_exempted, tax_applicablefrom, is_corn, value_corn, guide_50 FROM prop_details AS pd WHERE pd.upi = '" . $upi . "' ORDER BY pd.id DESC LIMIT 1";

        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	display_payerdetails
      # Purpose  	:	display_payerdetails for exiting payer
      # params 	:
      # Return 	:	Array
     */
    public function display_buildtaxdetails($id)
    {
        $query_str = "SELECT floor, c_year, tax_applicable_floor, type_const, b_value_sqft, b_guide_50, b_area_sqft, build_type	FROM building_taxcal WHERE prop_id = '" . $id . "'";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function 	:	search sas
      # Purpose  	:	get_search for exiting payer
      # params 	:
      # Return 	:	Array
     */
    public function get_search($condition = "", $limit = 0, $per_page = 0, $forcount = 0)
    {
        if ($condition['search_by'] == 'p_name') {
            $query_str = "SELECT p.id as pid,b.id as bid,p.upi,p.p_name,g.p_ward,g.p_block,g.door_no,g.assmt_no,SUM(b.b_enhc_tax) as b_enhc_tax,p.p_year FROM prop_details p
left join tbl_generalinfo g on p.upi = g.upi
left join building_taxcal b on p.id = b.prop_id WHERE p." . $condition['search_by'] . " LIKE '%" . $condition['sas_search'] . "%' GROUP BY p.id";
        } else {
            $query_str = " SELECT p.id as pid,b.id as bid,p.upi,p.p_name,g.p_ward,g.p_block,g.door_no,g.assmt_no,SUM(b.b_enhc_tax) as b_enhc_tax,p.p_year FROM prop_details p
left join tbl_generalinfo g on p.upi = g.upi
left join building_taxcal b on p.id = b.prop_id WHERE g." . $condition['search_by'] . " = '" . $condition['sas_search'] . "' GROUP BY p.id";
        }
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

    /**
      # Function 	:	checkupi
      # Purpose  	:	Check whether UPI exists in Database
      # params 	:   upi
      # Return 	:	Array
     */
    public function checkupi($upi)
    {
        $query_str = "SELECT sl_no,n_road FROM tbl_generalinfo	WHERE upi = '" . $upi . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	checkassessment
      # Purpose  	:	Check whether assessment number exists in Database
      # params 	:   assessment number
      # Return 	:	Array
     */
    public function checkassessment($assessment_no)
    {
        $query_str = "SELECT sl_no,n_road
						FROM tbl_generalinfo
						WHERE assmt_no = '" . $assessment_no . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	get_generalinfo
      # Purpose  	:	select general info based on condition
      # params 	:   condition
      # Return 	:	Array
     */
    public function get_generalinfo($condition)
    {
        $query_str = "SELECT * FROM tbl_generalinfo WHERE " . $condition['search_by'] . " = '" . $condition['search'] . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0];
    }

    /**
      # Function 	:	get_sasdetails
      # Purpose  	:	select sas detail based on condition
      # params 	:   property id, building id
      # Return 	:	Array
     */
    public function get_sasdetail($pid, $bid)
    {
        $query_str = "SELECT g.upi,g.p_name,g.o_name,g.contact_no,g.aadhar_no,g.assmt_no,g.p_ward,g.p_block,g.n_road,g.p_112C,g.ex_serviceman,g.ref_no,g.door_no,g.village,g.survey_no,b.floor, b.c_year, b.tax_applicable_floor, b.age_build, b.depreciation_rate, b.type_const, b.b_value_sqft, b.b_guide_50, b.b_area_sqft, b.build_type, b.land_tax_value, b.build_tax_value, b.app_tax, b.b_enhc_tax, p.area_cents, p.area_sqft, p.area_build, p.area_floors, p.area_ratio, p.undiv_right, p.p_use, p.tax_applicablefrom, p.tax_rate, p.p_year, p.enhancement_tax, p.value_cents, p.value_sqft, p.value_corn, p.value_total, p.guide_50 FROM prop_details p left join tbl_generalinfo g on p.upi = g.upi left join building_taxcal b on p.id = b.prop_id where p.id = '" . $pid . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result;
    }

    /**
      # Function 	:	check_propdata
      # Purpose  	:	check whether property detail exist
      # params 	:   upi, payment year
      # Return 	:	Array/status
     */
    public function check_propdata($upi, $p_year)
    {
        $query_str = "SELECT id
						FROM prop_details
						WHERE upi = '" . $upi . "' AND p_year = '" . $p_year . "' ";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	getGeneralinfo
      # Purpose  	:	get individual general info
      # params 	:   upi
      # Return 	:	Array/status
     */
    public function getGeneralinfo($upi)
    {
        $query_str = "SELECT p_name,o_name,contact_no,aadhar_no,p_112C,ex_serviceman
						FROM tbl_generalinfo
						WHERE upi = '" . $upi . "' ";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	getallGeneralinfo
      # Purpose  	:	get all general info
      # params 	:
      # Return 	:	Array/status
     */
    public function getallGeneralinfo($limit = 0, $per_page = 0, $forcount = 0)
    {

        if ($forcount == 0) {
            $query_str = "SELECT upi, p_name, n_road, contact_no, assmt_no, p_ward, p_block, door_no FROM tbl_generalinfo";
            if ($per_page != 0) {
                $query_str .= " LIMIT " . $limit . "," . $per_page;
            }
            $query = $this->db->query($query_str);
            return $query->result_array();
        } else {
            $query_str = "SELECT count(sl_no) as count FROM tbl_generalinfo";
            $query = $this->db->query($query_str);
            $result = $query->result_array();
            return $result[0]['count'];
        }
    }
    
    public function getRoadNames($wardid)
    {
        $query = "select road_name from ward_roadname where ward_no='".$wardid."' order by road_name ASC";
        $strquery = $this->db->query($query);
        $result = $strquery->result();
        return $result;
    }
    
    public function getRoadNameList($wardname)
    {
        $query = "select road_name from ward_roadname where ward_no=(select ward_no from ward where ward_name = '".$wardname."') order by road_name ASC";
        $strquery = $this->db->query($query);
        $result = $strquery->result();
        return $result;
    }

    public function getConstructionNames($optionName)
    {
        if ($optionName == 'rural') {
            $query = "select c_type, g_floor, u_floor from cons_rate_rural";
        } else {
            $query = "select c_type, g_floor, u_floor from cons_rate_city";
        }        
        $strquery = $this->db->query($query);
        $result = $strquery->result();
        return $result;
    }    
    
    public function getBuildingValue($c_rate,$c_type,$floor)
    {
        $tablename = '';
        $floornum = '';
        if ($c_rate == 'rural') {
            $tablename = 'cons_rate_rural';
        }else {
            $tablename = 'cons_rate_city';
        }
        if ($floor == '0') {
            $floornum = 'g_floor';
        }else {
            $floornum = 'u_floor';
        }
        $query = "select ".$floornum." from ".$tablename." where c_type = '".$c_type."'";             
        $strquery = $this->db->query($query);
        $result = $strquery->result_array();
        if ($floor == '0') {
            return $result[0]['g_floor'];
        }else {
            return $result[0]['u_floor'];
        }
        
    }
    
    public function getGuidanceValue($roadname,$ward_no)
    {
        $query = "select gvalcents_commercial, gvalcents_residential from guidance where road_name='".$roadname."' AND ward_no = ". $ward_no ."";
        $strquery = $this->db->query($query);
        $result = $strquery->result();
        return $result[0];
    }
       
    public function checkward_roadname($ward,$road)
    {
        $query = "select id from ward_roadname where road_name = '".$road."' AND ward_no = (select ward_no from ward where ward_name = '".$ward."' )";
        $query = $this->db->query($query);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
             
    }        
            
    
}
