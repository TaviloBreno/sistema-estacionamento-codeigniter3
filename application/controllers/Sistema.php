<?php

defined('BASEPATH') or exit('Ação não permitida');

class Sistema extends CI_Controller
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
		$this->form_validation->set_rules('sistema_razao_social', 'Razão Social', 'trim|required|min_length[5]|max_length[145]');
		$this->form_validation->set_rules('sistema_nome_fantasia', 'Nome Fantasia', 'trim|required|min_length[5]|max_length[145]');
		$this->form_validation->set_rules('sistema_cnpj', 'CNPJ', 'trim|required|exact_length[18]');
		$this->form_validation->set_rules('sistema_ie', 'Inscrição Estadual', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('sistema_telefone_fixo', 'Telefone Fixo', 'trim|required|exact_length[14]');
		$this->form_validation->set_rules('sistema_telefone_movel', 'Telefone Móvel', 'trim|required|min_length[14]|max_length[15]');
		$this->form_validation->set_rules('sistema_cep', 'CEP', 'trim|required|exact_length[9]');
		$this->form_validation->set_rules('sistema_endereco', 'Endereço', 'trim|required|min_length[5]|max_length[145]');
		$this->form_validation->set_rules('sistema_numero', 'Número', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('sistema_cidade', 'Cidade', 'trim|required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('sistema_estado', 'UF', 'trim|required|exact_length[2]');
		$this->form_validation->set_rules('sistema_site_url', 'Url do Site', 'trim|required|min_length[5]|valid_url|max_length[100]');
		$this->form_validation->set_rules('sistema_email', 'E-mail de contato', 'trim|required|min_length[5]|max_length[145]');
		$this->form_validation->set_rules('sistema_texto_ticket', 'Texto do ticket', 'trim|max_length[500]');

		if($this->form_validation->run()){
			$data = elements(
				[
					'sistema_razao_social',
					'sistema_nome_fantasia',
					'sistema_cnpj',
					'sistema_ie',
					'sistema_telefone_fixo',
					'sistema_telefone_movel',
					'sistema_cep',
					'sistema_endereco',
					'sistema_numero',
					'sistema_cidade',
					'sistema_estado',
					'sistema_site_url',
					'sistema_email',
					'sistema_texto_ticket'
				], $this->input->post()
			);

			$data = html_escape($data);

			$this->core_model->update('sistema', $data, ['sistema_id' => 1]);

			redirect($this->router->fetch_class());

		}else{
			$data = [
				'titulo' => 'Editar Informações do Sistema',
				'subtitulo' => 'Editando as informações do Sistema',
				'icone_view' => 'ik ik-settings',
				'scripts' => [
					'plugins/Mask/jquery.mask.min.js',
					'plugins/Mask/custom.js',
				],
				'sistema' => $this->core_model->get_by_id('sistema', ['sistema_id' => 1]),
			];


			// dd($data['sistema']);


			$this->load->view('layout/header', $data);
			$this->load->view('sistema/index');
			$this->load->view('layout/footer');
		}



	}
}
