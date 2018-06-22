<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Sasdetail Controller
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
class Sasdetails extends CI_Controller
{

    /**
      # Function     :    __construct
      # Purpose      :    Class constructor
      # params     :    None
      # Return     :    None
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('sasdetails_model', 'sasdetails');
        $this->load->model('payment_model', 'payment_model');
        $this->load->model('guidance_model', 'guidance');
        $this->load->model('ward_model', 'wards');
        $this->load->model('proptype_model', 'proptype', TRUE);
        $this->load->model('enhance_model', 'enhance', TRUE);
        $this->load->model('sasinfo_model', '', TRUE);
        $this->load->model('depreciation_model', 'depreciation', TRUE);
        //load form validation
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    /**
      # Function     :    index
      # Purpose      :    Initial settings
      # params     :    None
      # Return     :    None
     */
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['ward'] = $this->wards->display_ward();
            $data['proptype'] = $this->proptype->display_proptype();
            $data['enhance'] = $this->enhance->display_enhance();
            $data['depreciation'] = $this->depreciation->display_depreciation();
            $data['penalty'] = $this->sasdetails->display_penalty();
            $this->load->view('sasdetails_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    property
      # Purpose      :    check property info
      # params     :    None
      # Return     :    None
     */
    public function property()
    {
        $this->form_validation->set_rules('area_ratio', 'Area ratio or undivided right', 'trim|callback_arearatioVerify');
        $this->form_validation->set_rules('value_cents', 'Guidance Value of Land in Cents', 'required');
        $this->form_validation->set_rules('p_year', 'Payment Year', 'required|callback_year_check');
        $this->form_validation->set_rules('tax_applicablefrom', 'Tax Applicable From', 'required|callback_applicablefrom_check');
        $this->form_validation->set_rules('p_use', 'Property Use', 'required|callback_use_check');
        $this->form_validation->set_rules('area_build', 'Area of Land occupied by Building', 'trim|callback_areabuildVerify');
        $this->form_validation->set_rules('area_cents', 'Total area of Land in Cents', 'trim|callback_areaVerify');
        $this->form_validation->set_rules('upi', 'UPI', 'required|callback_upi_check');
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('st' => 0, 'msg' => json_encode($errors)));
            exit();
        } else {
            return false;
        }
    }

    /**
      # Function     :    building
      # Purpose      :    check building info
      # params     :    None
      # Return     :    None
     */
    public function building()
    {
        $cnt = trim($this->input->post('count'));
        for($i=1;$i<=$cnt;$i++){        
        $this->form_validation->set_rules('b_area_sqft_' . $i, 'Building area in Sq.Ft', 'required');
        $this->form_validation->set_rules('b_value_sqft_' . $i, 'Building value per Sq.Ft', 'required');        
        $this->form_validation->set_rules('floor_' . $i, 'Floor', 'required');
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 0, 'msg' => json_encode($errors)));
            exit();
        }
        }
        $this->form_validation->set_rules('build_type_' . $cnt, 'Own (0.5) / Rented or Commercial', 'required|callback_check_buildall');
        $this->form_validation->set_rules('age_build_' . $cnt, 'Age of building', 'required|callback_check_age_buildall'); 
        $this->form_validation->set_rules('c_year_' . $cnt, 'Construction Year', 'callback_check_c_yearall');
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 0, 'msg' => json_encode($errors)));
            exit();
        }else {
            echo json_encode(array('status' => true, 'msg' => 'Success'));
            exit();
        }
        
        
    }

    /**
      # Function     :    get_enhance
      # Purpose      :    get_enhance from master
      # params     :    None
      # Return     :    None
     */
    public function get_enhance()
    {
        $year = $this->input->POST('p_year');
        $sql = "SELECT cess.cess_amt as cess_amt, enhance.e_rate as enhance_rate FROM cess, enhance WHERE cess.cess_id = '" . $year . "' and  enhance.e_year = '" . $year . "' ";
        $query = $this->db->query($sql);
        $upi = trim($this->input->post('upi'));
        $p_year = trim($this->input->post('p_year'));
        $pending = '0';
        $payments_pending = array();
        $finalarray = array();
        $a_year = substr($p_year, 0, 4);
        $check_year = trim($this->input->post('tax_applicablefrom'));
        $taxApplicableFromStartYear = substr($check_year, 0, 4);        
        $result_user = $this->sasdetails->check_payed_user($upi, $p_year);
        if ($result_user) {
            echo json_encode(array('st' => 'payed', 'msg' => 'SAS Calculation is already done for ' . $p_year));
            exit();            
        }
        if($a_year < $taxApplicableFromStartYear) {
            echo json_encode(array('st' => 'invalid', 'msg' => 'Tax is not Applicable before Completion Year'));
            exit();
        }
        if ($a_year != $taxApplicableFromStartYear) {
            $pending_result = $this->sasdetails->check_not_payed_user($upi, $p_year);
            for ($chk_first_year = (substr($check_year, 0, 4)); $chk_first_year < $a_year; $chk_first_year++) {
                $pending = 0;
                $chk_second_year = sprintf("%02d", (substr($chk_first_year, 2, 2) + 1));
                $year_to_check = $chk_first_year . '-' . $chk_second_year;
                foreach ($pending_result as $result) {
                    $payment_year = $result['p_year'];
                    if ($year_to_check == $payment_year) {
                        $pending = 1;
                    }
                }
                if ($pending != 1) {
                    array_push($finalarray, $year_to_check);
                }
            }
            if (sizeof($finalarray) >= 1) {
                echo json_encode(array('st' => 'notpayed', 'msg' => $finalarray));
                exit();
            } else if ($query->num_rows() == 1) {
                $records_array = $query->result();
                foreach ($records_array as $record) {
                    echo json_encode(array('st' => 0, 'e_rate' => json_encode($record->enhance_rate), 'cess' => json_encode($record->cess_amt)));
                }
                exit();
            } else {
                return false;
            }
        } else if ($query->num_rows() == 1) {
            $records_array = $query->result();
            foreach ($records_array as $record) {
                echo json_encode(array('st' => 0, 'e_rate' => json_encode($record->enhance_rate), 'cess' => json_encode($record->cess_amt)));
            }
            exit();
        } else {
            return false;
        }
    }

    /**
      # Function     :    get_deprcn
      # Purpose      :    get_deprcn from master
      # params     :    None
      # Return     :    None
     */
    public function get_deprcn()
    {
        $age_build = $this->input->POST('age_build');
        $this->db->select('dep');
        $this->db->from('depreciaton');
        $this->db->where('b_age', $age_build);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $records_array = $query->result();
            foreach ($records_array as $deprcn) {
                echo json_encode(array('rate' => json_encode($deprcn->dep)));
            }
            exit();
        } else {
            return false;
        }
    }

    /**
      # Function     :    get_penalty
      # Purpose      :    get_penalty from master
      # params     :    None
      # Return     :    None
     */
    public function get_penalty()
    {
        $payment_date = trim($this->input->post('payment_date'));
        $p_year = trim($this->input->post('p_year'));
        $p_year = substr($p_year, 0, 4);
        //payment year
        $c_year = $p_year;
        $p_year = $p_year + 1;
        $month = date("m", strtotime($payment_date));
        $r_month = 0;
        $year = date("Y", strtotime($payment_date));
        $current_year = date("Y");
        if ($c_year == $year) {
            $month = date("m", strtotime($payment_date));
            $r_month = $month;
            $month = $month - 6;
        } else if ($p_year == $year) {
            $month = date("m", strtotime($payment_date));
            $month = $month + 6;
        } else if ($year != $current_year) {
            $p_year = $p_year - 1;
            $month = 0;
            for ($i = $p_year; $i < $year; $i++) {
                $month = $month + 10 + 2;
            }
        } else {
            $month = 0;
            $p_year = $p_year - 1;
            for ($i = $p_year; $i < $current_year; $i++) {
                $month = $month + 10 + 2;
            }
            $month = $month - 2;
        }
        echo json_encode(array('month' => json_encode($month), 'r_month' => json_encode($r_month)));
    }

    /**
      # Function     :    check_doorno
      # Purpose      :    check_doorno from table
      # params     :    None
      # Return     :    None
     */
    public function check_doorno()
    {
        if ($this->input->post('payer_id') == 1) {
            return TRUE;
        }
        $door = $this->input->post('door_no');
        if (preg_match('/^[a-zA-Z0-9-,\/\(\)\s]*$/', $door)) {
            $p_ward = $this->input->post('p_ward');
            $wardname = explode(',',$p_ward);
            $wardno = $wardname[1];
            $p_block = $this->input->post('p_block');
            $door_no = trim($this->input->post('door_no'));
            //query the database
            $result = $this->sasdetails->check_doorno($wardno, $p_block, $door_no);
            if ($result) {
                $this->form_validation->set_message('check_doorno', '<a href="#" id="payer" onclick="return payer_yes()">This payer already exist. Click here to add new SAS entry for existing payer</a>');
                return false;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_doorno', 'Invalid Door Number');
            return FALSE;
        }
        //Field validation succeeded.  Validate against database
    }

    /**
      # Function     :    check_payed_user
      # Purpose      :    check_payed_user from table
      # params     :    None
      # Return     :    None
     */
    public function check_payed_user()
    {
        //Field validation succeeded.  Validate against database
        $p_ward = $this->input->post('p_ward');
        $p_block = $this->input->post('p_block');
        $door_no = trim($this->input->post('door_no'));
        $p_year = trim($this->input->post('p_year'));
        $floor = trim($this->input->post('floor'));
        $pending = '';
        $a_year = substr($p_year, 0, 4);
        $result = $this->sasdetails->check_payed_user($p_ward, $p_block, $door_no, $p_year, $floor);
        if ($result) {
            $this->form_validation->set_message('check_payed_user', 'Payment is already done for ' . $p_year);
            return false;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    check_not_payed_user
      # Purpose      :    check_not_payed_user from table
      # params     :    None
      # Return     :    None
     */
    public function check_not_payed_user()
    {
        $upi = trim($this->input->post('upi'));
        $p_year = trim($this->input->post('p_year'));
        $floor = trim($this->input->post('floor_1'));
        $pending = '0';
        $payments_pending = array();
        $a_year = substr($p_year, 0, 4);
        $result_user = $this->sasdetails->check_payed_user($upi, $p_year, $floor);
        $pending_result = $this->sasdetails->check_not_payed_user($upi, $p_year, $floor);
        if ($pending_result) {
            foreach ($pending_result as $result) {
                $payment_year = $result['p_year'];
                $payment_year = substr($payment_year, 0, 4);
                $payment_year = $payment_year + 1;
                if ($a_year != $payment_year) {
                    $pending = 1;
                    array_push($payments_pending, $result['p_year']);
                }
            }
        }
        if ($result_user) {
            $this->form_validation->set_message('check_not_payed_user', 'Payment is already done for ' . $p_year);
            return false;
        } else if ($pending == 1) {
            foreach ($payments_pending as $pendingyear) {
                $this->form_validation->set_message('check_not_payed_user', 'Payment is not done after ' . $pendingyear . ' year.');
                return false;
            }
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    edit_pay
      # Purpose      :    edit_pay redirect to payment edit page
      # params     :    None
      # Return     :    None
     */
    public function view_sas()
    {
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $pid = $this->input->POST('pid');
            $bid = $this->input->POST('bid');
            $result = $this->sasdetails->get_sasdetail($pid, $bid);
            $data['records'] = $result;
            echo $this->load->view('sas_viewdetails', $data, TRUE);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    check_payer
      # Purpose      :    check for existing payer
      # params     :    None
      # Return     :    None
     */
    public function check_payer()
    {
        $data = array();
        $p_ward = $this->input->post('p_ward');
        $p_block = $this->input->post('p_block');
        $door_no = $this->input->post('door_no');
        $upi = $p_ward . '-' . $p_block . '-' . $door_no;
        $data['upi'] = $upi;
        $result = $this->sasdetails->display_payerdetails($upi);
        if ($result) {
            $data['area_cents'] = $result['area_cents'];
            $data['area_sqft'] = $result['area_sqft'];
            $data['area_build'] = $result['area_build'];
            $data['area_floors'] = $result['area_floors'];
            $data['area_ratio'] = $result['area_ratio'];
            $data['undiv_right'] = $result['undiv_right'];
            $data['p_use'] = $result['p_use'];
            $data['tax_rate'] = $result['tax_rate'];
           // $data['value_cents'] = $result['value_cents'];
           // $data['value_sqft'] = $result['value_sqft'];
            $data['value_corn'] = $result['value_corn'];
            $data['value_total'] = $result['value_total'];
            $data['guide_50'] = $result['guide_50'];
        }
        $userifo = $this->session->userdata('logged_in');
        $data['role'] = $this->session->userdata('role');
        $data['username'] = $userifo['username'];
        $data['ward'] = $this->wards->display_ward();
        $data['proptype'] = $this->proptype->display_proptype();
        $data['enhance'] = $this->enhance->display_enhance();
        $data['depreciation'] = $this->depreciation->display_depreciation();
        $this->load->view('sasdetails_buildingtaxinfo', $data);
    }

    /**
      # Function 	:	check_upi
      # Purpose  	:	Check whether UPI already exists
      # params 	:	None
      # Return 	:	response in json format
     */
    function check_upi()
    {
        $count = 0;
        $upi = $this->input->post('upi');
        $upiresult = $this->sasdetails->checkupi($upi);
        if ($upiresult) {
            $res = $this->sasdetails->display_payerdetails($upi);
            if ($res) {
                $result = $this->sasdetails->display_buildtaxdetails($res['id']);
                $s_array = array();
                foreach ($result as $row) {
                    $count++;
                    $s_array[] = array(
                        'floor' => $row['floor'],
                        'c_year' => $row['c_year'],
                        'tax_applicable_floor' => $row['tax_applicable_floor'],
                       // 'age_build' => $row['age_build'],
                       // 'depreciation_rate' => $row['depreciation_rate'],
                        'b_value_sqft' => $row['b_value_sqft'],
                        'type_const' => $row['type_const'],
                        'b_guide_50' => $row['b_guide_50'],
                        'b_area_sqft' => $row['b_area_sqft'],
                        'build_type' => $row['build_type']
                        //'land_tax_value' => $row['land_tax_value'],
                        //'build_tax_value' => $row['build_tax_value'],
                        //'app_tax' => $row['app_tax'],
                       // 'b_enhc_tax' => $row['b_enhc_tax'],
                        //'b_cess' => $row['b_cess'],
                       // 'b_tot_tax' => $row['b_tot_tax']
                    );
                }
                $response = array(
                    'st' => 1,
                    'bld' => $s_array,
                    'bldcount' => $count,
                    'prop' => $res
                );
                echo json_encode($response);
            } 
            else {
           //     $guideval = $this->guidance->get_guidevalue($upiresult['n_road']);
                echo json_encode(array(
                    'st' => 0,
                    'upi' => $upi
            //        'gval' => $guideval['gval_cents']
                ));
            }
        } else {
            echo json_encode(array(
                'upistatus' => 0,
                'upi' => $upi
            ));
        }
    }

    /**
      # Function     :    ward_check
      # Purpose      :    ward_check select
      # params     :    None
      # Return     :    None
     */
    public function ward_check()
    {
        if ($this->input->post('p_ward') === '0') {
            $this->form_validation->set_message('ward_check', 'Please select ward.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    nroad_check
      # Purpose      :    validation for name of road
      # params     :    None
      # Return     :    status
     */
    public function nroad_check()
    {
        if ($this->input->post('n_road') === '0') {
            $this->form_validation->set_message('nroad_check', 'Please select Name of Road.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    year_check
      # Purpose      :    Payment year check select
      # params     :    None
      # Return     :    status
     */
    public function year_check()
    {
        if ($this->input->post('p_year') === '0') {
            $this->form_validation->set_message('year_check', 'Please select payment year.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    
    /**
      # Function     :    applicablefrom_check
      # Purpose      :    Check applicable from year
      # params     :    None
      # Return     :    status
     */
    public function applicablefrom_check()
    {
        $tax_applicablefrom = $this->input->post('tax_applicablefrom');
        if($tax_applicablefrom === '0') {
            $this->form_validation->set_message('applicablefrom_check', 'Please enter Tax Applicable From year.');
            return FALSE;
        }else {
            return TRUE;
        }
    }
    /**
      # Function     :    upi_check
      # Purpose      :    check whether upi exists
      # params     :    None
      # Return     :    None
     */
    public function upi_check()
    {
        $upi = $this->input->post('upi');
        if ($upi != '') {
            $result = $this->sasdetails->checkupi($upi);
            if ($result) {
                return TRUE;
            } else {
                $this->form_validation->set_message('upi_check', 'UPI number doesnot exists.');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    assessment_check
      # Purpose      :    check whether Assessment number exists
      # params     :    None
      # Return     :    status
     */
    public function assessment_check()
    {
        $assessment_no = trim($this->input->post('assessment_no'));
        if ($assessment_no != '') {
            $result = $this->sasdetails->checkassessment($assessment_no);
            if ($result) {
                return TRUE;
            } else {
                $this->form_validation->set_message('assessment_check', 'Assessment Number doesnot exists.');
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    upiassessment_check
      # Purpose      :    check whether UPI or Assessment values are entered
      # params     :    None
      # Return     :    status
     */
    public function upiassessment_check()
    {
        $upi = $this->input->post('upi');
        $assement_no = $this->input->post('assessment_no');
        if ($upi == '' && $assement_no == '') {
            $this->form_validation->set_message('upiassessment_check', 'Please Enter Search Criteria.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    use_check
      # Purpose      :    use_check select
      # params     :    None
      # Return     :    None
     */
    public function use_check()
    {
        if ($this->input->post('p_use') === '0') {
            $this->form_validation->set_message('use_check', 'Please select use of property.');
            return FALSE;
        } 
        $upi = $this->input->post('upi');
        $checkdata = $this->sasdetails->getGeneralinfo($upi);   
        if ( $checkdata['ex_serviceman'] == '1' && $this->input->post('p_use')!='RES') {
                $this->form_validation->set_message('use_check', 'Property Type for ex-serviceman can be Residential only.');
                return FALSE;
        }
        if (($this->input->post('p_use') == 'NRS')) {            
            if ($checkdata['p_112C'] == '1' && ($this->input->post('stax_exempted') == '1')) {
                $this->form_validation->set_message('use_check', 'Cannot exempt this property.');
                return FALSE;
            }
        }
        return TRUE;
       
    }

    /**
      # Function     :    check_build
      # Purpose      :    check_build select
      # params     :    None
      # Return     :    None
     */
    public function check_build()
    {
        $cnt = trim($this->input->post('count'));
        if ($this->input->post('build_type_' . $cnt) === '0') {
            $this->form_validation->set_message('check_build', 'Plase select Own (0.5) / Rented or Commercial (1.0)');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
      # Function     :    check_build
      # Purpose      :    check_build select
      # params     :    None
      # Return     :    None
     */
    public function check_buildall()
    {
        $cnt = trim($this->input->post('count'));
        for($i=1;$i<=$cnt;$i++){        
        if ($this->input->post('build_type_' . $i) === '0') {
            $this->form_validation->set_message('check_buildall', 'Plase select Own (0.5) / Rented or Commercial (1.0)');
            return FALSE;
        }
        }
        return TRUE;        
    }

    /**
      # Function     :    check_age_build
      # Purpose      :    validation for building age
      # params     :    None
      # Return     :    None
     */
    public function check_age_build()
    {
        $cnt = trim($this->input->post('count'));
        if ($this->input->post('age_build_' . $cnt) === '') {
            $this->form_validation->set_message('check_age_build', 'Plase select Age of building');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
      # Function     :    check_age_build
      # Purpose      :    validation for building age
      # params     :    None
      # Return     :    None
     */
    public function check_age_buildall()
    {
        $cnt = trim($this->input->post('count'));
        for($i=1;$i<=$cnt;$i++){        
        if ($this->input->post('age_build_' . $i) === '') {
            $this->form_validation->set_message('check_age_buildall', 'Plase select Age of building');
            return FALSE;
        }
        }
        return TRUE;       
    }

    /**
      # Function     : check_c_year
      # Purpose      : validation for Constuction Year
      # params     :    None
      # Return     :    None
     */
    public function check_c_year()
    {
        $cnt = trim($this->input->post('count'));
        $cyear = $this->input->post('c_year_' . $cnt);
        $taxApplicableYear = $this->input->post('tax_applicablefrom');
        $current_year = date("Y");
        if ($cyear == '') {
            return TRUE;
        } 
        if (preg_match("/^[\d]{4}-[\d]{2}$/", $cyear)) {
           if ($cyear >= $current_year+1 ) {
                $this->form_validation->set_message('check_c_year', 'Invalid Construction Year');
                return FALSE;
            }elseif ($cyear > $taxApplicableYear) {          
                $this->form_validation->set_message('check_c_year', 'Construction Year cannot be greater than Tax Applicable Year');
                return FALSE;           
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_c_year', 'Invalid Construction Year');
            return FALSE;
        }        
        
    }
    
    /**
      # Function     : check_c_year
      # Purpose      : validation for Constuction Year
      # params     :    None
      # Return     :    None
     */
    public function check_c_yearall()
    {
        $cnt = trim($this->input->post('count'));        
        $current_year = date("Y");
        if($cnt == '1'){
            $taxApplicableYear = $this->input->post('tax_applicablefrom');
           // for($i=1;$i<=$cnt;$i++){        
            $cyear = $this->input->post('c_year_' . $cnt);
            $olddata = trim($this->input->post('olddata_' .$cnt));
            if ($cyear != '' && $olddata != '1') {
                if (preg_match("/^[\d]{4}-[\d]{2}$/", $cyear)) {
                    if ($cyear >= $current_year+1 ) {
                         $this->form_validation->set_message('check_c_yearall', 'Invalid Construction Year for Floor '.$cnt);
                         return FALSE;
                    }elseif ($cyear > $taxApplicableYear) {          
                         $this->form_validation->set_message('check_c_yearall', 'Construction Year cannot be greater than Tax Applicable Year for Floor '.$cnt);
                         return FALSE;           
                    }
                }else {
                    $this->form_validation->set_message('check_c_yearall', 'Invalid Construction Year for Floor '.$cnt);
                    return FALSE;
                }     
           // } 
        }
        return TRUE;
            
        }else{
            //$taxApplicableYear = $this->input->post('tax_applicablefrom');
            for($i=2;$i<=$cnt;$i++){    
            $olddata = trim($this->input->post('olddata_' .$i));
            $cyear = $this->input->post('c_year_' . $i);
            $taxApplicableYear = $this->input->post('tax_fromyear_' .$i);
            $paymentYear = $this->input->post('p_year');
            if ($cyear != '' && $olddata != '1') {
                if (preg_match("/^[\d]{4}-[\d]{2}$/", $cyear)) {
                    if ($cyear >= $current_year+1 ) {
                         $this->form_validation->set_message('check_c_yearall', 'Invalid Construction Year for Floor'.$i);
                         return FALSE;
                    }elseif ($cyear > $taxApplicableYear) {          
                         $this->form_validation->set_message('check_c_yearall', 'Construction Year cannot be greater than Tax Applicable Year for Floor'.$i);
                         return FALSE;           
                    }elseif ($taxApplicableYear > $paymentYear) {          
                         $this->form_validation->set_message('check_c_yearall', 'Tax Applicable From year cannot be greater than Payment Year for Floor'.$i);
                         return FALSE;           
                    }
                }else {
                    $this->form_validation->set_message('check_c_yearall', 'Invalid Construction Year for Floor'.$i);
                    return FALSE;
                }     
            } 
        }
        return TRUE;
            
        }
        
    }

    /**
      # Function     : check_pname
      # Purpose      : validation for Owner name
      # params     :    None
      # Return     :    None
     */
    public function check_pname()
    {
        $pname = $this->input->post('p_name');
        if (preg_match('/^[a-zA-Z\s]+$/', $pname)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_pname', 'Invalid Owner Name');
            return FALSE;
        }
    }

    /**
      # Function     : village_check
      # Purpose      : validation for Village name
      # params     :    None
      # Return     :    None
     */
    public function village_check()
    {
        $village = $this->input->post('village');
        if (preg_match('/^[a-zA-Z0-9\-\/\s\']*$/', $village)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('village_check', 'Invalid Village Name');
            return FALSE;
        }
    }

    /**
      # Function     : check_serviceman
      # Purpose      : validation for Ex serviceman
      # params     :    None
      # Return     :    None
     */
    public function check_serviceman()
    {
        if (($this->input->post('ex_serviceman') === '1') && ($this->input->post('p_112C') === '1')) {
            $this->form_validation->set_message('check_serviceman', 'Both Ex-Serviceman and Penalty-112c cannot be True together');
            return FALSE;
        } elseif (($this->input->post('ex_serviceman') === '1') && ($this->input->post('ref_no') === '')) {
            $this->form_validation->set_message('check_serviceman', 'Reference Number is required');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    areaVerify
      # Purpose      :    check area of Land in Cents or Occupied by Building
      # params     :    None
      # Return     :    None
     */
    public function areaVerify()
    {
        if ($this->input->post('area_cents') === '') {
            $this->form_validation->set_message('areaVerify', 'Total area of Land in Cents is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    areaVerify
      # Purpose      :    check area of Land in Cents or Occupied by Building
      # params     :    None
      # Return     :    None
     */
    public function areabuildVerify()
    {
        if ($this->input->post('area_build') === '') {
            $this->form_validation->set_message('areabuildVerify', 'Area of Land occupied by Building is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
      # Function     :    arearatioVerify
      # Purpose      :    check area ratio / undivided right
      # params     :    None
      # Return     :    None
     */
    public function arearatioVerify()
    {
        if ($this->input->post('area_ratio') === '' && $this->input->post('undiv_right') === '') {
            $this->form_validation->set_message('arearatioVerify', 'Either Area ratio / undivided right or Undivided right as per Sale Deed or Schedule is required.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * To show the general information page 
     *
     * retrieves user and ward information
     *
     * redirects to general info view page
     */
    public function generalInfo()
    {
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['ward'] = $this->wards->display_ward();
           // $data['roadnames'] = $this->guidance->get_roadname();
            $this->load->view('sasdetails_generalinfo', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
     * To show the Building/Tax calculation page 
     *
     * retrieves all necessary info
     *
     * redirects to building tax calculation view page
     */
    public function buildingtaxcalInfo()
    {
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
          //  $data['ward'] = $this->wards->display_ward();
            $data['proptype'] = $this->proptype->display_proptype();
            $data['enhance'] = $this->enhance->display_enhance();
            $data['depreciation'] = $this->depreciation->display_depreciation();
            $this->load->view('sasdetails_buildingtaxinfo', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
     * To save tha general info 
     *
     * validates the user input against rules.
     * Redirects with error message if validation fails.
     *
     * saves information to database and return status as true
     */
    public function savegeneralInfo()
    {
       // $ward = substr($p_ward, strpos($p_ward, ",") + 1);
        if ($this->session->userdata('logged_in')) {
            $this->form_validation->set_rules('village', 'Village', 'callback_village_check');
            $this->form_validation->set_rules('p_name', 'Name', 'trim|required');
            $this->form_validation->set_rules('ex_serviceman', 'EX Servicemen', 'trim|callback_check_serviceman');
            $this->form_validation->set_rules('door_no', 'Door No', 'trim|required|callback_check_doorno');
            $this->form_validation->set_rules('p_block', 'Block', 'trim|required|numeric');
            $this->form_validation->set_rules('p_ward', 'Ward', 'required|callback_ward_check');
            $this->form_validation->set_rules('aadhar_num', 'Aadhar Number', 'numeric|min_length[12]|max_length[12]');
            $this->form_validation->set_rules('contact_num', 'Contact', 'numeric|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('n_road', 'Name of Road', 'required|callback_nroad_check');
            $this->form_validation->set_rules('assmt_no', 'Assesment No', 'numeric');
            if ($this->form_validation->run() == FALSE) {
                //function in library : My_Form_validation 
                $errors = $this->form_validation->error_array();
                echo json_encode(array('status' => false, 'msg' => json_encode($errors)));
                exit();
            } else {
                $p_ward = $this->input->post('p_ward');
                $wardname = explode(',',$p_ward);                
                $info = array();
                $info['p_name'] = trim($this->input->post('p_name'));
                $info['o_name'] = trim($this->input->post('o_name'));
                $info['n_road'] = trim($this->input->post('n_road'));
                $info['contact_no'] = trim($this->input->post('contact_num'));
                $info['aadhar_no'] = trim($this->input->post('aadhar_num'));
                $info['assmt_no'] = trim($this->input->post('assmt_no'));
                $info['p_ward'] = $wardname[1];
                $info['p_block'] = trim($this->input->post('p_block'));
                $info['p_112C'] = trim($this->input->post('p_112C'));
                $info['ex_serviceman'] = trim($this->input->post('ex_serviceman'));
                $info['ref_no'] = trim($this->input->post('ref_no'));
                $info['door_no'] = trim($this->input->post('door_no'));
                $info['village'] = trim($this->input->post('village'));
                $info['survey_no'] = trim($this->input->post('survey_no'));
                $info['upi'] = $wardname[1] . "-" . trim($this->input->post('p_block')) . "-" . trim($this->input->post('door_no'));
               // $t = 'addinfostart';
              //  logQueryTime($t);
                $this->sasinfo_model->addgeneralInfo($info);
              //  $t = 'addinfoend';
               // logQueryTime($t);
                $str = "Added Owner info of " . $info['upi'];
                newUserlog($str);
                echo json_encode(array('status' => true, 'wardname' =>$wardname[1],  'msg' => 'Added Successfully'));
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
     * To save tha Building and SAS calculation info 
     *
     * validates the user input against rules.
     * Redirects with error message if validation fails.
     *
     * saves information to database and return status as true
     */
    public function savebldtaxInfo()
    {
        if ($this->session->userdata('logged_in')) {
		 $userifo = $this->session->userdata('logged_in');
            $username = $userifo['username'];
            $cnt = trim($this->input->post('count'));
            for($i=1;$i<=$cnt;$i++){        
            $this->form_validation->set_rules('b_area_sqft_' . $i, 'Building area in Sq.Ft', 'required');
            $this->form_validation->set_rules('b_value_sqft_' . $i, 'Building value per Sq.Ft', 'required');        
            $this->form_validation->set_rules('floor_' . $i, 'Floor', 'required');
            if ($this->form_validation->run() == FALSE) {
                $errors = $this->form_validation->error_array();
                echo json_encode(array('status' => 0, 'msg' => json_encode($errors)));
                exit();
            }
            }
            $this->form_validation->set_rules('build_type_' . $cnt, 'Own (0.5) / Rented or Commercial', 'required|callback_check_buildall');
            $this->form_validation->set_rules('age_build_' . $cnt, 'Age of building', 'required|callback_check_age_buildall'); 
            $this->form_validation->set_rules('c_year_' . $cnt, 'Construction Year', 'callback_check_c_yearall');
            if ($this->form_validation->run() == FALSE) {
                $errors = $this->form_validation->error_array();
                echo json_encode(array('status' => 0, 'msg' => json_encode($errors)));
                exit();
            }else {
                $info = array();
                $userDetail = $this->sasdetails->getGeneralinfo($this->input->post('upi'));
                $info['p_name'] = $userDetail['p_name'];
                $info['o_name'] = $userDetail['o_name'];
                $info['contact_no'] = $userDetail['contact_no'];
                $info['aadhar_no'] = $userDetail['aadhar_no'];
                
                $info['upi'] = trim($this->input->post('upi'));
                $info['area_cents'] = trim($this->input->post('area_cents'));
                $info['area_sqft'] = trim($this->input->post('area_sqft'));
                $info['area_build'] = trim($this->input->post('area_build'));
                $info['area_floors'] = trim($this->input->post('area_floors'));
                $info['area_ratio'] = trim($this->input->post('area_ratio'));
                $info['undiv_right'] = trim($this->input->post('undiv_right'));
                $info['p_use'] = trim($this->input->post('p_use'));                
                $info['stax_exempted'] = trim($this->input->post('stax_exempted'));
                $info['tax_applicablefrom'] = trim($this->input->post('tax_applicablefrom'));
                $info['tax_rate'] = trim($this->input->post('tax_rate'));
                $info['p_year'] = trim($this->input->post('p_year'));
                $info['enhancement_tax'] = trim($this->input->post('enhancement_tax'));
                $info['value_cents'] = trim($this->input->post('value_cents'));
                $info['value_sqft'] = trim($this->input->post('value_sqft'));
				
                $cornerval = trim($this->input->post('corner'));
                $info['is_corn'] = $cornerval;
                if ($cornerval == 0) {
                    $info['value_corn'] = '0';
                } else {
                    $info['value_corn'] = trim($this->input->post('value_corn'));
                }
                $info['value_total'] = trim($this->input->post('value_total'));
                $info['guide_50'] = trim($this->input->post('guide_50'));
		$info['created_by'] = $username;
                $proper_id = $this->sasinfo_model->addpropertyInfo($info);
                $cnt = trim($this->input->post('count'));
                for ($i = 1; $i <= $cnt; $i++) {
                    $data['prop_id'] = $proper_id;
                    $data['upi'] = trim($this->input->post('upi'));
                    $data['floor'] = trim($this->input->post('floor_' . $i));
                    $data['c_year'] = trim($this->input->post('c_year_' . $i));
                    if($this->input->post('tax_fromyear_' . $i)) {
                        $data['tax_applicable_floor'] = trim($this->input->post('tax_fromyear_' . $i));
                    } else {
                        $data['tax_applicable_floor'] = '';
                    }
                    $data['age_build'] = trim($this->input->post('age_build_' . $i));
                    $data['depreciation_rate'] = trim($this->input->post('depreciation_rate_' . $i));
                    $data['type_const'] = trim($this->input->post('type_const_' . $i));
                    $data['b_value_sqft'] = trim($this->input->post('b_value_sqft_' . $i));
                    $data['b_guide_50'] = trim($this->input->post('b_guide_50_' . $i));
                    $data['b_area_sqft'] = trim($this->input->post('b_area_sqft_' . $i));
                    $data['build_type'] = trim($this->input->post('build_type_' . $i));
                    $data['land_tax_value'] = trim($this->input->post('land_tax_value_' . $i));
                    $data['build_tax_value'] = trim($this->input->post('build_tax_value_' . $i));
                    $data['app_tax'] = trim($this->input->post('app_tax_' . $i));
                    $data['b_enhc_tax'] = trim($this->input->post('b_enhc_tax_' . $i));
                    $data['b_cess'] = trim($this->input->post('b_cess_' . $i));
                    $data['b_tot_tax'] = trim($this->input->post('b_tot_tax_' . $i));
                    $this->sasinfo_model->addbldtaxInfo($data);
                }
                $this->payment_model->checkopeningbalance($this->input->post('upi'), $this->input->post('p_year'));
                $str = "Added SAS detail of " . $data['upi'];
                newUserlog($str);
                echo json_encode(array('status' => true, 'msg' => 'Added Successfully'));
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
     * To edit the general info 
     *
     * validates the user input against rules.
     * Redirects with error message if validation fails.
     *
     * saves information to database and return status as true
     */
    public function editgeneralInfo()
    {
        $uri = $this->uri->segment(1, 0);
        //Load the pagination library
        $this->load->library('pagination');
        if ($this->session->userdata('logged_in')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            // $data['records'] = $this->sasdetails->getallGeneralinfo();
            $this->form_validation->set_rules('assessment_no', 'Assessment No', 'callback_assessment_check');
            $this->form_validation->set_rules('upi', 'UPI', 'callback_upiassessment_check|callback_upi_check');
            if ($this->form_validation->run($this)) {
                $upi = trim($this->input->post('upi'));
                $assement_no = $this->input->post('assessment_no');
                if ($upi != '') {
                    $condition['search'] = $upi;
                    $condition['search_by'] = 'upi';
                } elseif ($assement_no != '') {
                    $condition['search'] = $assement_no;
                    $condition['search_by'] = 'assmt_no';
                }
               // $data['ward'] = $this->wards->display_ward();
                //$data['roadnames'] = $this->guidance->get_roadname();
                $records = $this->sasdetails->get_generalinfo($condition);
                $checkward_roadname = $this->sasdetails->checkward_roadname($records['p_ward'],$records['n_road']);
                if($checkward_roadname) {
                   $data['checkward_roadname'] = 1;
                }else{
                    $data['checkward_roadname'] = 0;
                }
                $data['info'] = $records;
                $this->load->view('userinfoedit', $data);
            } else {
                $config['base_url'] = base_url() . '/sasdetails/editgeneralInfo/';
                if (isset($_GET['per_page'])) {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = $_GET['per_page'];
                } else {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = '';
                }
                $uri_segment = ($uri_segments == '' ? '0' : $uri_segments);
                $config['page_query_string'] = TRUE;
                $config['uri_segment'] = 3;
                $config['per_page'] = 10;
                $config['full_tag_open'] = '<ul class="pagination">';
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = FALSE;
                $config['last_link'] = FALSE;
                $config['next_link'] = 'Next';
                $config['next_tag_open'] = '<li class="curve_right">';
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = 'Prev';
                $config['prev_tag_open'] = '<li class="curve">';
                $config['prev_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li><a class="active">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $records_array_totrec = $this->sasdetails->getallGeneralinfo(0, 0, 1);
                $records_array = $this->sasdetails->getallGeneralinfo($uri_segment, $config['per_page'], 0);              
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $this->load->view('userinfo_edit', $data);
            }
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
     * To update the general info 
     *
     * validates the user input against rules.
     * Redirects with error message if validation fails.
     *
     * updates information to database and return status as true
     */
    public function updategeneralInfo()
    {
        $this->form_validation->set_rules('village', 'Village', 'callback_village_check');
        $this->form_validation->set_rules('p_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('door_no', 'Door No', 'trim|required');
        $this->form_validation->set_rules('p_block', 'Block', 'trim|required');
        $this->form_validation->set_rules('p_ward', 'Ward', 'required|callback_ward_check');
        $this->form_validation->set_rules('aadhar_num', 'Aadhar Number', 'numeric|min_length[12]|max_length[12]');
        $this->form_validation->set_rules('contact_num', 'Contact', 'numeric|min_length[10]|max_length[12]');
        $this->form_validation->set_rules('n_road', 'Name of Road', 'required|callback_nroad_check');
        $this->form_validation->set_rules('assmt_no', 'Assesment No', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            //function in library : My_Form_validation 
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => false, 'msg' => json_encode($errors)));
            exit();
        } else {
            $info = array();
            $id = trim($this->input->post('infoid'));
            $info['p_name'] = trim($this->input->post('p_name'));
            $info['o_name'] = trim($this->input->post('o_name'));
            $info['n_road'] = trim($this->input->post('n_road'));
            $info['contact_no'] = trim($this->input->post('contact_num'));
            $info['aadhar_no'] = trim($this->input->post('aadhar_num'));
            $info['assmt_no'] = trim($this->input->post('assmt_no'));
            $info['p_ward'] = trim($this->input->post('p_ward'));
            $info['p_block'] = trim($this->input->post('p_block'));
            $info['p_112C'] = trim($this->input->post('p_112C'));
            $info['ex_serviceman'] = trim($this->input->post('ex_serviceman'));
            $info['door_no'] = trim($this->input->post('door_no'));
            $info['village'] = trim($this->input->post('village'));
            $info['survey_no'] = trim($this->input->post('survey_no'));
            $info['upi'] = trim($this->input->post('p_ward')) . "-" . trim($this->input->post('p_block')) . "-" . trim($this->input->post('door_no'));
            $this->sasinfo_model->updategeneralInfo($info, $id);
            $str = "Updated Owner Info of " . $info['upi'];
            newUserlog($str);
            echo json_encode(array('status' => true, 'msg' => 'Added Successfully'));
        }
    }
    
    public function getRoadNames()
    {
        $wardid = $this->input->post('get_option');
        $data = $this->sasdetails->getRoadNames($wardid);
        $output = null;
        $output .= "<option value=''>select</option>";
        foreach ($data as $row)
         {
             $output .= "<option value='".$row->road_name."'>".$row->road_name."</option>";
         }

         echo $output;
    }
    
    public function getRoadNameList()
    {
        $wardname = $this->input->post('get_option');
        $data = $this->sasdetails->getRoadNameList($wardname);
        $output = null;
        $output .= "<option value=''>select</option>";
        foreach ($data as $row)
         {
             $output .= "<option value='".$row->road_name."'>".$row->road_name."</option>";
         }

         echo $output;
    }
    
    public function check_guidance()
    {
        $upi = $this->input->post('upi');
        $roadName = $this->guidance->get_road_name($upi); 
        $wardname = $this->guidance->get_ward_name($upi); 
        $propType = $this->input->post('prop_type');
        $guideval = $this->guidance->get_guidevalue($roadName,$propType,$wardname);
        echo json_encode(array(
            'st' => 1,
            'gval_commercial' => $guideval['gvalcents_commercial'],
            'gval_residential' => $guideval['gvalcents_residential']
        )); 
               
    }
    
    public function getConstructionNames()
    {
        $optionName = $this->input->post('get_option');
        $data = $this->sasdetails->getConstructionNames($optionName);
        $output = null;
        $output .= "<option value=''>SELECT</option>";
        foreach ($data as $row)
        {
            $output .= "<option value='".$row->c_type."'>".$row->c_type." -- ".$row->g_floor." / ".$row->u_floor."</option>";
        }
        echo $output;
    }

    public function getBuildingValue()
    {
        $c_rate = $this->input->post('c_rate');
        $c_type = $this->input->post('c_type');
        $floor = $this->input->post('floor');
        $data = $this->sasdetails->getBuildingValue($c_rate,$c_type,$floor);        
        echo $data;
    }
    
    public function getGuidanceValue()
    {
        $roadname = $this->input->post('roadname');
        $p_ward = $this->input->post('ward_no');
        $wardname = explode(',',$p_ward);
        $ward_no = $wardname[0];
        $data = $this->sasdetails->getGuidanceValue($roadname , $ward_no);        
        echo json_encode(array(            
            'commercial' => $data->gvalcents_commercial,
            'residential' => $data->gvalcents_residential
        ));  
    }
}