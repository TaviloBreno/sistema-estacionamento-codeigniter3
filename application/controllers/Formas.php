<?php

defined('BASEPATH') or exit('Acesso restrito!');

class Formas extends CI_Controller
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
			'titulo' => 'Formas de Pagamento Cadastradas',
			'subtitulo' => 'Listando todas as formas de pagamento cadastradas',
			'icone_view' => 'fas fa-comment-dollar',
			'formas' => $this->core_model->get_all('formas_pagamentos')
		];

		$this->load->view('layout/header', $data);
		$this->load->view('formas/index');
		$this->load->view('layout/footer');
	}

	public function core($forma_pagamento_id = NULL)
	{
		if (!$forma_pagamento_id) {

			// Cadastrando
			$this->form_validation->set_rules('forma_pagamento_nome', 'Nome da Forma de Pagamento', 'trim|required|min_length[4]|max_length[45]|is_unique[formas_pagamentos.forma_pagamento_nome]');
			$this->form_validation->set_rules('forma_pagamento_ativa', 'Ativa', 'trim|required');

			if ($this->form_validation->run()) {

				$data = elements(
					[
						'forma_pagamento_nome',
						'forma_pagamento_ativa',
					],
					$this->input->post()
				);

				$data = html_escape($data);

				$this->core_model->insert('formas_pagamentos', $data);
				redirect($this->router->fetch_class());
			} else {

				$data = [
					'titulo' => 'Cadastrar Forma de Pagamento',
					'subtitulo' => 'Preencha o formulário',
					'icone_view' => 'fas fa-comment-dollar',
				];

				$this->load->view('layout/header', $data);
				$this->load->view('formas/core');
				$this->load->view('layout/footer');
			}
		} else {

			if (!$forma_pagamento = $this->core_model->get_by_id('formas_pagamentos', ['forma_pagamento_id' => $forma_pagamento_id])) {
				$this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
				redirect($this->router->fetch_class());
			} else {

				// Editando
				$this->form_validation->set_rules('forma_pagamento_nome', 'Nome da Forma de Pagamento', 'trim|required|min_length[4]|max_length[45]|callback_check_pagamento_nome');
				$this->form_validation->set_rules('forma_pagamento_ativa', 'Ativa', 'trim|required');

				if ($this->form_validation->run()) {

					$data = elements(
						[
							'forma_pagamento_nome',
							'forma_pagamento_ativa',
						],
						$this->input->post()
					);

					$data = html_escape($data);
// Editando
					$this->form_validation->set_rules('forma_pagamento_nome', 'Nome da Forma de Pagamento', 'trim|required|min_length[4]|max_length[45]|callback_check_pagamento_nome');
					$this->form_validation->set_rules('forma_pagamento_ativa', 'Ativa', 'trim|required');

					if ($this->form_validation->run()) {
						$data = elements(
							[
								'forma_pagamento_nome',
								'forma_pagamento_ativa',
							],
							$this->input->post()
						);

						$data = html_escape($data);

						// Check if data is the same as in the database
						$existing_data = $this->core_model->get_by_id('formas_pagamentos', ['forma_pagamento_id' => $forma_pagamento_id]);
						if ($existing_data->forma_pagamento_nome == $data['forma_pagamento_nome'] && $existing_data->forma_pagamento_ativa == $data['forma_pagamento_ativa']) {
							$this->session->set_flashdata('warning', 'Nenhuma alteração foi feita.');
							redirect($this->router->fetch_class());
						} else {
							$this->core_model->update('formas_pagamentos', $data, ['forma_pagamento_id' => $forma_pagamento_id]);
							redirect($this->router->fetch_class());
						}
					}
					$this->core_model->update('formas_pagamentos', $data, ['forma_pagamento_id' => $forma_pagamento_id]);
					redirect($this->router->fetch_class());

				} else {

					$data = [
						'titulo' => 'Atualizar Forma de Pagamento',
						'subtitulo' => 'Atualize os dados',
						'icone_view' => 'fas fa-comment-dollar',
						'forma' => $this->core_model->get_by_id('formas_pagamentos', ['forma_pagamento_id' => $forma_pagamento_id]),
					];

					$this->load->view('layout/header', $data);
					$this->load->view('formas/core');
					$this->load->view('layout/footer');
				}
			}
		}

	}

	public function check_pagamento_nome($forma_pagamento_nome)
	{
		$forma_pagamento_id = $this->input->post('forma_pagamento_id');

		if ($this->core_model->get_by_id('formas_pagamentos', ['forma_pagamento_nome' => $forma_pagamento_nome, 'forma_pagamento_id !=' => $forma_pagamento_id])) {
			$this->form_validation->set_message('check_pagamento_nome', 'Essa forma de pagamento já existe');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function del($forma_pagamento_id = NULL)
	{
		if (!$this->core_model->get_by_id('formas_pagamentos', ['forma_pagamento_id' => $forma_pagamento_id])) {
			$this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('formas_pagamentos', ['forma_pagamento_id' => $forma_pagamento_id]);
		redirect($this->router->fetch_class());
	}
}
