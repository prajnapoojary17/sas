<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Demandreport Controller
 *
 * Description : This is used to handle Demand report 
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
class Demandreport extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('demandcollection_model', '', TRUE);
        $uri = $this->uri->segment(1, 0);
        //Load the pagination library
        $this->load->library('pagination');
        $this->load->helper('user');
    }

    /**
      # Function    :    index
      # Purpose     :    Initial settings for demad report
      # params      :    None
      # Return      :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in'))) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            if (isset($_GET['id'])) {
                $ward = $_GET['ward'];
                $upi = $_GET['upi'];
                $asstno = $_GET['asstno'];
                if ($_GET['fromdate'] != '') {
                    $fromdate = $_GET['fromdate'];
                    $whereStr = explode("-", $fromdate);
                    if (!isset($whereStr[0])) {
                        $whereStr[0] = null;
                    }
                    if (!isset($whereStr[1])) {
                        $whereStr[1] = null;
                    }
                    $bdate = $whereStr[0] - 1;
                    $bdate1 = $whereStr[1] - 1;
                    $beforedate = $bdate . '-' . $bdate1;
                    $btw = $whereStr[0] + 1;
                    $btw1 = $whereStr[1] + 1;
                    $between = $btw . '-' . $btw1;
                    $todate = $_GET['todate'];
                } else {
                    $fromdate = '';
                    $todate = '';
                    $beforedate = '';
                    $between = '';
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
                $config['base_url'] = base_url() . '/demandreport/index?ward=' . $ward . '&upi=' . $upi . '&asstno=' . $asstno . '&fromdate=' . $fromdate . '&todate=' . $todate . '&id=';
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
                $records_array_totrec = $this->demandcollection_model->sidedisplay_data($ward, $upi, $asstno, $beforedate, $fromdate, $between, $todate, 0, 0, 1);
                $data['sidedata'] = $records_array = $this->demandcollection_model->sidedisplay_data($ward, $upi, $asstno, $beforedate, $fromdate, $between, $todate, $uri_segment, $config['per_page'], 0);
                $config['total_rows'] = $records_array_totrec;
                $this->pagination->initialize($config);
                $data["page_links"] = $this->pagination->create_links();
                $data['total_record'] = $records_array_totrec;
                $data['records'] = $records_array;
                $data['ward'] = $this->demandcollection_model->ward();
                $data['selectyear'] = $this->demandcollection_model->selectyear();
                $str = "Viewed Demand Collection Report of ";
                if($ward =='' && $upi=='' && $asstno == '' && $fromdate == '' && $todate == ''){
                    $str = "Viewed Demand Collection Report";
                }else{
                    $str = "Viewed Demand Collection Report of ";
                    if($ward !=''){
                        $str .=$ward." ward ";
                    }
                    if($upi !=''){
                        $str .=$upi." UPI ";
                    }
                    if($asstno !=''){
                        $str .=$asstno." Assessment No";
                    }
                    if($fromdate != '' && $todate != ''){
                        $str .="Years between ".$fromdate." to ".$todate;
                    }
                }
                newUserlog($str);
            }
            $data['ward'] = $this->demandcollection_model->ward();
            $data['selectyear'] = $this->demandcollection_model->selectyear();
            $this->load->view('demandreport', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function    :    printscreen
      # Purpose     :    Printing demad report
      # params      :    None
      # Return      :    None
     */
    public function printscreen()
    {
        $ward = $_GET['ward'];
        if (!empty($_GET['fromdate'])) {
            $fromdate = $_GET['fromdate'];
            $whereStr = explode("-", $fromdate);
            if (!isset($whereStr[0])) {
                $whereStr[0] = null;
            }
            if (!isset($whereStr[1])) {
                $whereStr[1] = null;
            }
            $bdate = $whereStr[0] - 1;
            $bdate1 = $whereStr[1] - 1;
            $beforedate = $bdate . '-' . $bdate1;
            $btw = $whereStr[0] + 1;
            $btw1 = $whereStr[1] + 1;
            $between = $btw . '-' . $btw1;
            $todate = $_GET['todate'];
        } else {
            $fromdate = '';
            $todate = '';
            $beforedate = '';
            $between = '';
        }
        $ward = $_GET['ward'];
        $asstno = $_GET['asstno'];
        $upi = strip_tags($_GET['upi']);
        $uri_segments = $_GET['per_page'];
        $uri_segment = ($uri_segments == '' ? '0' : $uri_segments);
        $config['page_query_string'] = TRUE;
        $config['base_url'] = base_url() . '/demandreport/index?upi=' . $upi . '&ward=' . $ward . '&asstno=' . $asstno . '&fromdate=' . $fromdate . '&todate=' . $todate . '&id=';
        $config['uri_segment'] = 3;
        $config['per_page'] = 10;
        $sidedata = $this->demandcollection_model->sidedisplay_data($ward, $upi, $asstno, $beforedate, $fromdate, $between, $todate, $uri_segment, $config['per_page'], 0);
        $html = "<body>";
        $pyears = $_GET['fromdate'];
        $this->load->helper('user_helper');
        for ($y = 0; $y < count($sidedata); $y++) {
            $ward = $sidedata[$y]->p_ward;
            $base_url = base_url();
            $html .= " <!--<h2 align='center'> <img alt=''  src='" . $base_url . "/assets/img/diya_logo1.png'/></h2>-->
			<h2 align='center'>KMF NO 24 <br />
			(Rule 54(1)(a))</h2>
			<h2 align='center'>Demand Collection & Balance (DCB) cum form III Register </h2>
			<hr />
			<h3>Ward No :" . $ward . "</h3><tr>
			<table width='100%' cellspacing='0' cellpadding='5' border='1'>
			<tbody>
            <tr>
                <th rowspan='2' align='center'>Property Details</th>
                <th rowspan='2' align='center'>Assessment Year</th>
                <th rowspan='2' colspan='4' align='center'>Opening Balance</th>
                <th colspan='8' height='100' align='center'> <!--<img alt=''  src='" . $base_url . "/assets/img/diya_logo1.png'/>-->Demand <!--<img alt=''  src='" . $base_url . "/assets/img/diya_logo1.png'/>--></th>				
                <th colspan='4' height='75' align='center' rowspan='2'>Receipts</th>
                <th colspan='3' height='75' align='center' rowspan='2'>Adjustments</th>
                <th colspan='3' height='75' align='center' rowspan='2'>Balance</th>            
            </tr>
            <tr>
                <td colspan='4' height='50' align='center'>Self Assessment (SAS)</td>
                <td colspan='4' height='50' align='center'>ULB Assessment (CAL)*</td>
            </tr>			
          <tr>
                <td></td>
                <td></td>
                <td align='center'>Property Tax</td>
                <td align='center'>Cess</td>
                <td align='center'>Others</td>
                <td align='center'>Total Amount
                    <br>3+4+5</td>
                <td align='center'>Property Tax</td>
                <td align='center'>Cess</td>
                <td align='center'>Others</td>
                <td align='center'>Total Amount
                    <br>6+7+8</td>
                <td align='center'>Property Tax </td>
                <td align='center'>Cess </td>
                <td align='center'>Others </td>
                <td align='center'>Total Amount (9+10+11) </td>
				 <td align='center'>Date</td>
                <td align='center'>Amount</td>
                <td align='center'>Property Tax</td>
                <td align='center'>Cess</td>
                <td align='center'>Type &amp; Reference</td>
                <td align='center'>Property Tax Adjusted</td>
                <td align='center'>Cess Adjusted</td>
                <td align='center'>Property Tax</td>
                <td align='center'>Cess</td>
                <td align='center'>Total Amount</td>
            </tr>";
            $door_no = $sidedata[$y]->door_no;
            $ward = $sidedata[$y]->p_ward;
            $upi = $sidedata[$y]->upi;
            $block = $sidedata[$y]->p_block;

            $assmt_no = $sidedata[$y]->assmt_no;
            $obcb = $this->demandcollection_model->display_datas($ward, $upi, $assmt_no, $beforedate, $fromdate, $between, $todate);

            $countrecord = count($obcb);
            $html .= "<tr><td rowspan=" . ($countrecord + 1) . ">
							<p>Assessment No/UPI.:" . $ass = $sidedata[$y]->assmt_no . "/" . $sidedata[$y]->upi . "</p>
							<p>Name of the owner: <span class='text-uppercase'>" . $sidedata[$y]->p_name . "</span> </p>
							<p>Address of the owner: <span class='text-uppercase'>" . $sidedata[$y]->n_road . "</span> </p>
							<p>Location: <span class='text-uppercase'>" . $sidedata[$y]->village . "</span> </p>
							<p>Measurement: <span class='text-uppercase'>" . $sidedata[$y]->area_build . "</span></p>
							<p>Door Number: <span class='text-uppercase'>" . $sidedata[$y]->door_no . "</span></p>
						</td>";
            $door_no = $sidedata[$y]->door_no;
            $ward = $sidedata[$y]->p_ward;
            $block = $sidedata[$y]->p_block;
            if (($pyears && $ward ) || ($pyears && $block ) || ($pyears && $door_no) || ($pyears && $ward && $block && $door_no) || ($pyears)) {

                $suspdate = suspcheck($door_no, $pyears, $ward, $block);
            }
            $html .= " <td>  &lt; Suspense &gt; </td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>--</td>
						<td>--</td>
						<td>--</td>
						<td>--</td><td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td><td></td>
						<td></td>   </tr>
				";
            foreach ($obcb as $key => $object) {
                $assyear = $obcb[$key]->p_year;
                if ($key != 0) {
                    $ob_tax = $obcb[$key - 1]->col3;
                    $ob_cess = $obcb[$key - 1]->col4;
                    $prevpayment_date = $obcb[$key - 1]->payment_date;
                } else {
                    $ob_tax = 0;
                    $ob_cess = 0;

                    $prevpayment_date = '';
                }
                $adjtax = $obcb[$key]->taxadj;
                $adjcess = $obcb[$key]->cessadj;
                $cb_tax = $obcb[$key]->col3;
                $cb_cess = $obcb[$key]->col4;
                $payment_date = $obcb[$key]->payment_date;
                $b_enhc_tax = $obcb[$key]->b_enhc_tax;
                $b_cess = $obcb[$key]->b_cess;
                $property_tax = $obcb[$key]->property_tax;
                $cess = $obcb[$key]->cess;
                $rebate = $obcb[$key]->rebate;
                $rebate = round($rebate);
                $a = $ob_tax + $ob_cess;
                $b = $b_enhc_tax + $b_cess;
                $html .= "<tr><td>" . $assyear . "</td>";
                if ($a > 0) {
                    $html .= " <td>" . $ob_tax . "</td>
										 <td>" . $ob_cess . "</td>
										 <td></td>
										 <td>" . $a . "</td>";
                } else {
                    $html .= " <td></td>
										 <td></td>
										 <td></td>
										 <td></td>";
                }
                $html .= "<td>" . $b_enhc_tax . "</td>
										 <td>" . $b_cess . "</td>
										 <td></td>
										 <td>" . $b . "</td>
										 <td>--</td>
										 <td>--</td>
										 <td>--</td>
										 <td>--</td>
										 ";
                $c = $property_tax + $cess;
                $cb = $cb_tax + $cb_cess;
                $html .= "<td style='white-space:pre;'>";
                $payment_date = $obcb[$key]->payment_date;
                if (($payment_date == '0000-00-00') || ($payment_date == '')) {
                    $html .= " ";
                } else {
                    $timestamp = strtotime($payment_date);
                    $date = date('d-m-Y', $timestamp);
                    $html .= "$date";
                }
                $html .= "</td>
			<td>" . $c . "</td>
														<td>" . $property_tax . "</td>
														<td>" . $cess . "</td>";
                $year = date("Y");
                $coyear = date("y");
                $addcoyear = $coyear + 1;
                $curyear = $year . '-' . $addcoyear;
                if (($prevpayment_date == "") || ($prevpayment_date == "0000-00-00")) {
                    $html .= "<td>";
                    if ($rebate > 0) {
                        $html .= "Rebate/" . $rebate . "";
                    } else {
                        echo "";
                    } $html .= "</td>";
                    $html .= "
														<td></td>
														<td></td>";
                } else {
                    $html .= "<td>";
                    if ((($rebate > 0) && ($adjtax + $adjcess) > 0)) {
                        $html .= "Rebate/" . $rebate . "";
                        $html .= "<br>";
                        $html .= "Reduction in Demand";
                    } elseif ((($rebate > 0) && ($adjtax + $adjcess) < 0)) {
                        $html .= "Rebate/" . $rebate . "";
                        $html .= "<br>";
                        $html .= "Increase in Demand";
                    } elseif ($rebate > 0) {
                        $html .= "Rebate/" . $rebate . "";
                    } elseif (($adjtax + $adjcess > 0)) {
                        $html .= "Reduction in Demand";
                    } elseif (($adjtax + $adjcess < 0)) {
                        $html .= "Increase in Demand";
                    } else {
                        $html .= "";
                    }

                    $html .= "</td>
													<td>" . $adjtax . "</td>
													<td>" . $adjcess . "</td>";
                }
                $year = date("Y");
                $coyear = date("y");
                $addcoyear = $coyear + 1;
                $curyear = $year . '-' . $addcoyear;
                if (($curyear) == ($assyear)) {
                    $html .= "<td></td>
							<td></td>
								<td></td>";
                } else {

                    $html .= "<td>" . $cb_tax . "</td>
													<td>" . $cb_cess . "</td>
													<td>" . $cb . "</td>";
                }

                $html .= "</tr>";
            }




            $html .= " </tbody>
			</table>
			<br><br><br>
			<h2 align='center'></h2>
			  <pagebreak />
			 
			  <hr />
			  ";
        }



        $html .= " 
			</body>";
        $pdfFilePath = "demand.pdf";
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
