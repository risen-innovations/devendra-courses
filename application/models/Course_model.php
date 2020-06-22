<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getCourseTypes(){
		$categories = $this->db->order_by('trade_type_name','asc')->get('trade_type');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getCourseCats(){
		$categories = $this->db->order_by('trade_category_name','asc')->get('trade_category');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getCourseLevels(){
		$categories = $this->db->order_by('trade_level_name','asc')->get('trade_level');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getCourseModes(){
		$categories = $this->db->order_by('course_mode_name','asc')->get('course_mode');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getAssessmentModes(){
		$categories = $this->db->order_by('assessment_mode_name','asc')->get('assessment_mode');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getLanguages(){
		$categories = $this->db->order_by('language_name','asc')->get('language');
		http_response_code('200');
		if($categories->num_rows() > 0){
			$data = array();
			foreach (($categories->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getCoursesByCategory($search){
		if(is_null($search)){
			$search['name'] = '';
			$search['sorting'] = 'DESC';
			$search['filter_by_name'] = '';
			$search['filter_by_value'] = '';
		}
		$courses = $this->db->select('*,s.id as sid, c.id as cid')->from('courses c')
					->join('status s','c.status = s.status_id','left')
					->join('trade_type tt','c.trade_type = tt.id',"left")
					->join('trade_category tc','c.trade_category = tc.id',"left")
					->join('trade_level tl','c.trade_level = tl.id',"left")
					->where('c.trade_type',$search['filter_by_value'])
					->order_by('course_name','ASC')->get();
		http_response_code('200');
		if($courses->num_rows() > 0){
			$data = array();
			foreach (($courses->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}
	
	public function getCoursesByName($search){
		if(is_null($search)){
			$search['name'] = '';
			$search['sorting'] = 'DESC';
			$search['filter_by_name'] = '';
			$search['filter_by_value'] = '';
		}
		$courses = $this->db->select('*,s.id as sid, c.id as cid')->from('courses c')
					->join('status s','c.status = s.status_id','left')
					->join('trade_type tt','c.trade_type = tt.id',"left")
					->join('trade_category tc','c.trade_category = tc.id',"left")
					->join('trade_level tl','c.trade_level = tl.id',"left")
					->like('course_name', $search['filter_by_value'])
					->or_like('c.short_form', $search['filter_by_value'])
					->order_by('c.course_name','ASC')->get();
		$data = array();
		foreach (($courses->result()) as $row) {
			$data[] = $row;
		}
		if($courses->num_rows() > 0){
			http_response_code('200');
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => false, "message" => 'No result',"data" =>$data));exit;
		}
	}

	public function getCoursesByType($type){
		if(is_null($type)){
			http_response_code('500');
		}
		$courses = $this->db->select('*,s.id as sid, c.id as cid')->from('courses c')
					->join('status s','c.status = s.status_id','left')
					->join('trade_type tt','c.trade_type = tt.id',"left")
					->join('trade_category tc','c.trade_category = tc.id',"left")
					->join('trade_level tl','c.trade_level = tl.id',"left")
					->like('tt.id', $type['type'])
					->order_by('c.course_name','ASC')->get();
		$data = array();
		foreach (($courses->result()) as $row) {
			$data[] = $row;
		}
		if($courses->num_rows() > 0){
			http_response_code('200');
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => false, "message" => 'No result',"data" =>$data));exit;
		}
	}

	public function getCoursesByLevel($level){
		if(is_null($level)){
			http_response_code('500');
		}
		$courses = $this->db->select('*,s.id as sid, c.id as cid')->from('courses c')
					->join('status s','c.status = s.status_id','left')
					->join('trade_type tt','c.trade_type = tt.id',"left")
					->join('trade_category tc','c.trade_category = tc.id',"left")
					->join('trade_level tl','c.trade_level = tl.id',"left")
					->like('tl.id', $level['level'])
					->order_by('c.course_name','ASC')->get();
		$data = array();
		foreach (($courses->result()) as $row) {
			$data[] = $row;
		}
		if($courses->num_rows() > 0){
			http_response_code('200');
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => false, "message" => 'No result',"data" =>$data));exit;
		}
	}

	public function getCoursesByID($search){
		if(is_null($search)){
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
		$this->db->where('c.id',$search['filter_by_value']);
		$courses = $this->db->select('*, c.id as course_id')->from('courses c')
		->join('trade_type tt','c.trade_type = tt.id',"left")
		->join('trade_category tc','c.trade_category = tc.id',"left")
		->join('trade_level tl','c.trade_level = tl.id',"left")
		->join('course_mode cm','c.course_mode = cm.id',"left")
		->join('assessment_mode am','c.assessment_mode = am.id',"left")
		->join('language l','c.language = l.id',"left")
		->join('status s','c.status = s.status_id',"left")
		->get();
		http_response_code('200');
		if($courses->num_rows() > 0){
			$data = array();
			$data[] = $courses->row();
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getCourseLists($search){
		if(is_null($search)){
			$search['name'] = 'datetime_created';
			$search['sorting'] = 'DESC';
			$search['filter_by_name'] = '';
			$search['filter_by_value'] = '';
		}
		if($search['filter_by_name'] == ''){
			$courses = $this->db->select('*,s.id as sid, c.id as cid')->from('courses c')
						->join('status s','c.status = s.status_id','left')
						->join('trade_level tl','tl.id = c.trade_level','left')
						->join('trade_type tt','tt.id = c.trade_type','left')
						->order_by('c.course_name','ASC')
						->get();
		}else{
			$courses = $this->db->select('*,s.id as sid')->from('courses c')
						->join('status s','c.status = s.status_id','left')
						->join('trade_level tl','tl.id = c.trade_level','left')
						->join('trade_type tt','tt.id = c.trade_type','left')
						->where('c.trade_category','c.'.$search['filter_by_value'])
						->order_by('c.course_name','ASC')
						->get();
		}
		http_response_code('200');
		if($courses->num_rows() > 0){
			$data = array();
			foreach (($courses->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}


	public function getExaminationsList(){
		$event_db = $this->load->database('event',TRUE);
		$events  = $event_db->select('*')->where_in('event_type',array(2,3))->get('events');
		http_response_code('200');
		if($events->num_rows() > 0){
			$data = array();
			foreach (($events->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getExaminationById($data){
		$id = $data['id'];
		$event_db = $this->load->database('event',TRUE);
		http_response_code('200');
		$lists = $event_db->select('*')->get_where('events',array('events.id'=>$id));
		if($lists->num_rows() > 0){
			$data = array();
			foreach (($lists->result()) as $row) {
				$event_learners = $event_db->select('*')->get_where('events_learners',array('event_id'=>$row->id))->result();
				if(!empty($event_learners)){
					foreach($event_learners as $learner){
						$learners[] = $learner;
					}
					$row->event_learners = $learners;
				}

				$event_breaks = $event_db->select('*')->get_where('event_breaks',array('events_id'=>$row->id))->result();
				if(!empty($event_breaks)){
					foreach($event_breaks as $break){
						$breaks[] = $break;
					}
					$row->event_breaks = $breaks;
				}
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getViewLearners(){
		$company_db = $this->load->database('company',TRUE);
		$learners  = $company_db->select('*')->get('learner');
		http_response_code('200');
		if($learners->num_rows() > 0){
			$data = array();
			foreach (($learners->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function getIndividualLearner($data){
		$company_db = $this->load->database('company',TRUE);
		$learner  = $company_db->select('*')->get_where('learner',array('learner_id'=>$data['learner_id']));
		http_response_code('200');
		if($learner->num_rows() > 0){
			$data = array();
			foreach (($learner->result()) as $row) {
				$data[] = $row;
			}
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			echo json_encode(array( "status" => true, "message" => 'No result'));exit;
		}
	}

	public function updateRetestLearner($data){
		$data['result'] = 3;
		$company_db = $this->load->database('company',TRUE);
		$update = $company_db->update('learners_results',$data,array('learner_id' => $data['learner_id']));
		if($update){
			http_response_code('200');
			$message = 'Success';
			$status = true;
			echo json_encode(array( "status" => $status, "message" => $message));exit;
		}else{
			$this->show_error_500();
		}
	}

}
