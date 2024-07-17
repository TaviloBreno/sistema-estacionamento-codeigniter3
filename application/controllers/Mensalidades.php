<?php
defined('BASEPATH') or exit('Acesso restrito!');

class Mensalidades extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('mensalidades_model');
	}

	public function index()
	{
		$data = [
			'titulo' => 'Mensalidades Cadastradas',
			'subtitulo' => 'Listando todas as mensalidades cadastradas',
			'icone_view' => 'ik ik-calendar',
			'styles' => [
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			],
			'scripts' => [
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			],
			'mensalidades' => $this->mensalidades_model->get_all()
		];

		$this->load->view('layout/header', $data);
		$this->load->view('mensalidades/index');
		$this->load->view('layout/footer');
	}

	public function core($mensalidade_id = NULL)
	{
		if (!$mensalidade_id) {
			// Cadastrando
			$this->form_validation->set_rules('mensalidade_valor', 'Valor', 'trim|required');
			$this->form_validation->set_rules('mensalidade_data_vencimento', 'Data de Vencimento', 'trim|required');
			$this->form_validation->set_rules('mensalidade_mensalista_id', 'Mensalista', 'trim|required');
			$this->form_validation->set_rules('mensalidade_status', 'Status', 'trim|required|in_list[0,1]');
			$this->form_validation->set_rules('mensalidade_obs', 'Observação', 'trim|max_length[500]');

			if ($this->form_validation->run()) {
				$data = elements(
					[
						'mensalidade_valor',
						'mensalidade_data_vencimento',
						'mensalidade_mensalista_id',
						'mensalidade_status',
						'mensalidade_obs'
					],
					$this->input->post()
				);

				$data = html_escape($data);

				$this->mensalidades_model->insert($data);
				$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
				redirect($this->router->fetch_class());
			} else {
				$data = [
					'titulo' => 'Cadastrar Mensalidade',
					'subtitulo' => 'Cadastre a mensalidade do mensalista',
					'icone_view' => 'ik ik-calendar',
					'styles' => [
						'plugins/select2/css/select2.min.css',
					],
					'scripts' => [
						'plugins/select2/js/select2.min.js',
						'plugins/mask/jquery.mask.min.js',
						'plugins/mask/app.js',
					],
					'mensalistas' => $this->core_model->get_all('mensalistas'),
				];

				$this->load->view('layout/header', $data);
				$this->load->view('mensalidades/core');
				$this->load->view('layout/footer');
			}
		} else {
			if (!$mensalidade = $this->mensalidades){
				$this->session->set_flashdata('error', 'Mensalidade não encontrada');
				redirect($this->router->fetch_class());
			}
		}
	}
}
