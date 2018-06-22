<?php

defined('BASEPATH') OR exit('No direct script access allowed');



if (!function_exists('display_data')) {

    function display_data($ward, $fromdate, $between, $todate) {
        $whereArr = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $query = $this->db->query("Select * from prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}  ORDER BY p_name ");

        return $query->result();
    }

}




if (!function_exists('suspcheck')) {

    function suspcheck($door_no, $pyear, $ward, $block) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT p_year FROM prop_detail WHERE door_no = '$door_no' AND p_year = '$pyear' AND p_ward = '$ward' AND p_block = '$block' order by p_year";
        $query = $ci->db->query($sql);
        $t = '';
        foreach ($query->result() as $row) {
            $t = $row->p_year;
        }
        return $t;
    }

}


if (!function_exists('enhancerate')) {

    function enhancerate($pyear) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT e_rate FROM enhance WHERE e_year = '$pyear'";
        $query = $ci->db->query($sql);
        foreach ($query->result() as $row) {
            $t = $row->e_rate;
        }
        return $t;
    }

}


if (!function_exists('recordcount')) {

    function recordcount($door_no, $ward, $block, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = '';
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $sql = "SELECT count(*) as count FROM prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}";
        $query = $ci->db->query($sql);
        foreach ($query->result() as $row) {
            $t = $row->count;
        }
        return $t;
    }

}




if (!function_exists('obcb')) {

    function obcb($ward, $upi, $assmt_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();

        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "tg.p_ward = '{$ward}'";
        if ($upi != "")
            $whereArr[] = "tg.upi = '{$upi}'";
        if ($assmt_no != "")
            $whereArr[] = "tg.assmt_no = '{$assmt_no}'";
        if ($fromdate != "")
            $whereArr1[] = "pd.p_year IN ('{$fromdate}','{$between}','{$todate}')";
        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $sql = "SELECT LEFT( p_year,4) as newyear, pd.p_year,SUM(bt.b_enhc_tax), p.property_tax,
            ( SUM(bt.b_enhc_tax) - p.property_tax )taxadj, ( SUM(bt.b_cess) - p.cess )cessadj,
            @a := ( @a + bt.b_enhc_tax ) - p.property_tax col3,SUM(bt.b_cess) , p.cess,@b := ( @b + bt.b_cess ) - p.cess col4,
            p.payment_date,p.rebate,p.p_total FROM tbl_generalinfo tg LEFT JOIN prop_details pd ON tg.upi=pd.upi 
            LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
            JOIN ( SELECT @a :=0,@b :=0 )t where  {$whereStr} {$whereStr1} {$whereStr2} GROUP BY pd.p_year ORDER BY newyear ASC";

        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;
    }

}


if (!function_exists('obcbmiss1')) {

    function obcbmiss1($ward, $block, $door_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $sql = "select p_year,b_enhc_tax,b_cess,property_tax,cess,rebate, payment_date,p_total,( b_enhc_tax - property_tax )taxadj, ( b_cess - cess )cessadj, @a := ( @a + b_enhc_tax ) - property_tax col3,
	@b := ( @b + b_cess ) - cess col4 from
	((SELECT LEFT( p_year,4) as newyear, p_year,b_enhc_tax, b_cess ,
	property_tax,
	cess,payment_date,rebate,p_total FROM prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}) 
	UNION ALL 
	(SELECT LEFT( p_year,4) as newyear, p_year,b_enhc_tax, b_cess ,property_tax,
	cess,payment_date,rebate,p_total FROM openingbalance WHERE {$whereStr} {$whereStr1} {$whereStr2}) 
	order by newyear ASC) tunion 	
	
	JOIN 
	( SELECT @a :=0,@b :=0 )t";

        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;
    }

}

