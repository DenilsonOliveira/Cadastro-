<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrar extends CI_Controller
{
    public function index()
    {
        $this->load->view('registrar');
    }
    
    public function check()
    {           
        sleep(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('email2', 'Email2', 'required|max_length[40]|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('pwd2', 'Password2', 'required|max_length[20]|alpha_numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $message = "<strong>Registration</strong> A Senha Esta Incorreta!";
            $this->json_response(FALSE, $message);
        } else {   
            $email = $this->input->post('email');
            $pwd = $this->input->post('pwd');
            
            if ($email != $this->input->post('email2')) {
                $message = "<strong>Emails</strong> A Senha Não Correponde!";
                $this->json_response(FALSE, $message);
            } else 
                if ($pwd != $this->input->post('pwd2')) {
                $message = "<strong>Passwords</strong> A Senha Não Correponde!";
                $this->json_response(FALSE, $message);
            
            } else 
            if ($this->user_model->add($email, $pwd)) {
                $message = "<strong>Registration</strong> Senha Cadastrado Com Sucesso!";
                $this->json_response(TRUE, $message);
            } else {
                $message = "<strong>Email</strong> Senha ja existe!";
                $this->json_response(FALSE, $message);
            }
        }
    }

    private function json_response($successful, $message)
    {
        echo json_encode(array(
            'issuccessful' => $successful,
            'message' => $message
        )); 
    }
}
/*Controller Registro.php*/
