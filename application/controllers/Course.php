<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/CreatorJwt.php';

class Course extends CI_Controller
{

	public function __construct()
	{ 
		parent::__construct();
		$this->load->model('course_model');
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');
	}

	public function lists(){
		$validToken = $this->validToken();
		$this->setAuditLog($validToken,35);
		$data = file_get_contents('php://input');
		$search = json_decode($data,true);
		$auditLog = $this->course_model->getCourseLists($search);
	}

	public function tradeTypeList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getTradeTypes();
	}

	public function courseCatList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getCourseCats();
	}

	public function courseLevelList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getCourseLevels();
	}

	public function courseModeList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getCourseModes();
	}

	public function assessmentModeList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getAssessmentModes();
	}

	public function languagesList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getLanguages();
	}

	public function listsByCategory(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$cat = json_decode($data,true);
		if(is_null($cat)){
			$this->show_400();
		}
		$id = $this->course_model->getCoursesByCategory($cat);
	}

	public function listsByType(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$types = json_decode($data,true);
		if(is_null($types)){
			$this->show_400();
		}
		$id = $this->course_model->getCoursesByType($types);
	}

	public function listsByLevel(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$level = json_decode($data,true);
		if(is_null($level)){
			$this->show_400();
		}
		$id = $this->course_model->getCoursesByLevel($level);
	}

	public function listsByName(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$cname = json_decode($data,true);
		if(is_null($cname)){
			$this->show_400();
		}
		$id = $this->course_model->getCoursesByName($cname);
	}

	public function addCourse(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$courseData = json_decode($data,true);
		if(is_null($courseData)){
			$this->show_400();
		}
		$this->db->insert('courses',$courseData);
		$insert_id =  $this->db->insert_id();
		if($insert_id){
			$this->setAuditLog($validToken,36);
			http_response_code('200');
			$data =  $this->db->select('*')->get_where('courses',array('id'=>$insert_id))->row();
			echo json_encode(array( "status" => true, "message" => 'Success',"data" =>$data));exit;
		}else{
			$this->show_error_500();
		}
	}

	public function viewCourse(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$courseData = json_decode($data,true);
		if(is_null($courseData)){
			$this->show_400();
		}
		$course =   $this->course_model->getCoursesByID($courseData);
		//print_r($course);
		if(is_null($course)){
			$this->show_404();
		}
	}

	public function updateCourse(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$courseData = json_decode($data,true);
		if(is_null($courseData)){
			$this->show_400();
		}
		$course =   $this->db->select('*')->get_where('courses',array('id'=>$courseData['id']))->row();
		if(is_null($course)){
			$this->show_404();
		}
		$update = $this->db->update('courses',$courseData,array('id' => $courseData['id']));
		if($update){
			$this->setAuditLog($validToken,36);
			http_response_code('200');
			echo json_encode(array( "status" => true, "message" => 'Success',"data" => $courseData));exit;
		}else{
			$this->show_error_500();
		}
	}

	public function getVenues(){
		$validToken = $this->validToken();
		$this->db->select('*')->from('venues')
		->order_by('status', 'DESC');
		$venues = $this->db->order_by('name', 'ASC')->get();
		http_response_code('200');
		echo json_encode(array( "status" => true, "message" => 'Success',"data" => $venues->result()));exit;
	}

	public function getVenue(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$venueID = json_decode($data,true);
		$venue =   $this->db->select('*')->from('venues')->where("id",$venueID['id'])->get()->row();
		http_response_code('200');
		echo json_encode(array( "status" => true, "message" => 'Success',"data" => $venue));exit;
	}

	public function addVenue(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$venueData = json_decode($data,true);
		if(is_null($venueData)){
			$this->show_400();
		}
		$venue =   $this->db->insert('venues',$venueData);
		http_response_code('200');
		echo json_encode(array( "status" => true, "message" => 'Success',"data" => $venue));exit;
	}

	public function updateVenue(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$venueData = json_decode($data,true);
		if(is_null($venueData)){
			$this->show_400();
		}
		$id = $venueData['id'];
		unset($venueData['id']);
		$venue =   $this->db->where('id',$id)->update('venues',$venueData);
		http_response_code('200');
		echo json_encode(array( "status" => true, "message" => 'Success',"data" => $venue));exit;
	}

	public function examinationsList(){
		$validToken = $this->validToken();
		$this->setAuditLog($validToken,38);
		$data = file_get_contents('php://input');
		$search = json_decode($data,true);
		$lists = $this->course_model->getExaminationsList();
	}

	public function viewExaminationById(){
		$validToken = $this->validToken();
		$this->setAuditLog($validToken,39);
		$data = file_get_contents('php://input');
		$data = json_decode($data,true);
		$examination = $this->course_model->getExaminationById($data);
	}

	public function viewLearners(){
		$validToken = $this->validToken();
		$this->setAuditLog($validToken,40);
		$data = file_get_contents('php://input');
		$search = json_decode($data,true);
		$lists = $this->course_model->getViewLearners();
	}

	public function viewIndividualLearner(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$data = json_decode($data,true);
		$this->setAuditLog($validToken,34);
		$examination = $this->course_model->getIndividualLearner($data);
	}

	public function updateRetestLearner(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$data = json_decode($data,true);
		$this->setAuditLog($validToken,33);
		$examination = $this->course_model->updateRetestLearner($data);
	}

	public function getStatsByCourses(){
		$validToken = $this->validToken();
		$data = file_get_contents('php://input');
		$data = json_decode($data,true);
		$start_date = strtotime($data['selected_period']);
		$start_date = date("Y-m-d 00:00:00", $start_date);
		$end_date = strtotime("+3 months", strtotime($data['selected_period']));
		$end_date = date("Y-m-t 23:59:59", $end_date);
		$courses = $this->db->select("*")->from("courses c")->get();
		if($courses->num_rows() > 0){
			$scheduling_db = $this->load->database("event",true);
			foreach($courses->result() as $c){
				$c->learners_total = 0;
				$c->sg = 0;
				$c->foreigner = 0;
				$training_dates = $scheduling_db->select("e.id, date, count(ed.id) as count")->from("events e")
									->join("events_dates ed","e.id = ed.event_id","left")
									->where("e.course_id", $c->id)
									->where("ed.date <=", $end_date)
									->where("ed.date >=", $start_date)
									->get()->result();
				$c->training_dates = $training_dates;
				foreach($training_dates as $date){
					if(date('N', strtotime($date->date)) >= 6){
						$c->weekend = true;
						break;
					}elseif($date->date == null){
						$c->weekend = null;
					}else{
						$c->weekend = false;
					}
					$c->count = $date->count;
					$learners = $scheduling_db->select('learner_id, count(learner_id) as count')->from('events_learners')
									->where('event_id', $date->id)->get();
					$learners_array = array();
					if($learners->num_rows() > 0){
						$co_db = $this->load->database("company", true);
						foreach($learners->result() as $l){
							$nationality = $co_db->select("nationality")->from("learner")
											->where("learner_id", $l->learner_id)
											->get();
							if($nationality->num_rows() > 0){
								if($nationality->row()->nationality == 196){
									$c->sg += 1;
								}else{
									$c->foreigner += 1;
								}
							}
							$c->learners_total += $l->count;
						}
					}
				}
			}
			http_response_code("200");
			echo json_encode(array( "status" => true, "message" => 'Success' , "data"=>$courses->result()));exit;
		}else{
			http_response_code("200");
			echo json_encode(array( "status" => false, "message" => 'No Rows Found' , "data"=>null));exit;
		}
	}

	private function setAuditLog($data,$api_id){
		$audit_db = $this->load->database('audit_log',TRUE);
		$logs = array(
			'api_id' => $api_id,
			'service' => 4 ,
			'subject_company' => $data->company,
			'action_by' => $data->user_id
		);
		return $audit_db->insert('audit_log',$logs);
	}

	private function validToken(){
		$account_db = $this->load->database('account',TRUE);
		$authToken = $this->input->get_request_header('Authorization', TRUE);
		if(is_null($authToken)){
			http_response_code('200');
			echo json_encode(array( "status" => false, "message" => 'Bad Request, Auth Token is required.', "data"=>null));exit;
		}else{
			$checkToken = $account_db->select('*')->get_where('auth_tokens',array('auth_token'=>$authToken))->row();

			if(is_null($checkToken)){
				http_response_code('200');
				echo json_encode(array( "status" => false, "message" => 'Invalid Authentication Token.' , "data"=>null));exit;
			}
			$now = time();
			$expiryDateString = strtotime($checkToken->auth_token_expiry_date);
			if($expiryDateString < $now){
				http_response_code('200');
				echo json_encode(array( "status" => false, "message" => 'Authentication Token has expired.' , "data"=>null));exit;
			}
			$decodeJWT = $this->objOfJwt->DecodeToken($checkToken->issued_to);
			$data = $account_db->get_where('accounts',array('user_id'=>$decodeJWT['user_id']))->row();
			if(is_null($data)){
				$this->show_error_500();
			}
			return $data;
		}
	}

	private function show_404(){
		http_response_code('200');
		echo json_encode(array( "status" => false, "message" => 'Not Found.' , "data"=>null));exit;
	}

	private function show_400(){
		http_response_code('200');
		echo json_encode(array( "status" => false, "message" => 'Bad Request.' , "data"=>null));exit;
	}

	private function show_error_500(){
		http_response_code('200');
		$message = 'Internal Server Error.';
		echo json_encode(array( "status" => false, "message" => $message , "data"=>null));exit;
	}


}
