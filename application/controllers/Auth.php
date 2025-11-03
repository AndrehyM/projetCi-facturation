<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
		$this->lang->load('en_admin_lang','english');
    }


    //  se connecter
    public function login() {
        if($this->input->post()){
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('password','Mot de passe','required');

            if($this->form_validation->run()){
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User_model->verify_login($email, $password);

                if($user){
                    $this->session->set_userdata('user_id', $user->id);
					$this->session->set_userdata('username', $user->username);
					$this->session->set_userdata('role',$user->role);
					log_message('info', 'Connexion admin : '.$this->session->userdata('username').' à '.date('Y-m-d H:i:s'));

                    redirect($user->role === 'admin' ? 'admin/index' : 'user/index');
                } else {
                    $this->session->set_flashdata('error','Email ou mot de passe incorrect');
                }
            }
        }

        $this->load->view('inc/login_header');
        $this->load->view('account/login');
        $this->load->view('inc/footer');
    }

    // deconnexion
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    //  Mot de passe oublié
    public function forgot_password() {
        if($this->input->post()){
            $email = $this->input->post('email');
            $user = $this->User_model->get_user_by_email($email);

            if($user){
                $hash_key = bin2hex(random_bytes(16));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $this->User_model->set_reset_hash($email, $hash_key, $expiry);

                $reset_link = base_url("auth/reset_password/$hash_key");

                //  Config SMTP Gmail
                $config = array(
                    'protocol'    => 'smtp',
                    'smtp_host'   => 'smtp.gmail.com',
                    'smtp_port'   => 465,
                    'smtp_user'   => 'mivononaandry@gmail.com',
                    'smtp_pass'   => 'snaq lviy wjnn qvgh',
                    'smtp_crypto' => 'ssl',
                    'mailtype'    => 'html',
                    'charset'     => 'utf-8',
                    'newline'     => "\r\n",
                    'crlf'        => "\r\n",
                    'wordwrap'    => TRUE
                );

                $this->email->initialize($config);
                $this->email->from($config['smtp_user'], 'Facturation');
                $this->email->to($email);
                $this->email->subject('Réinitialisation de mot de passe');
                $this->email->message("Cliquez ici pour réinitialiser votre mot de passe : <a href='$reset_link'>$reset_link</a>");

                if(!$this->email->send()){
                    echo "<pre>";
                    print_r($this->email->print_debugger());
                    echo "</pre>";
                    exit;
                } else {
                    $this->session->set_flashdata('success','Lien envoyé par email.');
                }

            } else {
                $this->session->set_flashdata('error','Email introuvable.');
            }
        }

        $this->load->view('inc/login_header');
        $this->load->view('account/forgot_password');
        $this->load->view('inc/footer');
    }

    // 🔹 Réinitialiser mot de passe
    public function reset_password($hash_key = null) {
        if(!$hash_key) show_error('Lien invalide.');

        $user = $this->User_model->get_user_by_hash($hash_key);
        if(!$user) show_error('Lien invalide ou expiré.');

        if($this->input->post()){
            $this->form_validation->set_rules('password','Mot de passe','required');

            if($this->form_validation->run()){
                $new_password = $this->input->post('password');
                $this->User_model->update_password($user->id, $new_password);
                $this->session->set_flashdata('success','Mot de passe mis à jour.');
                redirect('auth/login');
            }
        }

        $data['hash_key'] = $hash_key;
        $this->load->view('inc/login_header');
        $this->load->view('account/reset_password', $data);
        $this->load->view('inc/footer');
    }
}
