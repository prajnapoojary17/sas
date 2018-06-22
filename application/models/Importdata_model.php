<?php

/**
 *
 * File Name : Import Data Model
 *
 * Description : Used to import data to DB
 *
 * Created By : Prajna P
 *
 * Created Date : 01/02/2017
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 01/02/2017
 *
 */
class Importdata_model extends CI_Model
{

    /**
      # Function 	:	Add_Userdata
      # Purpose  	:	add general information to database
      # params 	:	Array
      # Return 	:	last inserted id
     */
    public function Add_Userdata($data_user)
    {
        $this->db->insert('tbl_generalinfo', $data_user);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    /**
      # Function 	:	Add_Propertydata
      # Purpose  	:	add property information to database
      # params 	:	Array
      # Return 	:	last inserted id
     */
    public function Add_Propertydata($data_prop)
    {
        $this->db->insert('prop_details', $data_prop);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    /**
      # Function 	:	Add_Buildingdata
      # Purpose  	:	add building information to database
      # params 	:	Array
      # Return 	:	status
     */
    public function Add_Buildingdata($data_build)
    {
        $this->db->insert('building_taxcal', $data_build);
        return true;
    }

    /**
      # Function 	:	Add_Paymentdata
      # Purpose  	:	add payment information to database
      # params 	:	Array
      # Return 	:	status
     */
    public function Add_Paymentdata($data_pay)
    {
        $this->db->insert('payment_details', $data_pay);
        return true;
    }

    /**
      # Function 	:	check_paymentdata
      # Purpose  	:	to check whether payment detail is alresdy entered
      # params 	:	propId
      # Return 	:	row value/status
     */
    public function check_paymentdata($propId)
    {
        $query_str = "SELECT payment_id
                                        FROM payment_details
                                        WHERE p_id = '" . $propId . "' ";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    public function check_guidance($road_name,$ward_no,$gvalcents_commercial,$gvalcents_residential)
    {
        $query_str = "SELECT g_id
                                        FROM guidance
                                        WHERE road_name  = '" . $road_name . "' AND ward_no = '" . $ward_no . "' AND gvalcents_commercial = '" . $gvalcents_commercial . "' AND gvalcents_residential = '" . $gvalcents_residential . "' ";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
      # Function 	:	check_builddata
      # Purpose  	:	to check whether building detail is alresdy entered
      # params 	:	propId
      # Return 	:	row value/status
     */
    public function check_builddata($propId, $floor, $upi)
    {
        $query_str = "SELECT id
                                        FROM building_taxcal
                                        WHERE prop_id = '" . $propId . "' AND floor = '" . $floor . "' AND upi='" . $upi . "' ";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    public function Add_Guidancedata($data_user)
    {
        $this->db->insert('guidance', $data_user);
        return true;    
    }
    
    public function Add_WardRoadnamedata($data_wardroad)
    {
        $this->db->insert('ward_roadname', $data_wardroad);
        return true;
    }
}
