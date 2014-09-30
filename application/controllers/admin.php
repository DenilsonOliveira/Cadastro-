<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        if (!$this->is_logged_in()) {
            redirect('adminlogin');
        }
    }
    public function index ()
    {
    	$users = $this->user_model->get_all();
    
    $this->load->view('admin',array('users'=>$users));
}
public function add()
{
	$this->load->view('admin_add');
}
public function add_user()
{
sleep(1);
$this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required|max_length[20]|alpha_numeric');	
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('email2', 'Email2', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('pwd2', 'Password2', 'required|max_length[20]|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Registration</strong> failed! Incorrect input!";
            $this->json_response(FALSE, $message);
        } else {   
            $email = $this->input->post('email');
            $pwd = $this->input->post('pwd');
            
            if ($email != $this->input->post('email2')) {
                $message = "<strong>Emails</strong> do not match!";
                $this->json_response(FALSE, $message);
            } elseif ($pwd != $this->input->post('pwd2')) {
                $message = "<strong>Passwords</strong> do not match!";
                $this->json_response(FALSE, $message);
            
            } elseif ($this->user_model->add($email, $pwd)) {
                $message = "<strong>Registration</strong> successful!";
                $this->json_response(TRUE, $message);
            } else {
                $message = "<strong>Email</strong> already exists!";
                $this->json_response(FALSE, $message);
            }
        }
    }
    public function delete()
    {
        $users = $this->user_model->get_emails();
        
        $this->load->view('admin_delete', array(
            'users' => $users
        ));
    }
    public function delete_user()
    {
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[40]|valid_email');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Deletion</strong> failed!";
            $this->json_response(FALSE, $message);
        } else {
            $email = $this->input->post('email');
            $this->user_model->delete($email);
            
            $message = "<strong>".$email."</strong> Sua Conta Foi Escuido!";
            echo json_encode(array(
                'Cadastro Efetuado Com Sucesso' => TRUE,
                'message' => $message,
                'email' => $email
            ));
        }
    }
    public function edit()
    {
    	$users = $this->user_model->get_emails();
        
        $this->load->view('admin_edit', array(
            'users' => $users 
        ));
    }
    public function edit_user()
    {
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required|max_length[20]|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Editing</strong> failed!";
            $this->json_response(FALSE, $message);
        } else {
            $this->user_model->update($this->input->post('email'), $this->input->post('pwd'));
            
            $message = "Editing for <strong>".$this->input->post('email')."</strong> Sua Conta foi excluida!";
            $this->json_response(TRUE, $message);
        }
    }
    public function profile()
    {
        $this->load->view('admin_profile');
    }
    
    public function change_password()
    {
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('curpwd', 'Current Password', 'required|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('newpwd', 'New Password', 'required|max_length[20]|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Cadastro foi Alterado</strong> Nao!";
            $this->json_response(FALSE, $message);
        } else {
            $pwd_valid = $this->admin_model->check_password(
                $this->session->userdata('admin'), $this->input->post('curpwd'));
            
            if ($pwd_valid) {   
                $this->admin_model->update_password(
                    $this->session->userdata('admin'), $this->input->post('newpwd'));
            
                $message = "<strong>Password</strong> Cadastro foi Alterado com sucesso!";
                $this->json_response(TRUE, $message);
            } else {
                $message = "<strong>Cenha Atual</strong> is wrong!";
                $this->json_response(FALSE, $message);
            }
        }
    }
    private function is_logged_in()
    {
        return $this->session->userdata('is_admin');
    }

    private function json_response($successful, $message)
    {
        echo json_encode(array(
            'Cadastro efetuado com sucesso' => $successful,
            'message' => $message
        )); 
    }
}
    
/* Controllador admin.php */
