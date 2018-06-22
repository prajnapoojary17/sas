<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Property type Model
 *
 * Description : This is used to handle Property data 
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
class Payment_model extends CI_model {

    /**
      # Function 	:	__construct
      # Purpose  	:	Class constructor
      # params 	:	None
      # Return 	:	None
     */
    function __construct() {
        parent::__construct();
    }

    /**
      # Function :	get_payment_info_all_years
      # Purpose  :	get payment info for all assesment years
      # Return   :	Array
     */
    public function get_payment_info_all_years($info) {
        $query_str = "SELECT tg.upi,pd.p_name,tg.n_road,tg.assmt_no,tg.p_ward,tg.p_block,tg.door_no,tg.village,tg.survey_no,pd.id as propid ,pd.p_year,pd.is_verified,
			pd.tax_rate,SUM(bt.b_enhc_tax) as enhn_total,SUM(bt.b_cess) as cess_total,bt.floor,bt.service_tax,p.payment_date,p.property_tax,
			p.penalty_112C,p.service_tax,p.	ex_service_man,p.payable_total,p.cess,p.SWM_cess,p.adjustment,p.penalty,p.rebate,p.p_total,p.challan_no,p.name_bank,p.name_branch,
			p.payment_date,p.difference,p.remarks,p.is_payed
			FROM tbl_generalinfo tg 
			LEFT JOIN prop_details pd ON tg.upi=pd.upi 
			LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id 
			LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
			where tg.upi='" . $info . "' GROUP BY pd.p_year ORDER BY pd.p_year DESC";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	get_payment_upi_assmt
      # Purpose  :	get payment info based on upi and assesment number
      # Return   :	Array
     */
    public function get_payment_upi_assmt($upi, $assmt_no) {
        $query_str = "SELECT tg.upi,pd.p_name,tg.n_road,tg.assmt_no,tg.p_ward,tg.p_block,tg.door_no,tg.village,tg.survey_no,pd.id as propid ,pd.p_year,pd.is_verified,
			pd.tax_rate,SUM(bt.b_enhc_tax) as enhn_total,SUM(bt.b_cess) as cess_total,bt.floor,bt.service_tax,p.payment_date,p.property_tax,
			p.penalty_112C,p.service_tax,p.	ex_service_man,p.payable_total,p.cess,p.SWM_cess,p.adjustment,p.penalty,p.rebate,p.p_total,p.challan_no,p.name_bank,p.name_branch,
			p.payment_date,p.difference,p.remarks,p.is_payed
			FROM tbl_generalinfo tg 
			LEFT JOIN prop_details pd ON tg.upi=pd.upi 
			LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id 
			LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
			where tg.upi='" . $upi . "' and tg.assmt_no='" . $assmt_no . "' GROUP BY pd.p_year ORDER BY pd.p_year DESC";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	get_payedinfo
      # Purpose  :	get payment info based on property id
      # Return   :	Array
     */
    public function get_payment_info_all_years_assesment($assmt_no) {
        $query_str = "SELECT tg.upi,pd.p_name,tg.n_road,tg.assmt_no,tg.p_ward,tg.p_block,tg.door_no,tg.village,tg.survey_no,pd.id as propid ,pd.p_year,pd.is_verified,
			pd.tax_rate,SUM(bt.b_enhc_tax) as enhn_total,SUM(bt.b_cess) as cess_total,bt.floor,bt.service_tax,p.payment_date,p.property_tax,
			p.penalty_112C,p.service_tax,p.	ex_service_man,p.payable_total,p.cess,p.SWM_cess,p.adjustment,p.penalty,p.rebate,p.p_total,p.challan_no,p.name_bank,p.name_branch,
			p.payment_date,p.difference,p.remarks,p.is_payed
			FROM tbl_generalinfo tg 
			LEFT JOIN prop_details pd ON tg.upi=pd.upi 
			LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id 
			LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
			where  tg.assmt_no='" . $assmt_no . "' GROUP BY pd.p_year ORDER BY pd.p_year DESC";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    public function get_payedinfo($propId) {
        $query_str = "SELECT p.payment_date,p.property_tax,
			p.penalty_112C,p.service_tax,p.ex_service_man,p.payable_total,p.cess,p.SWM_cess,p.adjustment,p.penalty,p.rebate,p.p_total,p.challan_no,p.name_bank,p.name_branch,
			p.payment_date,p.difference,p.remarks,p.is_payed  FROM  payment_details p WHERE p.p_id='" . $propId . "'";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	get_payment_info_year
      # Purpose  :	get property detail of mutiple floors
      # Return   :	Array
     */
    public function get_payment_info_year($propId) {
        $query_str = "SELECT SUM(`b_cess`) as b_cess, SUM(`b_enhc_tax`) as b_enhc_tax,SUM(`service_tax`) as service_tax FROM `building_taxcal` WHERE `prop_id`='" . $propId . "'";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	print_data
      # Purpose  :	display data on pdf
      # Return   :	Array
     */
    public function print_data($propId, $upiId) {
        $query_str = "SELECT bt.prop_id, tg.upi,pd.p_name,tg.n_road,tg.assmt_no,tg.p_ward,tg.p_block,tg.door_no,tg.village,tg.survey_no,tg.ex_serviceman ,pd.id,pd.p_year,pd.tax_rate,bt.floor,
                    p.service_tax,p.ex_service_man,p.payable_total,p.payment_date, p.property_tax, p.penalty_112C, p.cess, p.SWM_cess, p.adjustment,p. penalty, p.rebate,p.p_total,p.challan_no,p.name_bank,
		p.name_branch,p.payment_date,p.difference,p.remarks,SUM(bt.b_enhc_tax),SUM(bt.b_cess) FROM (tbl_generalinfo tg,prop_details pd) 
		LEFT JOIN building_taxcal bt ON pd.id=bt.prop_id 
		LEFT JOIN payment_details p ON bt.prop_id=p.p_id 
		where pd.p_year=(SELECT p_year FROM prop_details where id='" . $propId . "') AND tg.upi='" . $upiId . "' And bt.prop_id='" . $propId . "'";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	get_build_area_property_type
      # Purpose  :	get building area and property type
      # Return   :	Array
     */
    public function get_build_area_property_type($propId) {
        $query_str = "SELECT area_build,p_use FROM prop_details WHERE `id`='" . $propId . "'";
        $query = $this->db->query($query_str);
        return $query->result();
    }

    /**
      # Function :	get_112c
      # Purpose  :	get p_112C status
      # Return   :	Array
     */
    public function get_112c($upi) {
        $query_str = "SELECT p_112C FROM tbl_generalinfo WHERE `upi`='" . $upi . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        if ($ql) {
            return $ql[0]->p_112C;
        } else {
            return false;
        }
    }

    /**
      # Function :	ex_serviceman
      # Purpose  :	get exserviceman status
      # Return   :	Array
     */
    public function ex_serviceman($upi) {
        $query_str = "SELECT ex_serviceman FROM tbl_generalinfo WHERE `upi`='" . $upi . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        if ($ql) {
            return $ql[0]->ex_serviceman;
        } else {
            return false;
        }
    }

    /**
      # Function :	get_cess
      # Purpose  :	get cess percentage based on year
      # Return   :	Array
     */
    public function get_cess($p_year) {
        $query_str = "SELECT cess_amt FROM cess WHERE `cess_id`='" . $p_year . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        if ($ql) {
            return $ql[0]->cess_amt;
        } else {
            return false;
        }
    }

    /**
      # Function :	stax_exempted
      # Purpose  :	get stax_exempted status
      # Return   :	Array
     */
    public function stax_exempted($id) {
        $query_str = "SELECT stax_exempted FROM  prop_details WHERE `id`='" . $id . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->stax_exempted;
    }

    /**
      # Function :	getassmt_no
      # Purpose  :	get upi based on assesment number
      # Return   :	Array
     */
    public function getassmt_no($assmt_no) {
        $query_str = "SELECT upi FROM tbl_generalinfo WHERE `assmt_no`='" . $assmt_no . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->upi;
    }

    /**
      # Function :	insertpayment
      # Purpose  :	Insert payment
      # Return   :	Array
     */
    public function insertpayment($data) {
        $this->db->insert('payment_details', $data);
    }

    /**
      # Function :	updatepayment
      # Purpose  :	Update payment
      # Return   :	Array
     */
    public function updatepayment($p_id, $data) {
        $this->db->where('p_id', $p_id);
        $this->db->update('payment_details', $data);
    }

    /**
      # Function :	checkpayment
      # Purpose  :	get payment info based on property id
      # Return   :	Array
     */
    public function checkpayment($propId) {
        $query_str = "SELECT * FROM payment_details WHERE `p_id`='" . $propId . "'";
        $query = $this->db->query($query_str);
        return $query->result_array();
    }

    /**
      # Function :	checkPreviousPayment
      # Purpose  :	get previous payment
      # Return   :	Array
     */
    public function checkPreviousPayment($propId, $prevYear) {
        $query_str = "SELECT count(*) as counts FROM `payment_details` WHERE `p_year`='" . $prevYear . "' and `p_id`='" . $propId . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->counts;
    }

    /**
      # Function :	get_max_payment_year
      # Purpose  :	get max of payment year
      # Return   :	Array
     */
    public function get_max_payment_year($upi) {
        $query_str = "SELECT min(`p_year`) as minpyear FROM `prop_details` WHERE `upi`='" . $upi . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->minpyear;
    }

    /**
      # Function :	getpropId
      # Purpose  :	get property id
      # Return   :	Array
     */
    public function getpropId($upi, $prevYear) {
        $query_str = "SELECT id FROM `prop_details` WHERE `upi`='" . $upi . "' and `p_year`='" . $prevYear . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->id;
    }

    /**
      # Function :	checkopeningbalance
      # Purpose  :	check the opening balance
      # Return   :	Array
     */
    public function checkopeningbalance($upi, $p_year) {
        $query_str = "SELECT * FROM `openingbalance` WHERE `upi`='" . $upi . "' and `p_year`='" . $p_year . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        if ($ql) {
            $this->db->where_in('upi', $upi)
                    ->where('p_year', $p_year)->delete('openingbalance');
        }
    }

    public function getmaxofidYear($p_year) {
        $query_str = "SELECT max(`challan_no`) as maxchallan FROM `payment_details` WHERE `year_of_payment`='" . $p_year . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        return $ql[0]->maxchallan;
    }

    public function tax_applicablefrom($upi) {
        $query_str = "SELECT tax_applicablefrom  FROM `prop_details` WHERE `upi`='" . $upi . "'";
        $query = $this->db->query($query_str);
        $ql = $query->result();
        if ($ql) {
            return $ql[0]->tax_applicablefrom;
        } else {
            return FALSE;
        }
    }
	 /**
      # Function 	:	check_not_payed_user
      # Purpose  	:	check_not_payed_user
      # params 	:
      # Return 	:	Array
     */
    public function check_not_payed_user($upi, $p_year)
    {
        $query_str = "SELECT payment_details.p_year FROM payment_details WHERE payment_details.upi = '" . $upi . "' AND payment_details.p_year < '" . $p_year . "' AND is_payed=1 ";
        $query = $this->db->query($query_str);
        $result = $query->result();
        return $query->result_array();
    }

	 /**
      # Function 	:	updateverification
      # Purpose  	:	updateverification
      # params 	:
      # Return 	:	Array
     */
    public function updateverification($id,$data)
    {
	$this->db->where('id', $id);
        $this->db->update('prop_details', $data);
	}
	
}