if (!function_exists('obcbmiss')) {

    function obcbmiss($ward, $block, $door_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $sql = "select p_year,b_enhc_tax,b_cess,property_tax,cess,rebate, payment_date,p_total,( b_enhc_tax - property_tax )taxadj, 
	( b_cess - cess )cessadj, @a := ( @a + b_enhc_tax ) - property_tax col3, @b := ( @b + b_cess ) - cess col4 
	from ((SELECT LEFT(pd.p_year,4) as newyear, pd.p_year,SUM(bt.b_enhc_tax) as b_enhc_tax, SUM(bt.b_cess) as b_cess, p.property_tax,
	p.cess,p.payment_date,p.rebate,p.p_total FROM tbl_generalinfo tg LEFT JOIN prop_details pd ON tg.upi=pd.upi LEFT JOIN building_taxcal bt ON 
	pd.id=bt.prop_id LEFT JOIN payment_details p ON bt.prop_id=p.p_id WHERE  {$whereStr} {$whereStr1} {$whereStr2} GROUP BY pd.p_year ORDER BY pd.p_year ASC) 
	UNION ALL (SELECT LEFT( p_year,4) as newyear, p_year,b_enhc_tax, b_cess ,property_tax, cess,payment_date,rebate,p_total FROM openingbalance 
	WHERE {$whereStr} {$whereStr1} {$whereStr2} order by newyear ASC) order by newyear ASC) tunion JOIN ( SELECT @a :=0,@b :=0 )t";

        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;
    }

}



if (!function_exists('obcbfromdate')) {

    function obcbfromdate($ward, $block, $door_no, $fyear, $givenyear, $fromdate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year BETWEEN  '{$fyear}' AND '{$givenyear}'";
        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $sql = "select p_year,b_enhc_tax,b_cess,property_tax,cess,rebate, payment_date,p_total,( b_enhc_tax - property_tax )taxadj, ( b_cess - cess )cessadj, @a := ( @a + b_enhc_tax ) - property_tax col3,
	@b := ( @b + b_cess ) - cess col4 from
	((SELECT LEFT( p_year,4) as newyear, p_year,b_enhc_tax, b_cess ,
	property_tax,
	cess,payment_date,rebate,p_total FROM prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}) 
	UNION ALL 
	(SELECT LEFT( p_year,4) as newyear, p_year,b_enhc_tax, b_cess ,property_tax,
	cess,payment_date,rebate,p_total FROM openingbalance WHERE {$whereStr} {$whereStr1} {$whereStr2}) 
	order by newyear ASC) tunion 	
	
	JOIN 
	( SELECT @a :=0,@b :=0 )t";

        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;
    }

}



if (!function_exists('excess_pay')) {

    function excess_pay($door_no, $ward, $block) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT p_year,b_enhc_tax, property_tax,@a := ( @a + b_enhc_tax ) - property_tax col3,b_cess ,cess,@b := ( @b + b_cess ) - cess col4
FROM prop_detail
JOIN (

SELECT @a :=0,@b :=0
)t
WHERE p_ward =  '$ward'
AND p_block =  '$block'
AND door_no =  '$door_no' ORDER  BY p_year ASC";
        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;      
    }

}

if (!function_exists('getyear')) {

    function getyear($door_no, $ward, $block) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT p_year,b_enhc_tax, property_tax,b_cess ,cess,p_ward,p_block,door_no,payment_date,rebate,app_tax
FROM prop_detail
WHERE p_ward =  '$ward'
AND p_block =  '$block'
AND door_no =  '$door_no' ORDER  BY p_year ASC";
        $query = $ci->db->query($sql);
        $ql = $query->result();
        return $ql;       
    }
}


if (!function_exists('getvalue')) {
    function getvalue($max, $min, $p_type,$p_year) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT `amt` FROM `swm_cess` WHERE `min`=$max and max=$min and `p_type`='$p_type' and year='$p_year'";
        $query = $ci->db->query($sql);
        $ql = $query->result();
		if($ql)
		{
        return $ql[0]->amt;
		}
		else
		{
		return false;
		}
    }
}


