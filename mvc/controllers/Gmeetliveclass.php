<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Gmeetliveclass extends Admin_Controller
{
    /*
    | -----------------------------------------------------
    | PRODUCT NAME:     INILABS SCHOOL MANAGEMENT SYSTEM
    | -----------------------------------------------------
    | AUTHOR:            INILABS TEAM
    | -----------------------------------------------------
    | EMAIL:            info@inilabs.net
    | -----------------------------------------------------
    | COPYRIGHT:        RESERVED BY INILABS IT
    | -----------------------------------------------------
    | WEBSITE:            http://inilabs.net
    | -----------------------------------------------------
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("gmeetliveclass_m");
        $this->load->model('usertype_m');
        $this->load->model("section_m");
        $this->load->model("classes_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('gmeetliveclass', $language);
    }

    public function index()
    {
        $sections = $this->section_m->general_get_section();

        $this->data['classes']       = pluck($this->classes_m->general_get_classes(), 'classes', 'classesID');
        $this->data['sections']      = pluck($sections, 'section', 'sectionID');
        $this->data['classSections'] = pluck_multi_array($sections, 'section', 'classesID');

        $this->data['gmeetliveclasses'] = $this->gmeetliveclass_m->get_gmeetliveclass_with_condition($this->session->userdata('defaultschoolyearID'));

        $this->data["subview"] = "gmeetliveclass/index";
        $this->load->view('_layout_main', $this->data);

    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/editor/jquery-te-1.4.0.css',
                'assets/datetimepicker/datetimepicker.css',
            ),
            'js'  => array(
                'assets/editor/jquery-te-1.4.0.min.js',
                'assets/datetimepicker/moment.js',
                'assets/datetimepicker/datetimepicker.js',

            ),
        );

        $this->data['classes'] = $this->classes_m->get_classes();
        $classesID             = $this->input->post("classesID");
        if ($classesID > 0) {
            $this->data['sections'] = $this->section_m->get_order_by_section(array("classesID" => $classesID));
        } else {
            $this->data['sections'] = [];
        }

        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "gmeetliveclass/add";
                $this->load->view('_layout_main', $this->data);
            } else {

                $array["title"]             = $this->input->post("title");
                $array["date"]              = date("Y-m-d H:i:s", strtotime($this->input->post("date")));
                $array["classesID"]         = $this->input->post("classesID");
                $array["sectionID"]         = $this->input->post("sectionID");
                $array["status"]            = $this->input->post("status");
                $array["duration"]          = $this->input->post("duration");
                $array["url"]               = $this->input->post("url");
                $array["description"]       = $this->input->post("description");
                $array["host"]              = $this->session->userdata('name');
                $array["create_date"]       = date("Y-m-d h:i:s");
                $array["modify_date"]       = date("Y-m-d h:i:s");
                $array["create_userID"]     = $this->session->userdata('loginuserID');
                $array["create_usertypeID"] = $this->session->userdata('usertypeID');
                $array['schoolyearID']      = $this->session->userdata('defaultschoolyearID');

                $this->gmeetliveclass_m->insert_gmeetliveclass($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("gmeetliveclass/index"));
            }
        } else {
            $this->data["subview"] = "gmeetliveclass/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/editor/jquery-te-1.4.0.css',
                'assets/datetimepicker/datetimepicker.css',
            ),
            'js'  => array(
                'assets/editor/jquery-te-1.4.0.min.js',
                'assets/datetimepicker/moment.js',
                'assets/datetimepicker/datetimepicker.js',

            ),
        );
        $id = htmlentities(escapeString($this->uri->segment(3)));

        if ((int) $id) {
            $this->data['gmeetliveclass'] = $this->gmeetliveclass_m->get_single_gmeetliveclass(['gmeetliveclassID'=> $id]);
            if (customCompute($this->data['gmeetliveclass'])) {

                $this->data['classes'] = $this->classes_m->get_classes();

                $classesID = $this->input->post("classesID");
                if (!$classesID) {
                    $classesID = $this->data['gmeetliveclass']->classesID;
                }
                $this->data['sections'] = $this->section_m->get_order_by_section(array("classesID" => $classesID));

                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "gmeetliveclass/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
                        $array["title"]        = $this->input->post("title");
                        $array["date"]         = date("Y-m-d H:i:s", strtotime($this->input->post("date")));
                        $array["classesID"]    = $this->input->post("classesID");
                        $array["sectionID"]    = $this->input->post("sectionID");
                        $array["status"]       = $this->input->post("status");
                        $array["duration"]     = $this->input->post("duration");
                        $array["url"]          = $this->input->post("url");
                        $array["description"]  = $this->input->post("description");
                        $array["host"]         = $this->session->userdata('name');
                        $array["modify_date"]  = date("Y-m-d h:i:s");
                        $array['schoolyearID'] = $this->session->userdata('defaultschoolyearID');

                        $this->gmeetliveclass_m->update_gmeetliveclass($array, $id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("gmeetliveclass/index"));
                    }
                } else {
                    $this->data["subview"] = "gmeetliveclass/edit";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete()
    {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $gmeetliveclass = $this->gmeetliveclass_m->get_single_gmeetliveclass(['gmeetliveclassID'=> $id]);
            if (customCompute($gmeetliveclass)) {
                $this->gmeetliveclass_m->delete_gmeetliveclass($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("gmeetliveclass/index"));
            } else {
                redirect(base_url("gmeetliveclass/index"));
            }
        } else {
            redirect(base_url("gmeetliveclass/index"));
        }
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'title',
                'label' => $this->lang->line("gmeetliveclass_title"),
                'rules' => 'trim|required|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'date',
                'label' => $this->lang->line("gmeetliveclass_date"),
                'rules' => 'trim|required|xss_clean|max_length[19]|callback_date',
            ),
            array(
                'field' => 'duration',
                'label' => $this->lang->line("gmeetliveclass_duration"),
                'rules' => 'trim|required|numeric|xss_clean|max_length[60]|callback_valid_duration',
            ),
            array(
                'field' => 'classesID',
                'label' => $this->lang->line("gmeetliveclass_classes"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_data',
            ),
            array(
                'field' => 'sectionID',
                'label' => $this->lang->line("gmeetliveclass_section"),
                'rules' => 'trim|numeric|max_length[11]|xss_clean',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line("gmeetliveclass_status"),
                'rules' => 'trim|required|numeric|max_length[5]|xss_clean|callback_unique_data',
            ),
            array(
                'field' => 'url',
                'label' => $this->lang->line("gmeetliveclass_gmeet_url"),
                'rules' => 'trim|required|xss_clean|max_length[200]|callback_custom_url',
            ),
            array(
                'field' => 'description',
                'label' => $this->lang->line("gmeetliveclass_description"),
                'rules' => 'trim|xss_clean',
            ),

        );
        return $rules;
    }

    public function unique_data($data)
    {
        if ($data == 0) {
            $this->form_validation->set_message('unique_data', 'The %s field is required.');
            return false;
        }
        return true;
    }

    public function date($date)
    {
        if (!empty($date)) {
            if (strlen($date) < 19) {
                $this->form_validation->set_message("date", "%s is invalid");
                return false;
            } else {
                $format   = 'd-m-Y h:i A';
                $dateTime = DateTime::createFromFormat($format, $date);
                if ($dateTime instanceof DateTime && $dateTime->format('d-m-Y h:i A') == $date) {
                    return true;
                } else {
                    $this->form_validation->set_message("date", "%s is invalid");
                    return false;
                }
            }
        } else {
            $this->form_validation->set_message("date", "The %s field is required.");
            return false;
        }
    }

    public function sectioncall()
    {
        $classID = $this->input->post('id');
        if ((int) $classID) {
            $allsection = $this->section_m->get_order_by_section(array("classesID" => $classID));
            echo "<option value='0'>", $this->lang->line("gmeetliveclass_select_section"), "</option>";
            foreach ($allsection as $value) {
                echo "<option value=\"$value->sectionID\">", $value->section, "</option>";
            }
        }
    }

    public function valid_duration($data)
    {
        if ($data && $data < 1) {
            $this->form_validation->set_message("valid_duration", "The %s is invalid number");
            return false;
        }
        return true;
    }

    public function custom_url($url)
    {
        if ($url) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return true;
            } else {
                $this->form_validation->set_message("custom_url", "The %s field must contain a valid URL.");
                return false;
            }
        }
        return true;
    }

}
