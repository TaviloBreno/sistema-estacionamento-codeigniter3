<?php

defined('BASEPATH') or exit('Ação não permitida');

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->ion_auth->logged_in())
		{
			redirect('login');
		}
	}

	public function index()
	{
		$data = [
			'titulo' => 'Usuários cadastrados',
			'subtitulo' => 'Listando todos os usuários cadastrados',
			'styles' => [
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			],
			'scripts' => [
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			],
			'usuarios' => $this->ion_auth->users()->result()
		];

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/index');
		$this->load->view('layout/footer');
	}

	public function core($usuario_id = NULL)
	{
		if (!$usuario_id) {

			$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[4]|max_length[50]');
			$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[4]|max_length[100]|is_unique[users.username]');
			$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Confimação da Senha', 'trim|required|matches[password]');

			if($this->form_validation->run()){

				$username = html_escape($this->input->post('username'));
				$password = html_escape($this->input->post('password'));
				$email = html_escape($this->input->post('email'));
				$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'active' => $this->input->post('active')
				);
				$group = html_escape(array($this->input->post('perfil')));

				$additional_data = html_escape($additional_data);

				if($this->ion_auth->register($username, $password, $email, $additional_data, $group)){
					$this->session->set_flashdata('success', 'Usuário cadastrado com sucesso!');
				}else{
					$this->session->set_flashdata('error', 'Erro ao cadastrar usuário!');
				}

				redirect($this->router->fetch_class());
			}else{
				$data = [
					'titulo' => 'Cadastro de Usuários',
					'subtitulo' => 'Cadastrando novos usuários',
					'icone_view' => 'ik ik-user',
					'botao' => 'Cadastrar'
				];

				$this->load->view('layout/header', $data);
				$this->load->view('usuarios/core');
				$this->load->view('layout/footer');
			}

		} else {

			if (!$this->ion_auth->user($usuario_id)->row()) {
				exit('Usuário não existe!');
			} else {

				$perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

				$this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[5]|max_length[50]');
				$this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[5]|max_length[50]');
				$this->form_validation->set_rules('username', 'Usuário', 'trim|required|min_length[5]|max_length[100]|callback_username_check');
				$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback_email_check');
				$this->form_validation->set_rules('password', 'Senha', 'trim|min_length[8]');
				$this->form_validation->set_rules('passconf', 'Confimação da Senha', 'trim|matches[password]');


				if ($this->form_validation->run()) {

					$data = elements(
						[
							'first_name',
							'last_name',
							'username',
							'email',
							'password',
							'active'
						],
						$this->input->post()
					);

					$password = $this->input->post('password');

					if (!$password) {
						unset($data['password']);
					}

					$data = html_escape($data);

					if ($this->ion_auth->update($usuario_id, $data)) {

						$perfil_post = $this->input->post('perfil');

						if ($perfil_atual->id != $perfil_post) {
							$this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
							$this->ion_auth->add_to_group($perfil_post, $usuario_id);
						}

						$this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso!');
					} else {
						$this->session->set_flashdata('error', 'Não foi possível atualizar os dados!');
					}

					redirect($this->router->fetch_class());
				} else {
					$data = [
						'titulo' => 'Editar Usuários',
						'subtitulo' => 'Editando os usuários cadastrados',
						'icone_view' => 'ik ik-user',
						'usuario' => $this->ion_auth->user($usuario_id)->row(),
						'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
						'botao' => 'Atualizar'
					];

					$this->load->view('layout/header', $data);
					$this->load->view('usuarios/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function username_check($username)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', ['username' => $username, 'id !=' => $usuario_id])) {
			$this->form_validation->set_message('username_check', 'O usuário %s já está cadastrado!');
			return false;
		} else {
			return true;
		}
	}

	public function email_check($email)
	{
		$usuario_id = $this->input->post('usuario_id');

		if ($this->core_model->get_by_id('users', ['email' => $email, 'id !=' => $usuario_id])) {
			$this->form_validation->set_message('username_check', 'O email %s já está cadastrado!');
			return false;
		} else {
			return true;
		}
	}

	public function del($usuario_id = NULL)
	{
		if(!$usuario_id || !$this->core_model->get_by_id('users', ['id' => $usuario_id])){
			$this->session->set_flashdata('error', "Usuário não encontrado!");
			redirect($this->router->fetch_class());
		}else{
			if($this->ion_auth->is_admin($usuario_id)){
				$this->session->set_flashdata('error', "Você não pode excluir um administrador!");
				redirect($this->router->fetch_class());
			}

			if($this->ion_auth->delete_user($usuario_id)){
				$this->session->set_flashdata('sucesso', "Usuário excluído com sucesso!");
			}else{
				$this->session->set_flashdata('error', "Erro ao excluir usuário!");
			}
			redirect($this->router->fetch_class());
		}
	}
}
