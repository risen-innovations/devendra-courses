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

	public function courseTypeList(){
		$validToken = $this->validToken();
		$id = $this->course_model->getCourseTypes();
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
		print_r($course);
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
			http_response_code('400');
			echo json_encode(array( "status" => false, "message" => 'Bad Request, Auth Token is required.'));exit;
		}else{
			$checkToken = $account_db->select('*')->get_where('auth_tokens',array('auth_token'=>$authToken))->row();

			if(is_null($checkToken)){
				http_response_code('403');
				echo json_encode(array( "status" => false, "message" => 'Invalid Authentication Token.'));exit;
			}
			$now = time();
			$expiryDateString = strtotime($checkToken->auth_token_expiry_date);
			if($expiryDateString < $now){
				http_response_code('401');
				echo json_encode(array( "status" => false, "message" => 'Authentication Token has expired.'));exit;
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
		http_response_code('404');
		echo json_encode(array( "status" => false, "message" => 'Not Found.'));exit;
	}

	private function show_400(){
		http_response_code('400');
		echo json_encode(array( "status" => false, "message" => 'Bad Request.'));exit;
	}

	private function show_error_500(){
		http_response_code('500');
		$message = 'Internal Server Error.';
		echo json_encode(array( "status" => false, "message" => $message));exit;
	}


}
