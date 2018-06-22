<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_ip_address'))
{
        
    /**
      # Function 	:	saveUserlog
      # Purpose  	:	To save user logs to database
      # params 	:	Array
      # Return 	:	
     */
    function newUserlog($str)
    {
        $ipadd = 0;
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        $ipadd = $ip;
                    }
                }
            }
        }
        $ci=& get_instance();
        $userifo = $ci->session->userdata('logged_in');
        $userrole = $ci->session->userdata('role');
        $data['user_id'] = $userifo['id'];
        $data['username'] = $userifo['username'];
        $data['userrole'] = $userrole;
        $data['sid'] = $userifo['my_session_id'];
        $data['login_date'] = date('Y-m-d'); 
        $data['time'] = date('H:i:s');
        $data['ipaddress'] = $ipadd; 	
        $data['action'] = $str;
        $ci->load->database();
        $ci->db->insert('user_logtime', $data);
    }
	
	/**
      # Function 	:	getcurrentYear
      # Purpose  	:	get current financial year
      # params 	:	Array
      # Return 	:	
     */
    function getcurrentYear()
    {
        $year = date("Y");
        $str1 = substr($year, 2);
        $nextyear = $str1 + 1;
        $year = $year . "-" . $nextyear;  
		return 	$year;
    }
	
	/**
      # Function 	:	getcurrentYear
      # Purpose  	:	get current financial year
      # params 	:	Array
      # Return 	:	
     */
    function getprevYear()
    {
        $year = date("Y");
		$year= $year-1;
        $str1 = substr($year, 2);
        $nextyear = $str1 + 1;
        $year = $year . "-" . $nextyear;  
		return 	$year;
    }
	
    function logQueryTime($st)
    {
        $t = $st.round(microtime(true) * 1000);
        $filename = 'mydata.txt';	
        file_put_contents($filename, $t, FILE_APPEND | LOCK_EX );         
    }
	
}