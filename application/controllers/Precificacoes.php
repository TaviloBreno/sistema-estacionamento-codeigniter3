<?php


defined('BASEPATH') or exit('Ação não permitida');

class Precificacoes extends CI_Controller
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
			'titulo' => 'Precificações cadastradas',
			'subtitulo' => 'Listando todas as precificações cadastradas',
			'icone_view' => 'fas fa-dollar-sign',
			'styles' => [
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			],
			'scripts' => [
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			],
			'precificacoes' => $this->core_model->get_all('precificacoes')
		];

		$this->load->view('layout/header', $data);
		$this->load->view('precificacoes/index');
		$this->load->view('layout/footer');
	}

	public function core($precificacao_id = NULL)
	{
		if (!$precificacao_id) {

			$this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'trim|required|min_length[5]|max_length[30]|is_unique[precificacoes.precificacao_categoria]');
			$this->form_validation->set_rules('precificacao_valor_hora', 'Valor da Hora', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('precificacao_valor_mensalidade', 'Valor da Mensalidade', 'trim|required|min_length[5]|max_length[12]');
			$this->form_validation->set_rules('precificacao_numero_vagas', 'Número de Vagas', 'trim|required|integer|greater_than[0]');

			if ($this->form_validation->run()) {
				$data = elements(
					[
						'precificacao_categoria',
						'precificacao_valor_hora',
						'precificacao_valor_mensalidade',
						'precificacao_numero_vagas',
						'precificacao_ativa'
					],
					$this->input->post()
				);

				$data = html_escape($data);

				$this->core_model->insert('precificacoes', $data);
				redirect($this->router->fetch_class());
			} else {
				$data = [
					'titulo' => 'Cadastrar Precificação',
					'subtitulo' => 'Chegou a hora de cadastrar precificação',
					'icone_view' => 'fas fa-dollar-sign',
					'styles' => [
						'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
					],
					'scripts' => [
						'plugins/Mask/jquery.mask.min.js',
						'plugins/Mask/custom.js',
					]
				];

				$this->load->view('layout/header', $data);
				$this->load->view('precificacoes/core');
				$this->load->view('layout/footer');
			}

		} else {
			if (!$this->core_model->get_by_id('precificacoes', ['precificacao_id' => $precificacao_id])) {
				$this->session->set_flashdata('error', 'Precificação não encontrada!');
				redirect($this->router->fetch_class());
			} else {

				$this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'trim|required|min_length[5]|max_length[30]|callback_check_categoria');
				$this->form_validation->set_rules('precificacao_valor_hora', 'Valor da Hora', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('precificacao_valor_mensalidade', 'Valor da Mensalidade', 'trim|required|min_length[5]|max_length[12]');
				$this->form_validation->set_rules('precificacao_numero_vagas', 'Número de Vagas', 'trim|required|integer|greater_than[0]');

				if ($this->form_validation->run()) {
					$precificacao_ativa = $this->input->post('precificacao_ativa');
					if ($precificacao_ativa == 0) {
						if ($this->db->table_exists('estacionar')) {
							if ($this->core_model->get_by_id('estacionar', ['estacionar_precificacao_id' => $precificacao_id, 'estacionar_status' => 0])) {
								$this->session->set_flashdata('error', 'Esta categoria está sendo utilizada em Estacionar!');
								redirect($this->router->fetch_class());
							}
						}
					}

					if ($precificacao_ativa == 0) {
						if ($this->db->table_exists('mensalidades')) {
							if ($this->core_model->get_by_id('mensalidades', ['mensalidade_precificacao_id' => $precificacao_id, 'mensalidade_status' => 0])) {
								$this->session->set_flashdata('error', 'Esta categoria está sendo utilizada em Mensalidades!');
								redirect($this->router->fetch_class());
							}
						}
					}

					$data = elements(
						[
							'precificacao_categoria',
							'precificacao_valor_hora',
							'precificacao_valor_mensalidade',
							'precificacao_numero_vagas',
							'precificacao_ativa'
						],
						$this->input->post()
					);

					$data = html_escape($data);

					$this->core_model->update('precificacoes', $data, ['precificacao_id' => $precificacao_id]);
					redirect($this->router->fetch_class());
				} else {
					$data = [
						'titulo' => 'Editar Precificação',
						'subtitulo' => 'Chegou a hora de editar a precificação',
						'icone_view' => 'fas fa-dollar-sign',
						'styles' => [
							'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
						],
						'scripts' => [
							'plugins/Mask/jquery.mask.min.js',
							'plugins/Mask/custom.js',
						],
						'precificacao' => $this->core_model->get_by_id('precificacoes', ['precificacao_id' => $precificacao_id])
					];

					$this->load->view('layout/header', $data);
					$this->load->view('precificacoes/core');
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function check_categoria($precificacao_categoria)
	{
		$precificacao_id = $this->input->post('precificacao_id');

		if ($this->core_model->get_by_id('precificacoes', ['precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=', $precificacao_id])) {

			$this->form_validation->set_message('check_categoria', 'Esta categoria já existe!');

			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function del($precificacao_id = NULL)
	{
		if (!$this->core_model->get_by_id('precificacoes', ['precificacao_id' => $precificacao_id])) {
			$this->session->set_flashdata('error', 'Precificação não encontrada!');
			redirect($this->router->fetch_class());
		}

		if ($this->core_model->get_by_id('precificacoes', ['precificacao_id' => $precificacao_id, 'precificacao_ativa' => 1])) {
			$this->session->set_flashdata('error', 'Precificação que está ativa não pode ser excluída!');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));
		redirect($this->router->fetch_class());
	}
}
