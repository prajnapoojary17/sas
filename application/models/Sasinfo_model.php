<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Sasinfo_model Model
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
class Sasinfo_model extends CI_model
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
      # Function 	:	addgeneralInfo
      # Purpose  	:	Add general information
      # Return 	:	Array
     */
    public function addgeneralInfo($info)
    {
        $this->db->insert('tbl_generalinfo', $info);
    }

    /**
      # Function 	:	addpropertyInfo
      # Purpose  	:	Add property information
      # Return 	:	Array
     */
    public function addpropertyInfo($info)
    {
        $this->db->insert('prop_details', $info);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    /**
      # Function 	:	addbldtaxInfo
      # Purpose  	:	Add Sas calculation information
      # Return 	:	Array
     */
    public function addbldtaxInfo($data)
    {
        $this->db->insert('building_taxcal', $data);
    }

    /**
      # Function 	:	updategeneralInfo
      # Purpose  	:	update general information
      # Return 	:	Array
     */
    public function updategeneralInfo($info, $id)
    {
        $this->db->where('sl_no', $id);
        $this->db->update('tbl_generalinfo', $info);
    }

}