if (!function_exists('display_datas')) {

    function display_datas($ward, $upi, $asstno, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();

        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "tg.p_ward = '{$ward}'";
        if ($upi != "")
            $whereArr[] = "tg.upi = '{$upi}'";
        if ($asstno != "")
            $whereArr[] = "tg.assmt_no = '{$asstno}'";
        if ($fromdate != "")
            $whereArr1[] = "pd.p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        $whereStr1 = '';
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $query = $ci->db->query("select p_year,b_enhc_tax,b_cess, COALESCE(property_tax,0) as property_tax ,COALESCE(cess,0) as cess,rebate, payment_date,p_total,( b_enhc_tax -COALESCE(property_tax,0) ) taxadj,(b_cess - COALESCE( cess, 0 )) cessadj, @a := ( @a + b_enhc_tax ) - COALESCE(property_tax,0) col3, @b := ( @b + b_cess ) - COALESCE(cess,0) col4 from (SELECT LEFT(pd.p_year,4) as newyear, pd.p_year,SUM(bt.b_enhc_tax) as b_enhc_tax, SUM(bt.b_cess) as b_cess, p.property_tax, p.cess,p.payment_date,p.rebate,p.p_total FROM tbl_generalinfo tg LEFT JOIN prop_details pd ON tg.upi=pd.upi LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
        WHERE {$whereStr} {$whereStr1} {$whereStr2} GROUP BY pd.p_year ORDER BY pd.p_year ASC) tunion JOIN ( SELECT @a :=0,@b :=0 )t");

        return $query->result();
    }

}


if (!function_exists('display_datas1')) {

    function display_datas1($ward, $block, $door_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();

        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        $whereStr1 = '';
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $query = $ci->db->query("Select LEFT( p_year,4) as newyear, p_year,b_enhc_tax, 
	property_tax,b_cess ,
	cess,payment_date,rebate,app_tax from prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}  and p_year!='' GROUP BY p_year  ORDER BY newyear ASC");

        return $query->result();
    }

}


if (!function_exists('maxminyear')) {

    function maxminyear($ward, $block, $door_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        $whereArr1 = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$beforedate}','{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $query = $ci->db->query("Select max(p_year) as maxyear,min(p_year) as minyear from prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}");

        return $query->result();
    }

}
if (!function_exists('maxmintoyear')) {

    function maxmintoyear($ward, $block, $door_no, $beforedate, $fromdate, $between, $todate) {
        $ci = & get_instance();
        $ci->load->database();
        $whereArr = array();
        if ($ward != "")
            $whereArr[] = "p_ward = '{$ward}'";
        if ($block != "")
            $whereArr[] = "p_block = '{$block}'";
        if ($door_no != "")
            $whereArr[] = "door_no = '{$door_no}'";
        if ($fromdate != "")
            $whereArr1[] = "p_year IN ('{$fromdate}','{$between}','{$todate}')";

        $whereStr = implode(" AND ", $whereArr);
        $whereStr1 = implode(" AND ", $whereArr1);
        $whereStr2 = implode(" order by p_year ASC", $whereArr1);
        if ($whereStr && $whereStr2) {
            $whereStr1 = 'AND';
        }
        $query = $ci->db->query("Select count(*) as count from prop_detail WHERE {$whereStr} {$whereStr1} {$whereStr2}");
        return $query->result();
    }

}

if (!function_exists('insertobcb1')) {

    function insertobcb1($result, $door_no, $p_ward, $p_block, $missyear) {
        $ci = & get_instance();
        $ci->load->database();
		$sql1 = "Select * from openingbalance  WHERE p_ward='$p_ward' and p_block='$p_block' and door_no = '$door_no' and p_year='$missyear'";
        $query1 = $ci->db->query($sql1);
        if (!$query1->result()) {
            $sql = "INSERT INTO openingbalance
 (p_year, b_enhc_tax, b_cess, property_tax, cess,p_ward,p_block,door_no,payment_date,rebate) values ";

            $valuesArr = array();
            foreach ($result as $row) {

                $p_year = trim($row['p_year']);
                $b_enhc_tax = trim($row['b_enhc_tax']);
                $b_cess = trim($row['b_cess']);
                $property_tax = trim($row['property_tax']);
                $cess = trim($row['cess']);
                $p_ward = trim($row['p_ward']);
                $p_block = trim($row['p_block']);
                $door_no = trim($row['door_no']);
                $payment_date = trim($row['payment_date']);
                $rebate = trim($row['rebate']);
                $valuesArr[] = "('$p_year', '$b_enhc_tax', '$b_cess','$property_tax','$cess','$p_ward','$p_block','$door_no','$payment_date','$rebate')";
            }

            $sql .= implode(',', $valuesArr);

            $query = $ci->db->query($sql);
        }
    }

}

