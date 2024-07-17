<?php

defined('BASEPATH') or exit('Acesso restrito!');

class Mensalistas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('login');
		}
	}

	public function index()
	{
		$data = [
			'titulo' => 'Mensalistas Cadastrados',
			'subtitulo' => 'Listando todos os mensalistas cadastrados',
			'icone_view' => 'fas fa-users',
			'styles' => [
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			],
			'scripts' => [
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			],
			'mensalistas' => $this->core_model->get_all('mensalistas')
		];

		$this->load->view('layout/header', $data);
		$this->load->view('mensalistas/index');
		$this->load->view('layout/footer');
	}

	public function core($mensalista_id =NULL)
	{
		if(!$mensalista_id) {
			// Cadastrando
			$this->form_validation->set_rules('mensalista_nome', 'Nome', 'trim|required|min_length[4]|max_length[45]');
			$this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'trim|required|min_length[4]|max_length[45]');
			$this->form_validation->set_rules('mensalista_data_nascimento', 'Data de Nascimento', 'trim|required');
			$this->form_validation->set_rules('mensalista_cpf', 'CPF', 'trim|required|exact_length[14]|is_unique[mensalistas.mensalista_cpf]');
			$this->form_validation->set_rules('mensalista_rg', 'RG', 'trim|required|max_length[20]');
			$this->form_validation->set_rules('mensalista_email', 'E-mail', 'trim|required|valid_email|max_length[100]|is_unique[mensalistas.mensalista_email]');
			$this->form_validation->set_rules('mensalista_telefone_fixo', 'Telefone', 'trim|max_length[15]');
			$this->form_validation->set_rules('mensalista_telefone_movel', 'Celular', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('mensalista_cep', 'CEP', 'trim|required|exact_length[9]');
			$this->form_validation->set_rules('mensalista_endereco', 'Endereço', 'trim|required|max_length[155]');
			$this->form_validation->set_rules('mensalista_numero_endereco', 'Número', 'trim|required|max_length[20]');
			$this->form_validation->set_rules('mensalista_bairro', 'Bairro', 'trim|required|max_length[45]');
			$this->form_validation->set_rules('mensalista_complemento', 'Complemento', 'trim|max_length[145]');
			$this->form_validation->set_rules('mensalista_cidade', 'Cidade', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('mensalista_estado', 'UF', 'trim|required|exact_length[2]');
			$this->form_validation->set_rules('mensalista_ativo', 'Ativo', 'trim|required|in_list[0,1]');
			$this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia de Vencimento', 'trim|required|integer|greater_than[0]|less_than[32]');
			$this->form_validation->set_rules('mensalista_obs', 'Observação', 'trim|max_length[500]');

			if ($this->form_validation->run()) {
				$data = elements(
					[
						'mensalista_nome',
						'mensalista_sobrenome',
						'mensalista_data_nascimento',
						'mensalista_cpf',
						'mensalista_rg',
						'mensalista_email',
						'mensalista_telefone_fixo',
						'mensalista_telefone_movel',
						'mensalista_cep',
						'mensalista_endereco',
						'mensalista_numero_endereco',
						'mensalista_bairro',
						'mensalista_cidade',
						'mensalista_estado',
						'mensalista_complemento',
						'mensalista_ativo',
						'mensalista_dia_vencimento',
						'mensalista_obs',
					], $this->input->post()
				);

				$data = html_escape($data);

				$this->core_model->insert('mensalistas', $data);
				redirect($this->router->fetch_class());
			} else {
				$data = [
					'titulo' => 'Cadastrar Mensalista',
					'subtitulo' => 'Página de cadastro de mensalistas',
					'icone_view' => 'fas fa-users',
					'scripts' => [
						'plugins/Mask/jquery.mask.min.js',
						'plugins/Mask/custom.js',
					],
				];

				$this->load->view('layout/header', $data);
				$this->load->view('mensalistas/core');
				$this->load->view('layout/footer');
			}
		}else{
			// Editando
			if(!$this->core_model->get_by_id('mensalistas', ['mensalista_id' => $mensalista_id])) {
				$this->session->set_flashdata('error', 'Mensalista não encontrado');
				redirect($this->router->fetch_class());
			}else {
				$this->form_validation->set_rules('mensalista_nome', 'Nome', 'trim|required|min_length[4]|max_length[45]');
				$this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'trim|required|min_length[4]|max_length[45]');
				$this->form_validation->set_rules('mensalista_data_nascimento', 'Data de Nascimento', 'trim|required');
				$this->form_validation->set_rules('mensalista_cpf', 'CPF', 'trim|required|exact_length[14]');
				$this->form_validation->set_rules('mensalista_rg', 'RG', 'trim|required|max_length[20]');
				$this->form_validation->set_rules('mensalista_email', 'E-mail', 'trim|required|valid_email|max_length[100]');
				$this->form_validation->set_rules('mensalista_telefone_fixo', 'Telefone', 'trim|max_length[15]');
				$this->form_validation->set_rules('mensalista_telefone_movel', 'Celular', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('mensalista_cep', 'CEP', 'trim|required|exact_length[9]');
				$this->form_validation->set_rules('mensalista_endereco', 'Endereço', 'trim|required|max_length[155]');
				$this->form_validation->set_rules('mensalista_numero_endereco', 'Número', 'trim|required|max_length[20]');
				$this->form_validation->set_rules('mensalista_bairro', 'Bairro', 'trim|required|max_length[45]');
				$this->form_validation->set_rules('mensalista_complemento', 'Complemento', 'trim|max_length[145]');
				$this->form_validation->set_rules('mensalista_cidade', 'Cidade', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('mensalista_estado', 'UF', 'trim|required|exact_length[2]');
				$this->form_validation->set_rules('mensalista_ativo', 'Ativo', 'trim|required|in_list[0,1]');
				$this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia de Vencimento', 'trim|required|integer|greater_than[0]|less_than[32]');
				$this->form_validation->set_rules('mensalista_obs', 'Observação', 'trim|max_length[500]');

				if ($this->form_validation->run()) {
					$data = elements(
						[
							'mensalista_nome',
							'mensalista_sobrenome',
							'mensalista_data_nascimento',
							'mensalista_cpf',
							'mensalista_rg',
							'mensalista_email',
							'mensalista_telefone_fixo',
							'mensalista_telefone_movel',
							'mensalista_cep',
							'mensalista_endereco',
							'mensalista_numero_endereco',
							'mensalista_bairro',
							'mensalista_cidade',
							'mensalista_estado',
							'mensalista_complemento',
							'mensalista_ativo',
							'mensalista_dia_vencimento',
							'mensalista_obs',
						], $this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('mensalistas', $data, ['mensalista_id' => $mensalista_id]);
					redirect($this->router->fetch_class());
				} else {
					$data = [
						'titulo' => 'Editar Mensalista',
						'subtitulo' => 'Página de edição de mensalistas',
						'icone_view' => 'fas fa-users',
						'scripts' => [
							'plugins/Mask/jquery.mask.min.js',
							'plugins/Mask/custom.js',
						],
						'mensalista' => $this->core_model->get_by_id('mensalistas', ['mensalista_id' => $mensalista_id]),
					];

					$this->load->view('layout/header', $data);
					$this->load->view('mensalistas/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function del($mensalista_id = NULL)
	{
		if(!$mensalista_id || !$this->core_model->get_by_id('mensalistas', ['mensalista_id' => $mensalista_id])) {
			$this->session->set_flashdata('error', 'Mensalista não encontrado');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('mensalistas', ['mensalista_id' => $mensalista_id]);
		redirect($this->router->fetch_class());
	}
}
