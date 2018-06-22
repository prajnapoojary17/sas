<?php

/**
 * File Name : Import data Controller
 *
 * Description : This is used to import excel or csv file 
 *
 * Created By : Prajna P
 *
 * Created Date : 01/02/2017
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 13/04/2017
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Importdata extends CI_Controller
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
        $this->load->library('upload');
        $this->load->library('excel');
        $this->load->model('importdata_model');
        $this->load->model('sasdetails_model', 'sasdetails');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    /**
      # Function     :    index
      # Purpose      :   Load Initial settings and show import view
      # params     :    None
      # Return     :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $this->load->view('importdata', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    importdataadd
      # Purpose      :   Upload data to database
      # params     :    None
      # Return     :    None
     */
    public function importdataadd()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);      
        $userfilechk = $this->userfilecheck();
        $validateuserfile = $this->validateuserfile();
        if (!$userfilechk) {         
            echo json_encode(array('status' => false, 'msg' => 'Please choose a File to Import'));
            exit();
        } elseif(!$validateuserfile) {
            echo json_encode(array('status' => false, 'msg' => 'Invalid File'));
            exit();
        }else {
            $this->load->helper('form');
            $imgName = $_FILES ['userfile'] ['name'];
            $nameExplode = explode(".", $imgName);
            $config['upload_path'] = FCPATH . 'assets/uploads/importfile/';
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size'] = '50000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (isset($_FILES ['userfile']) && isset($_FILES ['userfile'] ['name']) && ( $imgName != '' ) && ($this->upload->do_upload('userfile'))) {
                $upload_data = $this->upload->data();
            }
            //uploded file name
            $file_name = $upload_data['file_name'];
            // uploded file extension
            $extension = $upload_data['file_ext'];
            $inputFile = $_FILES['userfile']['tmp_name'];
            $inputFileType = PHPExcel_IOFactory::identify($inputFile);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            //Set to read only
            $objReader->setReadDataOnly(true);
            //Load excel file
            $objPHPExcel = $objReader->load(FCPATH . 'assets/uploads/importfile/' . $file_name);
            //Count Numbe of rows avalable in excel
            $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            // echo $totalrows; exit;
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            //loop from first data untill last data
            for ($i = 2; $i <= $totalrows; $i++) {
                $data_user = array();
                $propId = 0;
                $p_ward = 0;
                $p_block = 0;
                $door_no = 0;
                $upi = 0;
                $p_ward = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
                $p_block = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
                $door_no = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
                $upi = $p_ward . '-' . $p_block . '-' . $door_no;
                $upiresult = $this->sasdetails->checkupi($upi);
                if (!$upiresult) {
                    $data_user['upi'] = $upi;
                    $data_user['p_name'] = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();                  
                    $data_user['n_road'] = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                    $data_user['assmt_no'] = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                    $data_user['p_ward'] = $p_ward;
                    $data_user['p_block'] = $p_block;
                    $data_user['p_112C'] = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
                    $data_user['door_no'] = $door_no;
                    $data_user['village'] = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
                    $data_user['survey_no'] = $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();                  
                    $this->importdata_model->Add_Userdata($data_user);
                }
                $p_year = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();
                $c_year = $objWorksheet->getCellByColumnAndRow(27, $i)->getValue();
                if($c_year == 1999){
                    $construction_year = '1999-00';
                }else{
                    $construction_year = $c_year.'-'.((strlen(substr($c_year,2)+01))>1?(substr($c_year,2)+01):'0'.(substr($c_year,2)+1));
                }
                if($construction_year >= 2008) {
                    $tax_applicablefrom = $construction_year;
                } else {
                    $tax_applicablefrom = '2008-09';
                }
                $propdata_check = $this->sasdetails->check_propdata($upi, $p_year);
                if (!$propdata_check) {
                    $data_prop['upi'] = $upi;
                    $data_prop['p_name'] = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
                   // $data_prop['o_name'] =
                   // $data_prop['contact_no'] =
                   // $data_prop['aadhar_no'] =
                    $data_prop['is_verified'] = '1';
                    $data_prop['area_cents'] = $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
                    $data_prop['area_sqft'] = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
                    $data_prop['area_build'] = $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
                    $data_prop['area_floors'] = $objWorksheet->getCellByColumnAndRow(13, $i)->getValue();
                    $data_prop['area_ratio'] = $objWorksheet->getCellByColumnAndRow(14, $i)->getValue();
                    $data_prop['undiv_right'] = $objWorksheet->getCellByColumnAndRow(15, $i)->getValue();
                    $data_prop['p_use'] = $objWorksheet->getCellByColumnAndRow(16, $i)->getValue();
                    $data_prop['tax_applicablefrom'] = $tax_applicablefrom;
                    $data_prop['tax_rate'] = $objWorksheet->getCellByColumnAndRow(17, $i)->getValue();
                    $data_prop['p_year'] = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();
                    if (!(preg_match("/^[\d]{4}-[\d]{2}$/", $data_prop['p_year']))) {                    
                        echo json_encode(array('status' => false, 'msg' => 'Invalid Payment Year for UPI - '.$upi));
                        exit();
                    } 
                    $data_prop['enhancement_tax'] = $objWorksheet->getCellByColumnAndRow(19, $i)->getValue();
                    $data_prop['value_cents'] = $objWorksheet->getCellByColumnAndRow(20, $i)->getValue();
                    $data_prop['value_sqft'] = $objWorksheet->getCellByColumnAndRow(21, $i)->getValue();
                    
                    $data_prop['is_corn'] = $objWorksheet->getCellByColumnAndRow(22, $i)->getValue();
                    $data_prop['value_corn'] = $objWorksheet->getCellByColumnAndRow(23, $i)->getValue();
                    $data_prop['value_total'] = $objWorksheet->getCellByColumnAndRow(24, $i)->getValue();
                    $data_prop['guide_50'] = $objWorksheet->getCellByColumnAndRow(25, $i)->getValue();
                    $propId = $this->importdata_model->Add_Propertydata($data_prop);
                } else {
                    $propId = $propdata_check['id'];
                }
                $floor = $objWorksheet->getCellByColumnAndRow(26, $i)->getValue();
                $builddata_check = $this->importdata_model->check_builddata($propId, $floor, $upi);
                if (!$builddata_check) {
                    // building data
                    $data_build['prop_id'] = $propId;
                    $data_build['upi'] = $upi;
                    $data_build['floor'] = $objWorksheet->getCellByColumnAndRow(26, $i)->getValue();
                    $data_build['c_year'] = $construction_year;
                    $data_build['age_build'] = $objWorksheet->getCellByColumnAndRow(28, $i)->getValue();
                    $data_build['depreciation_rate'] = $objWorksheet->getCellByColumnAndRow(29, $i)->getValue();
                    $data_build['type_const'] = $objWorksheet->getCellByColumnAndRow(30, $i)->getValue();
                    $data_build['b_value_sqft'] = $objWorksheet->getCellByColumnAndRow(31, $i)->getValue();
                    $data_build['b_guide_50'] = $objWorksheet->getCellByColumnAndRow(32, $i)->getValue();
                    $data_build['b_area_sqft'] = $objWorksheet->getCellByColumnAndRow(33, $i)->getValue();
                    $data_build['build_type'] = $objWorksheet->getCellByColumnAndRow(34, $i)->getValue();
                    $data_build['land_tax_value'] = $objWorksheet->getCellByColumnAndRow(35, $i)->getValue();
                    $data_build['build_tax_value'] = $objWorksheet->getCellByColumnAndRow(36, $i)->getValue();
                    $data_build['app_tax'] = $objWorksheet->getCellByColumnAndRow(37, $i)->getValue();
                    $data_build['b_enhc_tax'] = $objWorksheet->getCellByColumnAndRow(38, $i)->getValue();
                    $data_build['b_cess'] = $objWorksheet->getCellByColumnAndRow(39, $i)->getValue();
                    $data_build['b_tot_tax'] = $objWorksheet->getCellByColumnAndRow(40, $i)->getValue();
                    $this->importdata_model->Add_Buildingdata($data_build);
                }
                $payment_check = $this->importdata_model->check_paymentdata($propId);
                if (!$payment_check) {
                    // Payment data
                    $data_pay['p_id'] = $propId;
                    $data_pay['upi'] = $upi;
                    $data_pay['property_tax'] = $objWorksheet->getCellByColumnAndRow(42, $i)->getValue();
                    $data_pay['penalty_112C'] = $objWorksheet->getCellByColumnAndRow(43, $i)->getValue();
                    $data_pay['service_tax'] = $objWorksheet->getCellByColumnAndRow(45, $i)->getValue();
                    $data_pay['cess'] = $objWorksheet->getCellByColumnAndRow(44, $i)->getValue();
                    $data_pay['SWM_cess'] = $objWorksheet->getCellByColumnAndRow(46, $i)->getValue();
                    $data_pay['adjustment'] = $objWorksheet->getCellByColumnAndRow(47, $i)->getValue();
                    $data_pay['penalty'] = $objWorksheet->getCellByColumnAndRow(48, $i)->getValue();
                    $data_pay['rebate'] = $objWorksheet->getCellByColumnAndRow(49, $i)->getValue();
                    $data_pay['p_total'] = $objWorksheet->getCellByColumnAndRow(50, $i)->getValue();
                    $data_pay['challan_no'] = $objWorksheet->getCellByColumnAndRow(41, $i)->getValue();
                    $data_pay['name_bank'] = $objWorksheet->getCellByColumnAndRow(51, $i)->getValue();
                    $data_pay['name_branch'] = $objWorksheet->getCellByColumnAndRow(52, $i)->getValue();
                    $data_pay['payment_date'] = $objWorksheet->getCellByColumnAndRow(53, $i)->getValue();
                    $year = explode('-', $data_pay['payment_date']);
                    if($year[0] == 1999){
                        $year_of_payment = '1999-00';
                    }else{
                        $year_of_payment = $year[0].'-'.((strlen(substr($year[0],2)+01))>1?(substr($year[0],2)+01):'0'.(substr($year[0],2)+1));
                    }
                    $data_pay['is_payed'] = '1';                  
                    $data_pay['p_year'] = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();
                    $data_pay['year_of_payment'] = $year_of_payment;
                    $this->importdata_model->Add_Paymentdata($data_pay);
                }
            }
            $str = "Imported File";
            newUserlog($str);
            echo json_encode(array('status' => true, 'msg' => 'Imported Successfully'));
        }
    }

    /**
      # Function     :    userfilecheck
      # Purpose      :   validate file to be uploaded
      # params     :    None
      # Return     :    status
     */
    public function userfilecheck()
    {        
        if (empty($_FILES['userfile']['name'])) {         
            return FALSE;
        } 
        return TRUE;
    }

    
    /**
      # Function     :    validateuserfile
      # Purpose      :   validate file to be uploaded
      # params     :    None
      # Return     :    status
     */
    public function validateuserfile()
    {
        $mimes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream', 'text/csv', 'text/tsv');
        if (in_array($_FILES['userfile']['type'], $mimes)) {
            return TRUE;
        } else {        
            return FALSE;
        }
    }
    
    
    /**
      # Function     :    importGuidance
      # Purpose      :   Load Initial settings and show import view
      # params     :    None
      # Return     :    None
     */
    public function importGuidance()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $this->load->view('importguidance', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    /**
      # Function     :    importdataaddGuidance
      # Purpose      :  to import guidance value. Need to change this function name to 
                        importdataadd inorder to import
      # params     :    None
      # Return     :    status
     */
    public function importaddGuidance()
    {          
        $this->load->helper('form');
        $imgName = $_FILES ['userfile'] ['name'];
        $nameExplode = explode(".", $imgName);
        $config['upload_path'] = FCPATH . 'assets/uploads/importfile/';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = '50000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (isset($_FILES ['userfile']) && isset($_FILES ['userfile'] ['name']) && ( $imgName != '' ) && ($this->upload->do_upload('userfile'))) {
            $upload_data = $this->upload->data();
        }
        //uploded file name
        $file_name = $upload_data['file_name'];
        // uploded file extension
        $extension = $upload_data['file_ext'];
        $inputFile = $_FILES['userfile']['tmp_name'];
        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        //Set to read only
        $objReader->setReadDataOnly(true);
        //Load excel file
        $objPHPExcel = $objReader->load(FCPATH . 'assets/uploads/importfile/' . $file_name);
        //Count Numbe of rows avalable in excel
        $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        // echo $totalrows; exit;
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        //loop from first data untill last data
        for ($i = 2; $i <= $totalrows; $i++) {
            $road_name = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
            $ward_no = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
            $gvalcents_commercial = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();  
            $gvalcents_residential = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
            $guidance_check = $this->importdata_model->check_guidance($road_name,$ward_no,$gvalcents_commercial,$gvalcents_residential);
            if(!$guidance_check) {
                $data_user = array();
                $data_user['road_name'] = $road_name;  
                $data_user['ward_no'] = $ward_no;
                $data_user['gvalcents_commercial'] = $gvalcents_commercial;
                $data_user['gvalcents_residential'] = $gvalcents_residential;
                $data_wardroad['road_name'] = $road_name;
                $data_wardroad['ward_no'] = $ward_no;
                $this->importdata_model->Add_WardRoadnamedata($data_wardroad);
                $this->importdata_model->Add_Guidancedata($data_user);
            }
        }
        $str = "Imported File";        
        echo json_encode(array('status' => true, 'msg' => 'Imported Successfully'));
        //}
    }
    
    public function downloadFile()
    {
        $this->load->helper('download');
        $data = file_get_contents(FCPATH . 'assets/sample/'.$this->uri->segment(3)); // Read the file's contents
        $name = $this->uri->segment(3);
        force_download($name, $data);
    }
}