if (!function_exists('insertobcb')) {

    function insertobcb($result,$upi,$missyear) {
        $ci = & get_instance();
        $ci->load->database();
		$sql1 = "Select upi from openingbalance  WHERE  upi='$upi' and p_year='$missyear'";
        $query1 = $ci->db->query($sql1);
        if (!$query1->result()) {
         $ci->db->insert('openingbalance', $result);
           
        }
    }
	}

if (!function_exists('get_cess')) {

    function get_cess($year) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT cess_amt FROM cess WHERE `cess_id`='" . $year . "'");
        $ql = $query->result();
		if($ql)
		{
        return $ql[0]->cess_amt;
		}
		else
		{
		return false;
		}
    }

}

if (!function_exists('getpname')) {
    function getpname($upi) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT p_name FROM tbl_generalinfo WHERE `upi`='" . $upi . "'");
        $ql = $query->result();
		if($ql)
		{
        return $ql[0]->p_name;
		}
		else
		{
		return false;
		}  
    }
}

if (!function_exists('getvillage')) {
    function getvillage($upi) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT village FROM tbl_generalinfo WHERE `upi`='" . $upi . "'");
        $ql = $query->result();
		if($ql)
		{
        return $ql[0]->village;
		}
		else
		{
		return false;
		}      
    }
}

if (!function_exists('getassmt_no')) {

    function getassmt_no($upi) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT assmt_no FROM tbl_generalinfo WHERE `upi`='" . $upi . "'");
        $ql = $query->result();    
		if($ql)
		{
        return $ql[0]->assmt_no;
		}
		else
		{
		return false;
		} 
    }
}

if (!function_exists('getyears')) {
    function getyears($upi) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT p_year FROM openingbalance WHERE `upi`='" . $upi . "' ORDER BY p_year ASC");
        $ql = $query->result_array();
        return $ql;
    }
}

if (!function_exists('getbalance')) {
    function getbalance($upi) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT sum(`b_enhc_tax`)+sum(`b_cess`) as total FROM `openingbalance` WHERE `upi`='" . $upi . "'");
        $ql = $query->result_array();
        return $ql;
    }
}

if (!function_exists('sidedefault_data')) {
    function sidedefault_data($ward) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->query("SELECT *
			FROM  openingbalance WHERE  p_ward = '".$ward."' GROUP BY upi");
        $ql = $query->result_array();
        return $ql;
    }

}
/**
      # Function :	get_max_payment_year
      # Purpose  :	get max of payment year
      # Return   :	Array
     */
    if (!function_exists('get_max_payment_year')) {

    function get_max_payment_year($upi) {
        $ci = & get_instance();
        $ci->load->database();

        $query = $ci->db->query("SELECT tax_applicablefrom as minpyear FROM `prop_details` WHERE `upi`='" . $upi . "'");
       
        $ql = $query->result();
        return $ql[0]->minpyear;
    }
	}
	
	/**
      # Function :	get_max_payment_year
      # Purpose  :	get max of payment year
      # Return   :	Array
     */
    if (!function_exists('check_logs')) {

    function check_logs($username) {
        $ci = & get_instance();
        $ci->load->database();
            $checklogs = $ci->db->get_where('user_logtime', array('username =' => $username))->num_rows();
			return $checklogs;
    }
	}

?>
