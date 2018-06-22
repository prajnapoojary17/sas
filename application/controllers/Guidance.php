<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Name : Guidance Controller
 *
 * Description : This is used to handle guidance data 
 *
 * Created By : Gauthami
 *
 * Created Date : 01/02/2017
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 13/04/2017
 *
 */
class Guidance extends CI_Controller
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
        $this->load->model('guidance_model', '', TRUE);
        $this->load->model('ward_model', 'wards');
    }

    /**
      # Function    :    index
      # Purpose     :    Initial settings
      # params      :    None
      # Return      :    None
     */
    public function index()
    {
        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {
            $userifo = $this->session->userdata('logged_in');
            $data['role'] = $this->session->userdata('role');
            $data['username'] = $userifo['username'];
            $data['ward'] = $this->wards->display_ward();
            $data['getguidance'] = $this->guidance_model->display_guidance();
            $data['getwardroad'] = $this->guidance_model->diaplay_warroadname();
            $this->load->view('guidance_view', $data);
        } else {
            //If no session, redirect to login page
            redirect('login', 'refresh');
        }
    }

    /**
      # Function     :    add_guidance
      # Purpose      :    Insert guidance
      # params       :    None
      # Return       :    None
     */
    public function add_guidance()
    {
        if (!$this->input->post('g_id')) {
            $data = array(
                'road_name' => $this->input->post('road_name'),
                'ward_no' => $this->input->post('p_ward'),
                'gvalcents_commercial' => $this->input->post('gvalcents_commercial'),
                'gvalcents_residential' => $this->input->post('gvalcents_residential')
            );
            $dataward_road = array(
                'road_name' => $this->input->post('road_name'),
                'ward_no' => $this->input->post('p_ward')
            );
            $display_guidance = $this->guidance_model->display_guidance();
            $result = array();
            foreach ($display_guidance as $key => $value) {
                $result[] = $value->road_name;
                if (($this->input->post('road_name')) == ($value->road_name)) {
                    $match = 1;
                    break;
                } else {
                    $match = 0;
                }
            }
            if ($match == 0) {
                $this->guidance_model->add_guidance($data);
                $this->guidance_model->add_wardroadname($dataward_road);
                $roadname = $this->input->post('road_name');
                $str = "Added Guidance value for " . $roadname;
                newUserlog($str);
            }
            if ($match == 1) {
                $this->session->set_flashdata('message', 'Name Of the Road Already exists');
            }
        } else {
            $data = array(
                'road_name' => $this->input->post('road_name'),
                'ward_no' => $this->input->post('p_ward'),
                'gvalcents_commercial' => $this->input->post('gvalcents_commercial'),
                'gvalcents_residential' => $this->input->post('gvalcents_residential')
            );
            $this->guidance_model->update_guidance($data, $this->input->post('g_id'));
            $dataward_road = array(
                'road_name' => $this->input->post('road_name'),
                'ward_no' => $this->input->post('p_ward')
            );
            $this->guidance_model->update_wardroad($dataward_road,$this->input->post('gval_wardroadid'));
            $roadname = $this->input->post('road_name');
            $str = "Updated Guidance value for " . $roadname;
            newUserlog($str);
        }
        redirect('guidance', 'refresh');
    }

}
