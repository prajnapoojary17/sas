<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Usermanage_model Model
 *
 * Description : This is used to handle User data 
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
class Usermanage_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
      # Function 	:	get_main_result
      # Purpose  	:	users query
      # params 	:
      # Return 	:	Array
     */
    public function get_main_result()
    {
        $query_str = "SELECT * from users ORDER BY id ASC";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function 	:	get_main_result
      # Purpose  	:	users query
      # params 	:
      # Return 	:	Array
     */
    public function get_main_result_admin($username)
    {
        $query_str = "SELECT * from users where role!='Admin' and created_by='" . $username . "' ORDER BY id ASC";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function 	:	check_user
      # Purpose  	:	check_user
      # params 	:	username
      # Return 	:	Array
     */
    public function check_user($username)
    {

        $query_str = "SELECT ru.username
						FROM users AS ru
						WHERE ru.username = '" . $username . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result();
    }

    /**
      # Function 	:	check_email
      # Purpose  	:	check_email
      # params 	:	email
      # Return 	:	Array
     */
    public function checkemail($email, $id)
    {

        $query_str = "SELECT id
						FROM users AS ru
						WHERE ru.email = '" . $email . "' AND ru.id <> '" . $id . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
      # Function 	:	check_email
      # Purpose  	:	check_email
      # params 	:	email
      # Return 	:	Array
     */
    public function check_email($email)
    {

        $query_str = "SELECT ru.username
						FROM users AS ru
						WHERE ru.email = '" . $email . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result();
    }

    /**
      # Function 	:	get_user
      # Purpose  	:	get_user
      # params 	:	username
      # Return 	:	Array
     */
    public function get_user($username)
    {
        $query_str = "SELECT ru.username
							FROM users AS ru
							WHERE ru.username = '" . $username . "'";
        $query = $this->db->query($query_str);
        $result = $query->result();
        $this->db->last_query();
        die();
        return $query->result();
    }

    /**
      # Function 	:	update_role
      # Purpose  	:	update users info
      # params 	:	role,id &status
      # Return 	:	Array
     */
    public function update_role($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    /**
      # Function 	:	getLogs
      # Purpose  	:	get all user logs
      # params 	:
      # Return 	:	Array
     */
    public function getLogs($username)
    {
        $query_str = "SELECT is_super_admin from users where username = '" . $username . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        $adminstatus = $ql[0]->is_super_admin;
        $date1 = date('Y-m-d');        
        if ($adminstatus == 1) {
            $query_str = "SELECT * FROM user_logtime where (login_date = '" . $date1 . "') AND username <> '" . $username . "' ORDER BY id ASC ";
        } else {
            $query_str = "SELECT ul.* FROM user_logtime ul left join users u on ul.username = u.username where (ul.login_date = '" . $date1 . "') AND u.created_by = '" . $username . "' ORDER BY id ASC ";
        }
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    public function check_super_admin($username)
    {

        $query_str = "SELECT is_super_admin
						FROM users AS ru
						WHERE ru.username = '" . $username . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['is_super_admin'];
    }

    /**
      # Function 	:	getUsername
      # Purpose  	:	get username
      # params 	:   id
      # Return 	:	username
     */
    public function getUsername($id)
    {
        $query_str = "SELECT username FROM users WHERE id = '" . $id . "'";
        $query = $this->db->query($query_str);
        $result = $query->result_array();
        return $result[0]['username'];
    }

}
