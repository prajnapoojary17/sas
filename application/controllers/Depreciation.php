<?phpif (!defined('BASEPATH'))    exit('No direct script access allowed');/** * File Name : Depreciation Controller * * Description : This is used to handle depreciation data  * * Created By : Reshma * * Created Date : 23/09/2014 * * Last Modified By : Prajna P * * Last Modified Date : 13/04/2017 * */class Depreciation extends CI_Controller{    /**      # Function    :    __construct      # Purpose     :    Class constructor      # params      :    None      # Return      :    None     */    public function __construct()    {        parent::__construct();        $this->load->model('depreciation_model', '', TRUE);    }    /**      # Function    :    index      # Purpose     :    Initial settings      # params      :    None      # Return      :    None     */    public function index()    {        if (($this->session->userdata('logged_in')) && ($this->session->userdata('role') == 'Admin')) {            $userifo = $this->session->userdata('logged_in');            $data['role'] = $this->session->userdata('role');            $data['username'] = $userifo['username'];            $data['displaydepreciation'] = $this->depreciation_model->display_depreciation();            $this->load->view('depreciation_view', $data);        } else {            //If no session, redirect to login page            redirect('login', 'refresh');        }    }    /**      # Function     :    add_depreciation      # Purpose      :    Insert depreciation      # params       :    None      # Return       :    None     */    public function add_depreciation()    {        $data = array('b_age' => $this->input->post('b_age'), 'dep' => $this->input->post('dep'));        $displaydepreciation = $this->depreciation_model->check_depreciation($this->input->post('b_age'));        if ($displaydepreciation == 0) {            $this->depreciation_model->add_depreciation($data);            $str = "Added Depreciation";            newUserlog($str);        }        if ($displaydepreciation == 1) {            $this->session->set_flashdata('message', 'Age of Building Already exists');        }        redirect('depreciation', 'refresh');    }}