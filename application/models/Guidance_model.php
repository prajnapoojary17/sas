<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : guidance_model Model
 *
 * Description : This is used to handle guidance data 
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
class Guidance_model extends CI_model
{

    /**
      # Function 	:	__construct
      # Purpose  	:	Class constructor
      # params 	:	None
      # Return 	:	None
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
      # Function :	display_guidance
      # Purpose  :	display guidance
      # Return   :	Array
     */
    public function display_guidance()
    {
        $query = $this->db->get('guidance');
        return $query->result();
    }

    /**
      # Function :	add_guidance
      # Purpose  :	Insert guidance
      # Return   :	Array
     */
    public function add_guidance($data)
    {
        $this->db->insert('guidance', $data);
    }

    /**
      # Function :	update_guidance
      # Purpose  :	update guidance
      # Return   :	Array
     */
    public function update_guidance($data, $id)
    {
        $this->db->where('g_id', $id);
        $this->db->update('guidance', $data);
    }

    /**
      # Function :	get_roadname
      # Purpose  :	get road name
      # Return   :	Array
     */
    public function get_roadname()
    {
        $sql_query = "SELECT road_name,gvalcents_commercial,gvalcents_residential FROM guidance";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    /**
      # Function :	get_guidevalue
      # Purpose  :	get guidance value
      # Return   :	Array
     */
    public function get_guidevalue($roadName,$propType,$wardname)
    {
        $sql_query = "SELECT gvalcents_commercial,gvalcents_residential FROM guidance WHERE road_name='" . $roadName . "' AND ward_no = (select 	ward_no from ward WHERE ward_name = '" . $wardname . "')";
        $query = $this->db->query($sql_query);
        $result = $query->result_array();
        return $result[0];
    }
    
    public function add_wardroadname($data)
    {
        $this->db->insert('ward_roadname',$data);        
    }
    
    /**
      # Function :	display_guidance
      # Purpose  :	display guidance
      # Return   :	Array
     */
    public function diaplay_warroadname()
    {
        $sql_query = "SELECT ward_roadname.*,ward.ward_name FROM ward_roadname LEFT JOIN ward on ward_roadname.ward_no = ward.ward_no";
        $query = $this->db->query($sql_query);
        $result = $query->result_array(); 
        return $result;
    }
    
    
    /**
      # Function :	update_guidance
      # Purpose  :	update guidance
      # Return   :	Array
     */
    public function update_wardroad($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('ward_roadname', $data);
    }
    
    public function get_road_name($upi)
    {
        $sql_query = "SELECT n_road FROM tbl_generalinfo WHERE upi = '" . $upi . "'";
        $query = $this->db->query($sql_query);
        $result = $query->result();
        return $result[0]->n_road;
    }

    public function get_ward_name($upi)
    {
        $sql_query = "SELECT p_ward FROM tbl_generalinfo WHERE upi = '" . $upi . "'";
        $query = $this->db->query($sql_query);
        $result = $query->result();
        return $result[0]->p_ward;
    }
}
