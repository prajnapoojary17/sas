<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : User Model
 *
 * Description : This is used to handle User data 
 *
 * Created By : Gauthami
 *
 * Created Date : 01/03/2017
 *
 * Last Modified By : Prajna
 *
 * Last Modified Date : 13/04/2017
 *
 */
Class User extends CI_Model
{

    /**
      # Function 	:	login
      # Purpose  	:	check login of users
      # params 	:   username, password and status
      # Return 	:	Array
     */
    function login($username, $password)
    {
        $this->db->select('id, username, password, status');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

	 /**
      # Function 	:	login
      # Purpose  	:	check login of users
      # params 	:   username, password and status
      # Return 	:	Array
     */
    function check_swmcess($year)
    {
        $this->db->select('*');
        $this->db->from('swm_cess');
        $this->db->where('year', $year);
        
        $query = $this->db->get();
        if ($query->num_rows() == 12) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
	
	 /**
      # Function 	:	login
      # Purpose  	:	check login of users
      # params 	:   username, password and status
      # Return 	:	Array
     */
    function check_cess($year)
    {
        $this->db->select('cess_id');
        $this->db->from('cess');
        $this->db->where('cess_id', $year);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
	 /**
      # Function 	:	login
      # Purpose  	:	check login of users
      # params 	:   username, password and status
      # Return 	:	Array
     */
    function check_enhance($year)
    {
        $this->db->select('e_ID');
        $this->db->from('enhance');
        $this->db->where('e_year', $year);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
	
    /**
      # Function 	:	get_status
      # Purpose  	:	get status of user(active/inactive)
      # params 	:   username
      # Return 	:	Array
     */
    function get_status($username)
    {

        $query_str = "SELECT ru.role,ru.is_super_admin
						FROM users AS ru
						WHERE ru.username = '" . $username . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();

        if (count($result)) {
            return $result[0];
        } else {
            return 0;
        }
    }

    /**
      # Function 	:	saveUserlog
      # Purpose  	:	To save user logs to database
      # params 	:	Array
      # Return 	:
     */
    public function saveUserlog($data)
    {
        $ipaddress = $this->get_ip_address();
        $userrole = $this->session->userdata('role');
        $info = array(
            'user_id' => $data['id'],
            'username' => $data['username'],
            'userrole' => $userrole,
            'sid' => $data['my_session_id'],
            'login_date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'ipaddress' => $ipaddress,
            'action' => 'Logged In'
        );
        $this->db->insert('user_logtime', $info);
    }

    /**
      # Function 	:	updateUserlog
      # Purpose  	:	To update user logs to database while logout
      # params 	:	Array
      # Return 	:
     */
    public function updateUserlog($data)
    {
        $ipaddress = $this->get_ip_address();
        $userrole = $this->session->userdata('role');
        $info = array(
            'user_id' => $data['id'],
            'username' => $data['username'],
            'userrole' => $userrole,
            'sid' => $data['my_session_id'],
            'login_date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'ipaddress' => $ipaddress,
            'action' => 'Logged Out'
        );
        $this->db->insert('user_logtime', $info);
    }

    /**
     * function to get ip address 
     *
     * @returns ip
     */
    public function get_ip_address()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

}
