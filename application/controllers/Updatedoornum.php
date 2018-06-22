<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updatedoornum extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('updatedoor_model','',TRUE);
	}

	public function index()
	{    
        $doornumbers = $this->updatedoor_model->getdoornum();
        $data = array();
        foreach($doornumbers as $doornum){
        $dnum = $doornum['door_no'];
        $c = explode("-", $dnum);
            $first = $c[0];
            $second = $c[1];            
            if(is_numeric($first)){
                $datevalue = '12/'.$first;
                $data[] = array(
                    'sl_no' => $doornum['sl_no'],
                    'door_no' => $datevalue
                );            
            } else {
                $datevalue = '12/'.$second;
                $data[] = array(
                    'sl_no' => $doornum['sl_no'],
                    'door_no' => $datevalue
                );            
            }       
        }
        $this->updatedoor_model->updatedoornum($data);
	}
	
    public function updateyear()
    {
        $years = $this->updatedoor_model->getyears();
        print_r($years);         
        $data = array();
        foreach($years as $year){
            $a = $year['p_year'];
            $c = explode("-", $a);
            $first = $c[0];
            $second = $c[1];
            //echo $first;
            //echo strlen($second);
            if(strlen($second) == 4) {
             $part = substr($second,2,2);             
             $res = $first.'-'.$part;
             $data[] = array(
                'sl_no' => $year['sl_no'],
                'p_year' => $res
             );
             
            }
        }
        //print_r($data); exit;
        $this->updatedoor_model->updateyear($data);
    }

}
?>