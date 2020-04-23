<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {

			if ($this->session->userdata('quiz_data')['user_id']) {
				$this->session->unset_userdata('quiz_data');
			}
			// print_r($_SESSION);
			$data['title'] = "Volunteer | Dashbaord";
			$this->load->view('volunteer/header', $data);
			$this->load->view('volunteer/dashboard');
		}
	}
	public function setQuiz()
	{
		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {
			// $this->load->helper('date');
			// date_default_timezone_set('\Asia/Kolkata');
			$add_record = array(
				'class' => strip_tags(trim($this->input->post('class'))),
				'subject' => strip_tags(trim($this->input->post('subject'))),
				'chapter' => strip_tags(trim($this->input->post('chapter'))),
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
			);
			// print_r($add_record);
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$query_result = $this->mq->set_quiz($add_record);
			if ($query_result) {
				// if (isset($this->session->userdata('quiz_data')['user_id'])) {
				//     $this->session->unset_userdata('quiz_data');
				// }
				$add_record['q_id'] = $query_result['0']['q_id'];
				$this->session->set_userdata('quiz_data', $add_record);
				redirect(base_url('volunteer/Dashboard/mcqQuestion'));
			}
		}
	}
	public function mcqQuestion()
	{
		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['title'] = "Volunteer | MCQ Question";
			$this->load->view('volunteer/header', $data);

			if ($this->session->userdata('quiz_volunteer')['type'] === '1') {

				if (isset($this->session->userdata('quiz_data')['q_id'])) {
					$data['already_quiz'] = $this->mq->apply_quizes($this->session->userdata('quiz_data')['q_id']);
				}
				// print_r($data['already_quiz']);
				$this->load->view('volunteer/mcq_question', $data);
			} elseif ($this->session->userdata('quiz_volunteer')['type'] === '2') {
				$data['prof_question'] = $this->mq->prof_view_question('Submitted');
				// print_r($data['prof_question']);
				$this->load->view('volunteer/approve_question', $data);
			}
		}
	}
	public function addquestion()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		$this->load->model('volunteer/Model_volunteer', 'mq');
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Get the form fields and remove whitespace.
			$this->load->library('S3');
			// print_r($_FILES);

			$mcq_response = array(
				'question' => htmlspecialchars(strip_tags(trim($this->input->post('mcq_question')))),
				'option_a' => htmlspecialchars(strip_tags(trim($this->input->post('option_a')))),
				'option_b' => htmlspecialchars(strip_tags(trim($this->input->post('option_b')))),
				'option_c' => htmlspecialchars(strip_tags(trim($this->input->post('option_c')))),
				'option_d' => htmlspecialchars(strip_tags(trim($this->input->post('option_d')))),
				'solution' => htmlspecialchars(strip_tags(trim($this->input->post('solution')))),
				'link' => strip_tags(trim($this->input->post('solution_link'))),
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
				'q_id' => $this->session->userdata('quiz_data')['q_id'],
				'type' => 'New Question',
			);
			if ($_FILES["question_image"]["size"] > 0) {
				$ques_upload = false;
				$ext1 = strtolower(pathinfo(basename($_FILES['question_image']['name']), PATHINFO_EXTENSION));

				if ($ext1 == "png" || $ext1 == "jpeg" || $ext1 == "jpg") {
					$filenameQ = $_FILES['question_image']['tmp_name'];
					$fileUploadNameQ = $mcq_response['q_id'] . $_FILES['question_image']['name'];
					// $mcq_response['ques_link'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameQ;
					if ($this->s3->putObjectFile($filenameQ, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadNameQ, S3::ACL_PRIVATE)) {
						$mcq_response['ques_link'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameQ;
						$ques_upload = true;
					}
				} else {
					$this->session->set_flashdata('Uploading Fail', 'File Format Not Supported');
					// redirect(base_url('volunteer/Dashboard/mcqQuestion'));
				}
			}
			if ($_FILES["option_image_a"]["size"] > 0) {
				$solution_upload = false;
				$ext2 = strtolower(pathinfo(basename($_FILES['option_image_a']['name']), PATHINFO_EXTENSION));

				if ($ext2 == "png" || $ext2 == "jpeg" || $ext2 == "jpg") {
					$filenameO = $_FILES['option_image_a']['tmp_name'];
					$fileUploadNameO = $mcq_response['q_id'] . $_FILES['option_image_a']['name'];
					// $mcq_response['option_link_'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
					if ($this->s3->putObjectFile($filenameO, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadNameO, S3::ACL_PRIVATE)) {
						$mcq_response['option_link_a'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
						$solution_upload = true;
					}
				} else {
					$this->session->set_flashdata('Uploading Fail', 'File Format Not Supported');
					// redirect(base_url('volunteer/Dashboard/mcqQuestion'));
				}
			}
			if ($_FILES["option_image_b"]["size"] > 0) {
				$solution_upload = false;
				$ext2 = strtolower(pathinfo(basename($_FILES['option_image_b']['name']), PATHINFO_EXTENSION));

				if ($ext2 == "png" || $ext2 == "jpeg" || $ext2 == "jpg") {
					$filenameO = $_FILES['option_image_b']['tmp_name'];
					$fileUploadNameO = $mcq_response['q_id'] . $_FILES['option_image_b']['name'];
					// $mcq_response['option_link_'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
					if ($this->s3->putObjectFile($filenameO, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadNameO, S3::ACL_PRIVATE)) {
						$mcq_response['option_link_b'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
						$solution_upload = true;
					}
				} else {
					$this->session->set_flashdata('Uploading Fail', 'File Format Not Supported');
					// redirect(base_url('volunteer/Dashboard/mcqQuestion'));
				}
			}
			if ($_FILES["option_image_c"]["size"] > 0) {
				$solution_upload = false;
				$ext2 = strtolower(pathinfo(basename($_FILES['option_image_c']['name']), PATHINFO_EXTENSION));

				if ($ext2 == "png" || $ext2 == "jpeg" || $ext2 == "jpg") {
					$filenameO = $_FILES['option_image_c']['tmp_name'];
					$fileUploadNameO = $mcq_response['q_id'] . $_FILES['option_image_c']['name'];
					// $mcq_response['option_link_'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
					if ($this->s3->putObjectFile($filenameO, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadNameO, S3::ACL_PRIVATE)) {
						$mcq_response['option_link_c'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
						$solution_upload = true;
					}
				} else {
					$this->session->set_flashdata('Uploading Fail', 'File Format Not Supported');
					// redirect(base_url('volunteer/Dashboard/mcqQuestion'));
				}
			}
			if ($_FILES["option_image_d"]["size"] > 0) {
				$solution_upload = false;
				$ext2 = strtolower(pathinfo(basename($_FILES['option_image_d']['name']), PATHINFO_EXTENSION));

				if ($ext2 == "png" || $ext2 == "jpeg" || $ext2 == "jpg") {
					$filenameO = $_FILES['option_image_d']['tmp_name'];
					$fileUploadNameO = $mcq_response['q_id'] . $_FILES['option_image_d']['name'];
					// $mcq_response['option_link_'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
					if ($this->s3->putObjectFile($filenameO, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadNameO, S3::ACL_PRIVATE)) {
						$mcq_response['option_link_d'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadNameO;
						$solution_upload = true;
					}
				} else {
					$this->session->set_flashdata('Uploading Fail', 'File Format Not Supported');
					// redirect(base_url('volunteer/Dashboard/mcqQuestion'));
				}
			}
			if (isset($ques_upload) || isset($solution_upload)) {
				// echo 'Working Fine';
			}
			// print_r($mcq_response);
			if ($this->mq->add_question($mcq_response)) {
				$this->session->set_flashdata('Uploading Success', 'File Uploaded successfullty');
				redirect(base_url('volunteer/Dashboard/mcqQuestion'));
			}
		}
	}

	public function approve_question()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->approve_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/mcqQuestion');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
	public function edit_question()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$edit_ques = array(
				'question' => htmlspecialchars(strip_tags(trim($this->input->post('mcq_question')))),
				'option_a' => htmlspecialchars(strip_tags(trim($this->input->post('option_a')))),
				'option_b' => htmlspecialchars(strip_tags(trim($this->input->post('option_b')))),
				'option_c' => htmlspecialchars(strip_tags(trim($this->input->post('option_c')))),
				'option_d' => htmlspecialchars(strip_tags(trim($this->input->post('option_d')))),
				'solution' => htmlspecialchars(strip_tags(trim($this->input->post('solution')))),
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
				'type' => 'Updated Question',
			);
			// print_r($edit_ques);

			$this->load->model('volunteer/Model_volunteer', 'mq');
			if ($this->mq->edit_question_volunteer($this->uri->segment(4), $edit_ques, $_SESSION['table_name'])) {
				redirect('volunteer/Dashboard/mcqQuestion');
			}
			redirect('volunteer/Dashboard');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
	public function prof_approve_question()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->prof_approve_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/mcqQuestion');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
	public function prof_delete_question()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->prof_delete_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/mcqQuestion');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
	public function editQuestion($quiz_id)
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->session->userdata('quiz_volunteer')['type'] === '2') {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['title'] = "Volunteer | Edit Question";
			$this->load->view('volunteer/header', $data);
			$data['all_ques'] = $this->mq->fetch_a_question($quiz_id)[0];
			$_SESSION['table_name'] = "temp_add_ques";
			if (count($data)) {
				$this->load->view('volunteer/edit_question', $data);
			} else {
				redirect(base_url('volunteer/Dashboard/mcqQuestion'));
			}
		} else {
			redirect(base_url('volunteer/Dashboard/mcqQuestion'));
		}
	}
	public function reportedQuestions()
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		} elseif ($this->session->userdata('quiz_volunteer')['type'] === '2') {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['reported_ques'] = $this->mq->fetch_report_question();
			$data['title'] = "Volunteer | Reported Question";
			$this->load->view('volunteer/header', $data);
			$this->load->view('volunteer/report_question', $data);
		}
	}
	public function editReportQuestion($quiz_id)
	{
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->session->userdata('quiz_volunteer')['type'] === '2') {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['title'] = "Volunteer | Edit Question";
			$this->load->view('volunteer/header', $data);
			$data['all_ques'] = $this->mq->fetch_a_report_question($quiz_id)['0'];
			$_SESSION['table_name'] = "add_quiz";
			if (count($data)) {
				$this->load->view('volunteer/edit_question', $data);
			} else {
				redirect(base_url('volunteer/Dashboard/reportedQuestion'));
			}
		} else {
			redirect(base_url('volunteer/Dashboard/reportedQuestion'));
		}
	}

	public function add_upload()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			if (!$this->session->userdata('quiz_volunteer')['user_id']) {
				redirect(base_url('volunteer/login'));
			}
			$this->load->library('S3');
			if (($this->input->post('topic') != '' || $this->input->post('topic2') != '') || ($this->input->post('file') != '' || $this->input->post('urls') != '')) {

				$data = array(
					'class' => htmlspecialchars($this->input->post('class')),
					'whois' => 'admin',
					'name' => 'Intellify',
					'subject' => htmlspecialchars($this->input->post('subject')),
					'Chapter_number' => htmlspecialchars($this->input->post('chapterN')),
					'chapter' => htmlspecialchars($this->input->post('chapter')),
					'topic' => htmlspecialchars($this->input->post('topic')),
					'topic2' => htmlspecialchars($this->input->post('topic2')),
					'language' => htmlspecialchars($this->input->post('language')),
					'board' => htmlspecialchars($this->input->post('board')),
					'type' => htmlspecialchars($this->input->post('type')),
					'add_by' => $this->session->userdata('quiz_volunteer')['user_id'],
				);
				// print_r($data);
				$ext = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
				$this->load->model(adminpath . '/Model_Skills', 'ms');
				if ($ext == "pdf" || $ext == "PDF") {

					$filename = $_FILES['file']['tmp_name'];
					$fileUploadName = 'Class_' . $data['class'] . '_Subject_' . $data['subject'] . '__' . $_FILES['file']['name'];
					if ($this->s3->putObjectFile($filename, "s3-intellify", 'Intellify_IMG/Skill_IMG/' . $fileUploadName, S3::ACL_PRIVATE)) {

						$data['url'] = 'https://s3-intellify.s3.ap-south-1.amazonaws.com/Intellify_IMG/Skill_IMG/' . $fileUploadName;
						$data['link'] = htmlspecialchars($this->input->post('urls'));
						// print_r($data);
						$this->ms->addResources($data);

						$this->session->set_flashdata('skillAddSuccess', 'File added successfully');
						redirect(base_url('volunteer/Dashboard'));
					}
				} else if (htmlspecialchars($this->input->post('urls'))) {

					$data['link'] = htmlspecialchars($this->input->post('urls'));
					$this->ms->addResources($data);

					$this->session->set_flashdata('skillAddSuccess', 'File added successfully');
					redirect(base_url('volunteer/Dashboard'));
				} else {
					$this->session->set_flashdata('skillAddFail', 'Wrong File extension!!');
					redirect(base_url('volunteer/Dashboard'));
				}
			} else {

				$this->session->set_flashdata('skillAddFail', 'Something Went Wrong');
				redirect(base_url('volunteer/Dashboard'));
			}
		} else {

			redirect(base_url('volunteer/Dashboard'));
		}
	}
	public function showResources(){
		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {
			$data['title'] = "Volunteer | Resources Added";
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['result'] = $this->mq->get_resources($this->session->userdata('quiz_volunteer')['user_id']);
			// $data['result'] = $this->mq->get_resources('ADMIN!@#');
			$this->load->view('volunteer/header', $data);
			$this->load->view('volunteer/check_resources');
		}
	}
	public function subjective() {
		

		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['title'] = "Volunteer | subjective Question";
			$this->load->view('volunteer/header', $data);

			if ($this->session->userdata('quiz_volunteer')['type'] === '1') {

				if (isset($this->session->userdata('quiz_data')['q_id'])) {
					$data['already_quiz'] = $this->mq->apply_quizes($this->session->userdata('quiz_data')['q_id']);
				}
				 //print_r($data);
				$this->load->view('volunteer/sub_question', $data);
			} elseif ($this->session->userdata('quiz_volunteer')['type'] === '2') {
				//$this->mq->display();
				/*$data = $this->mq->display();
				foreach ($data as $row) {
					echo ''.$row->q_id.''; 
echo ''.$row->user_id.''; 
echo ''.$row->question.''; 
echo ''.$row->explanation.''; 
echo ''.$row->answer.''; 
					# code...
				}*/
				$data['prof_question'] = $this->mq->prof_subview_question('Submitted');
				// print_r($data['prof_question']);
			$this->load->view('volunteer/approvesub_question', $data);
			}
		}
	}

	public function setsubQuiz() {
		if (!isset($this->session->userdata('quiz_volunteer')['user_id'])) {
			redirect(base_url('volunteer/login'));
		} else {
			// $this->load->helper('date');
			// date_default_timezone_set('\Asia/Kolkata');
			$add_record = array(
				'class' => strip_tags(trim($this->input->post('class'))),
				'subject' => strip_tags(trim($this->input->post('subject'))),
				'chapter' => strip_tags(trim($this->input->post('chapter'))),
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
			);
			// print_r($add_record);
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$query_result = $this->mq->set_quiz($add_record);
			if ($query_result) {
				// if (isset($this->session->userdata('quiz_data')['user_id'])) {
				//     $this->session->unset_userdata('quiz_data');
				// }
				$add_record['q_id'] = $query_result['0']['q_id'];
				$this->session->set_userdata('quiz_data', $add_record);
				redirect(base_url('volunteer/Dashboard/subjective'));
			}
		}
	}

	public function addsubquestion() {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		$this->load->model('volunteer/Model_volunteer', 'mq');
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Get the form fields and remove whitespace.
			$this->load->library('S3');
			// print_r($_FILES);

			$mcq_response = array(
				'question' => htmlspecialchars(strip_tags(trim($this->input->post('mcq_question')))),
				'answer' => htmlspecialchars(strip_tags(trim($this->input->post('answer')))),
				'explanation' => htmlspecialchars(strip_tags(trim($this->input->post('explanation')))),
				
				
				
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
				'q_id' => $this->session->userdata('quiz_data')['q_id'],
				'type' => 'New Question',
			);
			
			// print_r($mcq_response);
			if ($this->mq->add_question($mcq_response)) {
				
				redirect(base_url('volunteer/Dashboard/subjective'));
			}
		}
	}
	public function editsub_question() {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$edit_ques = array(
				'question' => htmlspecialchars(strip_tags(trim($this->input->post('mcq_question')))),
				'answer' => htmlspecialchars(strip_tags(trim($this->input->post('answer')))),

				'explanation' => htmlspecialchars(strip_tags(trim($this->input->post('explanation')))),
				
				
				'user_id' => $this->session->userdata('quiz_volunteer')['user_id'],
				'type' => 'Updated Question',
			);
			// print_r($edit_ques);

			$this->load->model('volunteer/Model_volunteer', 'mq');
			if ($this->mq->edit_question_volunteer($this->uri->segment(4), $edit_ques, $_SESSION['table_name'])) {
				redirect('volunteer/Dashboard/subjective');
			}
			redirect('volunteer/Dashboard');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
public function approvesub_question() {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->approve_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/subjective');
		} else {
			redirect('volunteer/Dashboard');
		}
	}	

	public function editsubQuestion($quiz_id) {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->session->userdata('quiz_volunteer')['type'] === '2') {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$data['title'] = "Volunteer | Edit Question";
			$this->load->view('volunteer/header', $data);
			$data['all_ques'] = $this->mq->fetch_a_question($quiz_id)[0];
			$_SESSION['table_name'] = "temp_add_ques";
			if (count($data)) {
				$this->load->view('volunteer/edit_subquestion', $data);
			} else {
				redirect(base_url('volunteer/Dashboard/subjective'));
			}
		} else {
			redirect(base_url('volunteer/Dashboard/subjective'));
		}
	}

	public function prof_subdelete_question() {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->prof_delete_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/subjective');
		} else {
			redirect('volunteer/Dashboard');
		}
	}

	public function prof_subapprove_question() {
		if (!$this->session->userdata('quiz_volunteer')['user_id']) {
			redirect(base_url('volunteer/login'));
		}
		if ($this->uri->segment(4)) {
			$this->load->model('volunteer/Model_volunteer', 'mq');
			$this->mq->prof_approve_question($this->uri->segment(4));
			redirect('volunteer/Dashboard/subjective');
		} else {
			redirect('volunteer/Dashboard');
		}
	}
}
