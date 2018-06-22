<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Swmcess_model Model
 *
 * Description : This is used to handle SWM CESS data 
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
class Swmcess_model extends CI_model
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
      # Function :	display_swmcess
      # Purpose  :	display swmcess
      # Return   :	Array
     */
    public function display_swmcess()
    {
        $query = $this->db->get('swm_cess');
        return $query->result();
    }

    /**
      # Function :	add_swmcess
      # Purpose  :	Insert swmcess
      # Return   :	Array
     */
    public function add_swmcess($data)
    {
        $this->db->insert('swm_cess', $data);
    }

    /**
      # Function :	update_swmcess
      # Purpose  :	update swmcess
      # Return   :	Array
     */
    public function update_swmcess($data, $id)
    {
        $this->db->where('swm_id', $id);
        $this->db->update('swm_cess', $data);
    }
	
	  /**
      # Function :	select_swmcess
      # Purpose  :	select_swmcess swmcess
      # Return   :	Array
     */
    public function select_swmcess($year)
    {
		
        $this->db->select('*');
        $this->db->from('swm_cess');
		$this->db->where('year',$year);
		$query = $this->db->get();
        if ($query->num_rows() == 12) {
            return 1;
        } else {
            return 0;
        }
    }
	
	/**
      # Function :	select_swmcess
      # Purpose  :	select_swmcess swmcess
      # Return   :	Array
     */
    public function check_swmcess($year)
    {
		
       $this->db->select('*');
        $this->db->from('swm_cess');
		$this->db->where('year',$year);
		$query = $this->db->get();
        return $query->result();
    }
	/**
      # Function :	select_swmcess
      # Purpose  :	select_swmcess swmcess
      # Return   :	Array
     */
    public function insertdata($result)
    {
	
	  $this->db->insert_batch('swm_cess', $result);
	  }
	

}
