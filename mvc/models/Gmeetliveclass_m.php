<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Gmeetliveclass_m extends MY_Model
{

    protected $_table_name     = 'gmeetliveclass';
    protected $_primary_key    = 'gmeetliveclassID';
    protected $_primary_filter = 'intval';
    protected $_order_by       = "date desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_gmeetliveclass($array = null, $signal = false)
    {
        $query = parent::get($array, $signal);
        return $query;
    }

    public function get_gmeetliveclass_with_condition($schoolYearId)
    {
        $classes      = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
        $sections     = [];
        $usertypeID   = $this->session->userdata("usertypeID");
        $loginuserID  = $this->session->userdata('loginuserID');
        $schoolyearID = $this->session->userdata('defaultschoolyearID');

        if ($usertypeID == 3) {
            $student                       = $this->studentrelation_m->get_single_student(array('srstudentID' => $loginuserID, 'srschoolyearID' => $schoolyearID), false);
            $sections[$student->sectionID] = $student->sectionID;

        } else {
            $sections = pluck($this->section_m->get_section(), 'sectionID', 'sectionID');
        }

        $this->db->select('*');
        $this->db->from($this->_table_name);

        if (customCompute($classes) || customCompute($sections)) {
            $this->db->or_group_start();
            if (customCompute($classes)) {
                $this->db->group_start();
                foreach ($classes as $classes) {
                    $this->db->or_where('classesID', $classes);
                }
                $this->db->or_where('classesID', 0);
                $this->db->group_end();
            }

            if (customCompute($sections)) {
                $this->db->group_start();
                foreach ($sections as $section) {
                    $this->db->or_where('sectionID', $section);
                }
                $this->db->or_where('sectionID', 0);
                $this->db->group_end();
            }

            $this->db->group_end();
        }

        $this->db->where(['schoolyearID' => $schoolYearId]);
        $this->db->order_by($this->_order_by);

        $query = $this->db->get();
        return $query->result();

    }

    public function get_single_gmeetliveclass($array=NULL) 
    {
        $query = parent::get_single($array);
        return $query;
    }

    public function insert_gmeetliveclass($array)
    {
        return parent::insert($array);
    }

    public function update_gmeetliveclass($data, $id = null)
    {
        parent::update($data, $id);
        return $id;
    }

    public function delete_gmeetliveclass($id)
    {
        parent::delete($id);
    }

}
