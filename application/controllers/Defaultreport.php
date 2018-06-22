<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Defaultreport Controller
 *
 * Description : This is used to handle Defaulters report
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
class Defaultreport extends CI_Controller
{

    /**
      # Function    :    __construct
      # Purpose     :    Class constructor
      # params      :    None
      # Return      :    None
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('default_model', '', TRUE);
		$this->load->model('payment_model', '', TRUE);
        $this->load->library('pagination');
        $this->load->helper('user');
    }

    /**
      # Function     :    index
      # Purpose      :    Initial settings
      # params       :    None
      # Return       :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_GET['id'])) {
                $ward = $_GET['ward'];
                if (isset($_GET['per_page'])) {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = $_GET['per_page'];
                } else {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = '';
                }
                if (!isset($_GET['per_page'])) {
				$this->default_model->delete_opening_balance($ward);
				
                    $displaydefault = $records_array = $this->default_model->display_default($ward);
                    $count = count($displaydefault);
					if($count>0)
					{
                    for ($i = 0; $i < $count; $i++) {
                        $upi = $displaydefault[$i]['upi'];
						$fyear = $this->payment_model->tax_applicablefrom($upi);
						
						if($fyear == '')
						{
                        $fyear = '2008-09';
						}
                        $fyear = explode("-", $fyear);
                        $fyear = $fyear[0];
                        $lastyear=getcurrentYear();
                        $lastyear = explode("-", $lastyear);
                        $lastyear = $lastyear[0];
                        $misnumb = array();
                        if ($lastyear != $fyear) {
                            for ($m = $fyear; $m <= $lastyear; $m++) {
                                list($d, $rangeyear) = str_split($m, 2);
                                $rangeyear = $rangeyear + 1;
                                if ((strlen($rangeyear) == 1) ? $rangeyear = '0' . $rangeyear : $rangeyear)
                                    $missyear = $m . '-' . $rangeyear;
                                $missingyear = $this->default_model->getMissingYear($upi, $missyear);                                
                                $getMissingYearFromPayment = $this->default_model->getMissingYearFromPayment($upi, $missyear);
                                if ($missingyear & !$getMissingYearFromPayment) {
                                    $pid = $missingyear['id'];
                                    $getbuildtax = $this->default_model->getbuildtax($pid);
                                    if ($getbuildtax) {
                                        $b_enhc_tax = $getbuildtax['b_enhc_tax'];
                                        $b_cess = $getbuildtax['b_cess'];
                                    } else {
                                        $b_enhc_tax = '0';
                                        $b_cess = '0';
                                    }                                    
                                } else {
                                    $b_enhc_tax = '0';
                                    $b_cess = '0';
                                }
                                if (!$missingyear || !$getMissingYearFromPayment) {
                                    $array2[] = array("p_year" => "$missyear", "b_enhc_tax" => "$b_enhc_tax", "b_cess" => "$b_cess", "upi" => "$upi", "p_ward" => "$ward");
                                }
                            }
                        }
                    }
					
                    $this->default_model->insertobcb($array2, $upi, $missyear);
					}
                }                
                if (isset($_GET['per_page'])) {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = $_GET['per_page'];
                } else {
                    $uri_segment = ($this->uri->segment(3) == '' ? '0' : $this->uri->segment(3));
                    $uri_segments = '';
                }
                $uri_segment = ($uri_segments == '' ? '0' : $uri_segments);
                $config['page_query_string'] = TRUE;
                $config['base_url'] = base_url() . '/defaultreport/index?ward=' . $ward . '&id=';
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
                $records_array_totrec = $this->default_model->sidedisplay_data($ward, 0, 0, 1);
                $data['sidedata'] = $records_array = $this->default_model->sidedisplay_data($ward, $uri_segment, $config['per_page'], 0);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $data['ward'] = $this->default_model->ward();
                $data['selectyear'] = $this->default_model->selectyear();
                $str = "Viewed Defaulters List of ".$ward." ward";
                newUserlog($str);
            }
            $data['ward'] = $this->default_model->ward();
            $data['selectyear'] = $this->default_model->selectyear();
            $this->load->view('default_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }
    
    /**
      # Function     :    printscreen
      # Purpose      :    Printing the Challan
      # params       :    None
      # Return       :    None
     */
    public function printscreen()
    {
        $ward = $_GET['ward'];       
        $uri_segments = $_GET['per_page'];
        $uri_segment = ($uri_segments == '' ? '0' : $uri_segments);
        $config['page_query_string'] = TRUE;
        $config['base_url'] = base_url() . '/defaultreport/index?ward=' . $ward . '&id=';
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;
        $sidedata = $this->default_model->sidedisplay_data($ward, $uri_segment, $config['per_page'], 0);
        $html = '';
        $html .= "	<head>
</head><body><p>Total tax payable for each Assessment Year will be calculated based on date of payment selected, which will include penalty, SWM charges, etc.</p><table width='100%' cellspacing='0' cellpadding='6' border='1'><tbody><tr><td colspan='6'><strong>Ward : $ward</strong></td></tr>
										<tr>
                                            <th>UPI</th>
                                            <th>Payer Name</th>
											<th>Address</th>
											<th>Assessment No</th>
                                            <th>Assessment Year</th>
											<th>Total Balance(Enhancement tax + Cess)</th>                                                                                  
                                        
                                        </tr>";
        foreach ($sidedata as $data) {
            $html .="<tr>
											<td>" . $data->upi . "</td>";
            $pname = getpname($data->upi);
            $village = getvillage($data->upi);
            $assmt_no = getassmt_no($data->upi);
            $bal = getbalance($data->upi);
            $bal = $bal[0]['total'];
            $getyears = getyears($data->upi);

            $html .="<td>" . $pname . "</td>
											<td>" . $village . "</td>
											<td>" . $assmt_no . "</td>";
            $html .="<td>";
            for ($i = 0; $i < count($getyears); $i++) {
                $year = $getyears[$i]['p_year'];
                $html .=$year . '<br>';
            }
            $html .="</td>";
            $html .="<td>" . $bal . "</td>											
										</tr>";
        }
        $html .="</tbody></table></body>";
        $pdfFilePath = 'defaulter.pdf';
        $this->load->library('m_pdf');
        $this->mpdf = new mPDF();
        $this->mpdf->AddPage('L', // L - landscape, P - portrait
                'A3', '0', '', '', 5, // margin_left
                5, // margin right
                5, // margin top
                5, // margin bottom
                18, // margin header
                12); // margin footer      
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($pdfFilePath, "I"); // download force		
    }

}