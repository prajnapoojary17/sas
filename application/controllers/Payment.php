<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : payment Controller
 *
 * Description : This is used to handle Payment data
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
class Payment extends CI_Controller {

    /**
      # Function    :    __construct
      # Purpose     :    Class constructor
      # params      :    None
      # Return      :    None
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('payment_model', '', TRUE);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('user');
    }

    /**
      # Function    :    index
      # Purpose     :    Initial settings
      # params      :    None
      # Return      :    None
     */
    public function index() {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $this->form_validation->set_rules('username', 'Name', 'trim|required');
            $this->form_validation->set_rules('upi', 'UPI', 'required|callback_upi_check');
            $data['info'] = array();
            $assmt_no = $this->input->get('assmt_no');
            $upi = '';
            if (($this->input->get('assmt_no')) && ($this->input->get('upi'))) {
                $upi = trim($this->input->get('upi'));
                $assmt_no = trim($this->input->get('assmt_no'));
                $data['info'] = $this->payment_model->get_payment_upi_assmt($upi, $assmt_no);
            }
            if (($this->input->get('upi')) && ($this->input->get('assmt_no') == "")) {
                $upi = trim($this->input->get('upi'));
                $data['info'] = $this->payment_model->get_payment_info_all_years($upi);
            }
            if (($this->input->get('assmt_no')) && ($this->input->get('upi') == "")) {
                $data['info'] = $this->payment_model->get_payment_info_all_years_assesment($assmt_no);
            }
            $this->load->view('payment_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    edit_payment
      # Purpose      :    Edit payment
      # params       :    None
      # Return       :    None
     */
    public function edit_payment() {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $this->form_validation->set_rules('upi', 'UPI', 'required|callback_upi_check');
            $data['p_year'] = $p_year = trim($this->input->post('p_year'));
            $upi = $data['upi'] = $this->input->post('upi');
            $propId = $data['propId'] = $this->input->post('pid');
            $data['assmtno'] = $this->input->post('assmtno');
            $data['info'] = $this->payment_model->get_payment_info_year($propId);
            $data['cess'] = $this->payment_model->get_cess($p_year);
            $data['infos'] = $this->payment_model->get_payedinfo($propId);
            $data['get_build_area_property_type'] = $this->payment_model->get_build_area_property_type($propId);
            //$data['get_build_area_property_type'] = $this->payment_model->get_build_area_property_type($propId);
            $data['get_112c'] = $this->payment_model->get_112c($upi);
            $data['ex_serviceman'] = $this->payment_model->ex_serviceman($upi);
            $data['stax_exempted'] = $this->payment_model->stax_exempted($propId);
			$data['checkpayment']= $this->payment_model->checkpayment($propId);
            $this->load->view('editpayment_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    view_payment
      # Purpose      :    View payment
      # params       :    None
      # Return       :    None
     */
    public function view_payment() {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $propId = $data['propId'] = $this->input->post('pid');
            $upi = $this->input->post('upis');
            $data['get_112c'] = $this->payment_model->get_112c($upi);
            $data['ex_serviceman'] = $this->payment_model->ex_serviceman($upi);
            $data['stax_exempted'] = $this->payment_model->stax_exempted($propId);
            $data['paydisplay'] = $this->payment_model->checkpayment($propId);
            echo $this->load->view('viewpayment_view', $data, TRUE);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    insertpayment
      # Purpose      :    Insert payment
      # params       :    None
      # Return       :    None
     */
    public function insertpayment() {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $username = $userifo['username'];
            $is_payed = $this->payment_model->checkpayment($this->input->post('propId'));
			$selecteddata = $this->input->post('colorRadio');
			$years=getcurrentYear();
            $getmaxofidYear = $this->payment_model->getmaxofidYear($years);
			if ($getmaxofidYear == '') {
                $yearstr = substr($years, 0, 4);
                $n = 0;
                $n = str_pad($n + 1, 7, 0, STR_PAD_LEFT);
                $challan_no = $yearstr . $n;
            } else {
                $yearstr = substr($years, 0, 4);
                $id = $getmaxofidYear;
                $challan_no = $yearstr . $this->getNextNumber($id, $years);
            }
			if($selecteddata=='new')
			{
            if ($is_payed) {
                $data = array('p_id' => $this->input->post('propId'),
                    'property_tax' => $this->input->post('property_tax'),
                    'penalty_112C' => $this->input->post('penalty_112C'),
                    'service_tax' => $this->input->post('service_tax'),
                    'payable_total' => $this->input->post('payable_total'),
                    'ex_service_man' => $this->input->post('ex_rebate'),
                    'cess' => $this->input->post('cess'),
                    'SWM_cess' => $this->input->post('swm_cess'),
                    'adjustment' => $this->input->post('adjustment'),
                    'penalty' => $this->input->post('penalty'),
                    'rebate' => $this->input->post('rebate'),
                    'p_total' => $this->input->post('p_total'),
                    //'challan_no' => $this->input->post('challan_no'),
                    'name_bank' => $this->input->post('name_bank'),
                    'name_branch' => $this->input->post('name_branch'),
                    'payment_date' => $this->input->post('payment_date'),
                    'difference' => $this->input->post('difference'),
                    'remarks' => $this->input->post('remarks'), 'p_year' => $this->input->post('p_year'),
                    'is_payed' => 0, 'upi' => $this->input->post('upi'), 'created_by' => $username);
                $p_id = $this->input->post('propId');
                $this->payment_model->updatepayment($p_id, $data);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Updated Payment detail of " . $upi . "for the year " . $p_year;
                newUserlog($str);
            } else {
                $data = array('p_id' => $this->input->post('propId'),
                    'property_tax' => $this->input->post('property_tax'),
                    'penalty_112C' => $this->input->post('penalty_112C'),
                    'service_tax' => $this->input->post('service_tax'),
                    'payable_total' => $this->input->post('payable_total'),
                    'ex_service_man' => $this->input->post('ex_rebate'),
                    'cess' => $this->input->post('cess'),
                    'SWM_cess' => $this->input->post('swm_cess'),
                    'adjustment' => $this->input->post('adjustment'),
                    'penalty' => $this->input->post('penalty'),
                    'rebate' => $this->input->post('rebate'),
                    'p_total' => $this->input->post('p_total'),
                   // 'challan_no' => $this->input->post('challan_no'),
                    'name_bank' => $this->input->post('name_bank'),
                    'name_branch' => $this->input->post('name_branch'),
                    'payment_date' => $this->input->post('payment_date'),
                    'difference' => $this->input->post('difference'),
                    'remarks' => $this->input->post('remarks'), 'datas' => $this->input->post('colorRadio'),'p_year' => $this->input->post('p_year'),
                    'is_payed' => 0, 'upi' => $this->input->post('upi'));
                $this->payment_model->insertpayment($data);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Added Payment detail of " . $upi . " for the year " . $p_year;
                newUserlog($str);
            }
			}
			else
			{
			if ($is_payed) {
                $data = array('p_id' => $this->input->post('propId'),
                    'property_tax' => $this->input->post('property_tax'),
                    'penalty_112C' => $this->input->post('penalty_112C'),
                    'service_tax' => $this->input->post('service_tax'),
                    'payable_total' => $this->input->post('payable_total'),
                    'ex_service_man' => $this->input->post('ex_rebate'),
                    'cess' => $this->input->post('cess'),
                    'SWM_cess' => $this->input->post('swm_cess'),
                    'adjustment' => $this->input->post('adjustment'),
                    'penalty' => $this->input->post('penalty'),
                    'rebate' => $this->input->post('rebate'),
                    'p_total' => $this->input->post('p_total'),
                    'challan_no' => $this->input->post('challan_no'),
                    'name_bank' => $this->input->post('name_bank'),
                    'name_branch' => $this->input->post('name_branch'),
                    'payment_date' => $this->input->post('payment_date'),
                    'difference' => $this->input->post('difference'),
                    'remarks' => $this->input->post('remarks'), 'p_year' => $this->input->post('p_year'),
                    'is_payed' => 0, 'upi' => $this->input->post('upi'), 'created_by' => $username);
                $p_id = $this->input->post('propId');
                $this->payment_model->updatepayment($p_id, $data);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Updated Payment detail of " . $upi . "for the year " . $p_year;
                newUserlog($str);
            } else {
                $data = array('p_id' => $this->input->post('propId'),
                    'property_tax' => $this->input->post('property_tax'),
                    'penalty_112C' => $this->input->post('penalty_112C'),
                    'service_tax' => $this->input->post('service_tax'),
                    'payable_total' => $this->input->post('payable_total'),
                    'ex_service_man' => $this->input->post('ex_rebate'),
                    'cess' => $this->input->post('cess'),
                    'SWM_cess' => $this->input->post('swm_cess'),
                    'adjustment' => $this->input->post('adjustment'),
                    'penalty' => $this->input->post('penalty'),
                    'rebate' => $this->input->post('rebate'),
                    'p_total' => $this->input->post('p_total'),
                    'challan_no' => $this->input->post('challan_no'),
                    'name_bank' => $this->input->post('name_bank'),
                    'name_branch' => $this->input->post('name_branch'),
                    'payment_date' => $this->input->post('payment_date'),
                    'difference' => $this->input->post('difference'),
                    'remarks' => $this->input->post('remarks'), 'datas' => $this->input->post('colorRadio'),'p_year' => $this->input->post('p_year'),
                    'is_payed' => 0, 'upi' => $this->input->post('upi'));
                $this->payment_model->insertpayment($data);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Added Payment detail of " . $upi . " for the year " . $p_year;
                newUserlog($str);
			}
			
            $this->payment_model->checkopeningbalance($this->input->post('upi'), $this->input->post('p_year'));
        } }else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    public function getNextNumber($id = '', $year) {
        $seq = $year <> +substr($id, 0, 4) ? 0 : +substr($id, -7);
        return sprintf("%0+7u", $seq + 1);
    }

    /**
      # Function     :    generatepayment
      # Purpose      :    Generate payment detail
      # params       :    None
      # Return       :    None
     */
    public function generatepayment() {
			if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $username = $userifo['username'];
            $is_payed = $this->payment_model->checkpayment($this->input->post('propId'));
            $year = $this->input->post('p_year');
			$selecteddata = $this->input->post('colorRadio');
			if($selecteddata=='new')
			{
			$years=getcurrentYear();
            $getmaxofidYear = $this->payment_model->getmaxofidYear($years);
            if ($getmaxofidYear == '') {
                $yearstr = substr($years, 0, 4);
                $n = 0;
                $n = str_pad($n + 1, 7, 0, STR_PAD_LEFT);
                $challan_no = $yearstr . $n;
            } else {
                $yearstr = substr($years, 0, 4);
                $id = $getmaxofidYear;
                $challan_no = $yearstr . $this->getNextNumber($id, $years);
            }

            $data = array('p_id' => $this->input->post('propId'),
                'property_tax' => $this->input->post('property_tax'),
                'penalty_112C' => $this->input->post('penalty_112C'),
                'service_tax' => $this->input->post('service_tax'),
				'payable_total' => $this->input->post('payable_total'),
                'ex_service_man' => $this->input->post('ex_rebate'),
                'cess' => $this->input->post('cess'),
                'SWM_cess' => $this->input->post('swm_cess'),
                'adjustment' => $this->input->post('adjustment'),
                'penalty' => $this->input->post('penalty'),
                'rebate' => $this->input->post('rebate'),
                'p_total' => $this->input->post('p_total'),
                'challan_no' => $challan_no,
				'year_of_payment' => $years,
                'name_bank' => $this->input->post('name_bank'),
                'name_branch' => $this->input->post('name_branch'),
                'payment_date' => $this->input->post('payment_date'),
                'difference' => $this->input->post('difference'),
                'remarks' => $this->input->post('remarks'), 'datas' => $this->input->post('colorRadio'), 'p_year' => $this->input->post('p_year'),
                'is_payed' => 1, 'upi' => $this->input->post('upi'), 'created_by' => $username);
            //exit;
            if ($is_payed) {
                $p_id = $this->input->post('propId');
                $this->payment_model->updatepayment($p_id, $data);
				 $data1 = array('is_verified' => 1);
				 $this->payment_model->updateverification($p_id,$data1);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Updated Payment detail of " . $upi . " for the year " . $p_year;
                newUserlog($str);
            } else {
			$p_id = $this->input->post('propId');
                $this->payment_model->insertpayment($data);
				
                
				$data1 = array('is_verified' => 1);
				 $this->payment_model->updateverification($p_id,$data1);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Added Payment detail of " . $upi . " for the year " . $p_year;
                newUserlog($str);
            }
            $this->payment_model->checkopeningbalance($this->input->post('upi'), $this->input->post('p_year'));
			}
			else
			{
			$years=getcurrentYear();
            /*$getmaxofidYear = $this->payment_model->getmaxofidYear($years);
            if ($getmaxofidYear == '') {
                $yearstr = substr($years, 0, 4);
                $n = 0;
                $n = str_pad($n + 1, 7, 0, STR_PAD_LEFT);
                $challan_no = $yearstr . $n;
            } else {
                $yearstr = substr($years, 0, 4);
                $id = $getmaxofidYear;
                $challan_no = $yearstr . $this->getNextNumber($id, $years);
            }*/

            $data = array('p_id' => $this->input->post('propId'),
                'property_tax' => $this->input->post('property_tax'),
                'penalty_112C' => $this->input->post('penalty_112C'),
                'service_tax' => $this->input->post('service_tax'),
				'payable_total' => $this->input->post('payable_total'),
                'ex_service_man' => $this->input->post('ex_rebate'),
                'cess' => $this->input->post('cess'),
                'SWM_cess' => $this->input->post('swm_cess'),
                'adjustment' => $this->input->post('adjustment'),
                'penalty' => $this->input->post('penalty'),
                'rebate' => $this->input->post('rebate'),
                'p_total' => $this->input->post('p_total'),
                'challan_no' => $this->input->post('challan_no'),
				'year_of_payment' => $years,
                'name_bank' => $this->input->post('name_bank'),
                'name_branch' => $this->input->post('name_branch'),
                'payment_date' => $this->input->post('payment_date'),
                'difference' => $this->input->post('difference'),
                'remarks' => $this->input->post('remarks'), 'datas' => $this->input->post('colorRadio'), 'p_year' => $this->input->post('p_year'),
                'is_payed' => 1, 'upi' => $this->input->post('upi'), 'created_by' => $username);
            //exit;
            if ($is_payed) {
                $p_id = $this->input->post('propId');
                $this->payment_model->updatepayment($p_id, $data);
				 $data1 = array('is_verified' => 1);
				 $this->payment_model->updateverification($p_id,$data1);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Updated payment of upi - " . $upi . " and for year - " . $p_year . " and generated Challan";
                newUserlog($str);
            } else {
			  $p_id = $this->input->post('propId');
                $this->payment_model->insertpayment($data);
				$data1 = array('is_verified' => 1);
				 $this->payment_model->updateverification($p_id,$data1);
                $upi = $this->input->post('upi');
                $p_year = $this->input->post('p_year');
                $str = "Inserted payment of upi - " . $upi . " and for year - " . $p_year . " and generated Challan";
                newUserlog($str);
            }
            $this->payment_model->checkopeningbalance($this->input->post('upi'), $this->input->post('p_year'));
			}
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    checkPreviousPayment
      # Purpose      :    check previous payment
      # params       :    None
      # Return       :    None
     */
    public function checkPreviousPayment() {
        $upi = $this->input->post('upId');
        $prevYear = $this->input->post('prevYear');
        $propId = $this->payment_model->getpropId($upi, $prevYear);
        $data = $this->payment_model->checkPreviousPayment($propId, $prevYear);
        echo json_encode($data);
    }

    /**
      # Function     :    convert_number_to_words
      # Purpose      :    convert number to words
      # params       :    None
      # Return       :    None
     */
    public function convert_number_to_words($number) {
        $hyphen = ' ';
        $conjunction = ' and ';
        $separator = ' ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    /**
      # Function     :    printscreen
      # Purpose      :    display pdf
      # params       :    None
      # Return       :    None
     */
    public function printscreen() {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $propid = $_GET['propid'];
            $upi = $_GET['upi'];
            $get_112c = $this->payment_model->get_112c($upi);
            $ex_serviceman = $this->payment_model->ex_serviceman($upi);
            $stax_exempted = $this->payment_model->stax_exempted($propid);
            $data = $this->payment_model->print_data($propid, $upi);
            $number = round($data[0]['p_total']);
            $words = $this->convert_number_to_words($number);
            $base_url = base_url();
            $str = "Generated Challan of " . $upi . " for the year " . $data[0]['p_year'];
            newUserlog($str);
			 $html1='';
            //load the view and saved it into $html variable
            if ($ex_serviceman || $stax_exempted) {
                $html1 .= "<tr>
											<td rowspan='8'>" . $data[0]['p_name'] . "</td>
											<td rowspan='8' >" . $data[0]['upi'] . "," . $data[0]['assmt_no'] . "</td>
											<td>Property Tax</td>
											<td>" . $data[0]['property_tax'] . "</td>	
											<td>00</td>
										</tr>";
            } else {
                $html1 .= "<tr>
											<td rowspan='7'>" . $data[0]['p_name'] . "</td>
											<td rowspan='7' >" . $data[0]['upi'] . "," . $data[0]['assmt_no'] . "</td>
											<td>Property Tax</td>
											<td>" . $data[0]['property_tax'] . "</td>	
											<td>00</td>
										</tr>";
            }
            $html = '';
            $html .= "	<head>
<style>

table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
border: 1px solid #ddd;
}
.table-bordered {
border: 1px solid #ddd;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
padding: 8px;
line-height: 1.42857143;
vertical-align: top;
border-top: 1px solid #ddd;
}
table tr td {
padding: 8px;
line-height: 1.42857143;
vertical-align: top;
border: 1px solid #ddd;
}
</style>
</head>
						<body><div class='table-responsive'>
                            <div class='table-responsive custom_datatable'>						
                                    <table class='table table-bordered printable-div' width='100%' cellspacing='0' cellpadding='5' border='1px solid #ddd'>
                                        <tbody>	
										<tr><td colspan='5' align='right'><h4 align='right'>PAYMENT COPY</h4></td></tr>										
										<tr>
                                            <td rowspan='2' colspan='2'><img src='" . $base_url . "/assets/img/avatar.png' width='50' style='float:left;'><h3 style='margin:8px 0 0 63px;'>MANGALURU CITY CORPORATION</h3></td>
                                            <td>Challan NO</td>
											<td colspan='2'>" . $data[0]['challan_no'] . "</td>
                                        </tr>
										</thead>
                                        <tr>
                                            <td>Date</td>  
											<td colspan='2'>" . $data[0]['payment_date'] . "</td>  											
                                        </tr>
										<tr>
											<td colspan='2'>Bank Name / Branch : </strong></td>
											<td colspan='3'>" . $data[0]['name_bank'] . "/" . $data[0]['name_branch'] . "</td>
										</tr>
										<tr>
											<td colspan='2'>Tax Period</td>
											<td colspan='3'>" . $data[0]['p_year'] . "</td>
										</tr>
                                        <tr>
                                            <td>Building Owner Name</td>
                                            <td colspan='1'> UPI #,Assessment #</td>
                                            <td>Tax Details</td>
                                            <td >RS</td>
											<td>00</td>
                                        </tr>"
                    . $html1 .
                    "<tr>
											<td>Penalty as per 112C </td>
											<td>" . $data[0]['penalty_112C'] . "</td>
											<td>00</td>
										</tr>
										<tr>	
											<td>CESS</td>
											<td>" . $data[0]['cess'] . "</td>
											<td>00</td>
										</tr>
										
										<tr>
											<td>Penalty/Rebate </td>
											<td>" . $data[0]['penalty'] . '/' . $data[0]['rebate'] . "</td>
											<td>00</td>
										</tr><tr>
											<td>SWM CESS</td>
											<td>" . $data[0]['SWM_cess'] . "</td>
											<td>00</td>
										</tr>";
            if ($stax_exempted) {
                $html .= "<tr>
											<td>Service Charges</td>
											<td>" . $data[0]['service_tax'] . "</td>
											<td>00</td>
										</tr>";
            }
            if ($ex_serviceman) {
                $html .= "<tr>
											<td>Rebate for Ex-Serviceman</td>
											<td>" . $data[0]['ex_service_man'] . "</td>
											<td>00</td>
										</tr>";
            }
            $html .= "<tr>
											<td>Adjustment if any</td>
											<td>" . $data[0]['adjustment'] . "</td>
											<td>00</td>
										</tr>
										
   
										<tr>
											<td>Total</td>
											<td>" . $data[0]['p_total'] . "</td>
											<td>00</td>
										</tr>
										<tr><td colspan='5'>Amount in words :<em>" . $words . " rupees only<em> </td></tr>
										<tr>
											<td>Depositer Signature</td>
											<td>Account #</td>
											<td>Office Manager signature</td>
											<td colspan='2'>Cashier Signature</td>
										</tr>										
									</tbody>
									</table> <pagebreak />
						
						  <table class='table table-bordered printable-div' width='100%' cellspacing='0' cellpadding='5' border='1px solid #ddd'>
                                        <tbody>	
										<tr><td colspan='5' align='right'><h4 align='right'>TAX PAYERS COPY</h4></td></tr>										
										<tr>
                                            <td rowspan='2' colspan='2'><img src='" . $base_url . "/assets/img/avatar.png' width='50' style='float:left;'><h3 style='margin:8px 0 0 63px;'>MANGALURU CITY CORPORATION</h3></td>
                                            <td>Challan NO</td>
											<td colspan='2'>" . $data[0]['challan_no'] . "</td>
                                        </tr>
										</thead>
                                        <tr>
                                            <td>Date</td>  
											<td colspan='2'>" . $data[0]['payment_date'] . "</td>  											
                                        </tr>
										<tr>
											<td colspan='2'>Bank Name / Branch : </strong></td>
											<td colspan='3'>" . $data[0]['name_bank'] . "/" . $data[0]['name_branch'] . "</td>
										</tr>
										<tr>
											<td colspan='2'>Tax Period</td>
											<td colspan='3'>" . $data[0]['p_year'] . "</td>
										</tr>
                                        <tr>
                                            <td>Building Owner Name</td>
                                            <td colspan='1'>UPI #,Assessment #</td>
                                            <td>Tax Details</td>
                                            <td >RS</td>
											<td>00</td>
                                        </tr>"
                    . $html1 .
                    "<tr>
											<td>Penalty as per 112C </td>
											<td>" . $data[0]['penalty_112C'] . "</td>
											<td>00</td>
										</tr>
										<tr>	
											<td>CESS%</td>
											<td>" . $data[0]['cess'] . "</td>
											<td>00</td>
										</tr>
										
										<tr>
											<td>Penalty/Rebate </td>
											<td>" . $data[0]['penalty'] . '/' . $data[0]['rebate'] . "</td>
											<td>00</td>
										</tr><tr>
											<td>SWM CESS</td>
											<td>" . $data[0]['SWM_cess'] . "</td>
											<td>00</td>
										</tr>";
            if ($stax_exempted) {
                $html .= "<tr>
											<td>Service Charges</td>
											<td>" . $data[0]['service_tax'] . "</td>
											<td>00</td>
										</tr>";
            }
            if ($ex_serviceman) {
                $html .= "<tr>
											<td>Rebate for Ex-Serviceman</td>
											<td>" . $data[0]['ex_service_man'] . "</td>
											<td>00</td>
										</tr>";
            }
            $html .= "<tr>
											<td>Adjustment if any</td>
											<td>" . $data[0]['adjustment'] . "</td>
											<td>00</td>
										</tr>
										<tr>
											<td>Total</td>
											<td>" . $data[0]['p_total'] . "</td>
											<td>00</td>
										</tr>
									<tr><td colspan='5'>Amount in words :<em>" . $words . " rupees only<em> </td></tr>
										<tr>
											<td>Depositer Signature</td>
											<td>Account #</td>
											<td>Office Manager signature</td>
											<td colspan='2'>Cashier Signature</td>
										</tr>										
									</tbody>
									</table> <pagebreak />
									
						 <table class='table table-bordered printable-div' width='100%' cellspacing='0' cellpadding='5' border='1px solid #ddd'>
                                        <tbody>	
										<tr><td colspan='5' align='right'><h4 align='right'>BANK COPY</h4></td></tr>										
										<tr>
                                            <td rowspan='2' colspan='2'><img src='" . $base_url . "/assets/img/avatar.png' width='50' style='float:left;'><h3 style='margin:8px 0 0 63px;'>MANGALURU CITY CORPORATION</h3></td>
                                            <td>Challan NO</td>
											<td colspan='2'>" . $data[0]['challan_no'] . "</td>
                                        </tr>
										</thead>
                                        <tr>
                                            <td>Date</td>  
											<td colspan='2'>" . $data[0]['payment_date'] . "</td>  											
                                        </tr>
										<tr>
											<td colspan='2'>Bank Name / Branch : </strong></td>
											<td colspan='3'>" . $data[0]['name_bank'] . "/" . $data[0]['name_branch'] . "</td>
										</tr>
										<tr>
											<td colspan='2'>Tax Period</td>
											<td colspan='3'>" . $data[0]['p_year'] . "</td>
										</tr>
                                        <tr>
                                            <td>Building Owner Name</td>
                                            <td colspan='1'> UPI #,Assessment #</td>
                                            <td>Tax Details</td>
                                            <td >RS</td>
											<td>00</td>
                                        </tr>"
                    . $html1 .
                    "<tr>
											<td>Penalty as per 112C </td>
											<td>" . $data[0]['penalty_112C'] . "</td>
											<td>00</td>
										</tr>
										<tr>	
											<td>CESS%</td>
											<td>" . $data[0]['cess'] . "</td>
											<td>00</td>
										</tr>
										
										<tr>
											<td>Penalty/Rebate </td>
											<td>" . $data[0]['penalty'] . '/' . $data[0]['rebate'] . "</td>
											<td>00</td>
										</tr><tr>
											<td>SWM CESS</td>
											<td>" . $data[0]['SWM_cess'] . "</td>
											<td>00</td>
										</tr>";
            if ($stax_exempted) {
                $html .= "<tr>
											<td>Service Charges</td>
											<td>" . $data[0]['service_tax'] . "</td>
											<td>00</td>
										</tr>";
            }
            if ($ex_serviceman) {
                $html .= "<tr>
											<td>Rebate for Ex-Serviceman</td>
											<td>" . $data[0]['ex_service_man'] . "</td>
											<td>00</td>
										</tr>";
            }
            $html .= "<tr>
											<td>Adjustment if any</td>
											<td>" . $data[0]['adjustment'] . "</td>
											<td>00</td>
										</tr>
   
										<tr>
											<td>Total</td>
											<td>" . $data[0]['p_total'] . "</td>
											<td>00</td>
										</tr>
									<tr><td colspan='5'>Amount in words :<em>" . $words . " rupees only<em> </td></tr>
										<tr>
											<td>Depositer Signature</td>
											<td>Account #</td>
											<td>Office Manager signature</td>
											<td colspan='2'>Cashier Signature</td>
										</tr>										
									</tbody>
									</table> 
									  <pagebreak />
								
					  <table class='table table-bordered printable-div' width='100%' cellspacing='0' cellpadding='5' border='1px solid #ddd'>
                                        <tbody>	
										<tr><td colspan='5' align='right'><h4 align='right'>OFFICE COPY</h4></td></tr>										
										<tr>
                                            <td rowspan='2' colspan='2'><img src='" . $base_url . "/assets/img/avatar.png' width='50' style='float:left;'><h3 style='margin:8px 0 0 63px;'>MANGALURU CITY CORPORATION</h3></td>
                                            <td>Challan NO</td>
											<td colspan='2'>" . $data[0]['challan_no'] . "</td>
                                        </tr>
										</thead>
                                        <tr>
                                            <td>Date</td>  
											<td colspan='2'>" . $data[0]['payment_date'] . "</td>  											
                                        </tr>
										<tr>
											<td colspan='2'>Bank Name / Branch : </strong></td>
											<td colspan='3'>" . $data[0]['name_bank'] . "/" . $data[0]['name_branch'] . "</td>
										</tr>
										<tr>
											<td colspan='2'>Tax Period</td>
											<td colspan='3'>" . $data[0]['p_year'] . "</td>
										</tr>
                                        <tr>
                                            <td>Building Owner Name</td>
                                            <td colspan='1'>UPI #,Assessment #</td>
                                            <td>Tax Details</td>
                                            <td >RS</td>
											<td>00</td>
                                        </tr>"
                    . $html1 .
                    "<tr>
											<td>Penalty as per 112C </td>
											<td>" . $data[0]['penalty_112C'] . "</td>
											<td>00</td>
										</tr>
										<tr>	
											<td>CESS%</td>
											<td>" . $data[0]['cess'] . "</td>
											<td>00</td>
										</tr>
										
										<tr>
											<td>Penalty/Rebate </td>
											<td>" . $data[0]['penalty'] . '/' . $data[0]['rebate'] . "</td>
											<td>00</td>
										</tr>
										<tr>
											<td>SWM CESS</td>
											<td>" . $data[0]['SWM_cess'] . "</td>
											<td>00</td>
										</tr>";

            if ($stax_exempted) {
                $html .= "<tr>
											<td>Service Charges</td>
											<td>" . $data[0]['service_tax'] . "</td>
											<td>00</td>
										</tr>";
            }
            if ($ex_serviceman) {
                $html .= "<tr>
											<td>Rebate for Ex-Serviceman</td>
											<td>" . $data[0]['ex_service_man'] . "</td>
											<td>00</td>
										</tr>";
            }
            $html .= "<tr>
											<td>Adjustment if any</td>
											<td>" . $data[0]['adjustment'] . "</td>
											<td>00</td>
										</tr>
										<tr>
											<td>Total</td>
											<td>" . $data[0]['p_total'] . "</td>
											<td>00</td>
										</tr>
										<tr><td colspan='5'>Amount in words :<em>" . $words . " rupees only<em> </td></tr>
										<tr>
											<td>Depositer Signature</td>
											<td>Account #</td>
											<td>Office Manager signature</td>
											<td colspan='2'>Cashier Signature</td>
										</tr>										
									</tbody>
									</table> 
									</div>
									</div>
								</body>	 
	";
	
	
            $pdfFilePath = "challan.pdf";
            //load mPDF library
            $this->load->library('m_pdf');
            $this->mpdf = new mPDF();
            $this->mpdf->AddPage('L', // L - landscape, P - portrait
                    'A4', '0', '', '', 20, // margin_left
                    20, // margin right
                    20, // margin top
                    20, // margin bottom
                    18, // margin header
                    12); // margin footer
            $this->mpdf->WriteHTML($html);
            $this->mpdf->Output($pdfFilePath, "I"); // download force				
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    get_penalty
      # Purpose      :    calculate penalty
      # params       :    None
      # Return       :    None
     */
    public function get_penalty() {
        $payment_date = trim($this->input->post('payment_date'));
        $payment_date1 = trim($this->input->post('payment_date'));
        $p_year = trim($this->input->post('p_year'));
        $p_year = substr($p_year, 0, 4);
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
        echo json_encode(array('month' => json_encode($month), 'r_month' => json_encode($r_month), 'p_year' => json_encode($p_year), 'payment_date1' => json_encode($payment_date1)));
    }
	
	public function check_not_payed_user()
	{
	
	$upi = $this->input->post('upId');
        $pyear = $this->input->post('pYear');
        //$a_year = $this->input->post('a_year');
		 $a_year = substr($pyear, 0, 4);
		 $finalarray=array();
		 $taxApplicableFrom = $this->input->post('taxApplicableFromStartYear');
		 $taxApplicableFromStartYear = substr($taxApplicableFrom, 0, 4);  

		   if ($a_year != $taxApplicableFromStartYear) {
        $pending_result = $this->payment_model->check_not_payed_user($upi, $pyear);

		for ($chk_first_year = (substr($taxApplicableFrom, 0, 4)); $chk_first_year < $a_year; $chk_first_year++) {
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
            } else {
               echo json_encode(array('st' => 'payed'));
            }
		//$count=count($data);
        
		//echo json_encode(array('data'=>$data));
	}
	else {
               echo json_encode(array('st' => 'payed'));
            }
	
	}
	
	public function updateverification()
	{
	  $val = $this->input->post('val');
	    $propId = $this->input->post('propId');
		 $data1 = array('is_verified' => $val);
				 $this->payment_model->updateverification($propId,$data1);
				  echo json_encode(array('msg' => 'Verification Pending status updated'));
	
	}

}
