<?php $this->load->view('layout/navbar'); ?>

<?php $this->load->view('layout/sidebar'); ?>

<div class="main-content">
	<div class="container-fluid">
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<i class="<?php echo $icone_view; ?> bg-blue"></i>
						<div class="d-inline">
							<h5><?php echo $titulo; ?></h5>
							<span><?php echo $subtitulo; ?></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<nav class="breadcrumb-container" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<form class="forms-sample" name="form_core" method="POST">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" class="form-control" name="mensalista_nome" value="<?php echo isset($mensalista) ? $mensalista->mensalista_nome : set_value('mensalista_nome'); ?>">
								<?php echo form_error('mensalista_nome', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Sobrenome</label>
								<input type="text" class="form-control" name="mensalista_sobrenome" value="<?php echo isset($mensalista) ? $mensalista->mensalista_sobrenome : set_value('mensalista_sobrenome'); ?>">
								<?php echo form_error('mensalista_sobrenome', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Data de Nascimento</label>
								<input type="date" class="form-control" name="mensalista_data_nascimento" value="<?php echo isset($mensalista) ? $mensalista->mensalista_data_nascimento : set_value('mensalista_data_nascimento'); ?>">
								<?php echo form_error('mensalista_data_nascimento', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>CPF</label>
								<input type="text" class="form-control" name="mensalista_cpf" value="<?php echo isset($mensalista) ? $mensalista->mensalista_cpf : set_value('mensalista_cpf'); ?>">
								<?php echo form_error('mensalista_cpf', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>RG</label>
								<input type="text" class="form-control" name="mensalista_rg" value="<?php echo isset($mensalista) ? $mensalista->mensalista_rg : set_value('mensalista_rg'); ?>">
								<?php echo form_error('mensalista_rg', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="mensalista_email" value="<?php echo isset($mensalista) ? $mensalista->mensalista_email : set_value('mensalista_email'); ?>">
								<?php echo form_error('mensalista_email', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Telefone</label>
								<input type="text" class="form-control" name="mensalista_telefone_fixo" value="<?php echo isset($mensalista) ? $mensalista->mensalista_telefone_fixo : set_value('mensalista_telefone_fixo'); ?>">
								<?php echo form_error('mensalista_telefone_fixo', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Celular</label>
								<input type="text" class="form-control" name="mensalista_telefone_movel" value="<?php echo isset($mensalista) ? $mensalista->mensalista_telefone_movel : set_value('mensalista_telefone_movel'); ?>">
								<?php echo form_error('mensalista_telefone_movel', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>CEP</label>
								<input type="text" class="form-control" name="mensalista_cep" value="<?php echo isset($mensalista) ? $mensalista->mensalista_cep : set_value('mensalista_cep'); ?>">
								<?php echo form_error('mensalista_cep', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Endereço</label>
								<input type="text" class="form-control" name="mensalista_endereco" value="<?php echo isset($mensalista) ? $mensalista->mensalista_endereco : set_value('mensalista_endereco'); ?>">
								<?php echo form_error('mensalista_endereco', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Número</label>
								<input type="text" class="form-control" name="mensalista_numero_endereco" value="<?php echo isset($mensalista) ? $mensalista->mensalista_numero_endereco : set_value('mensalista_numero_endereco'); ?>">
								<?php echo form_error('mensalista_numero_endereco', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Bairro</label>
								<input type="text" class="form-control" name="mensalista_bairro" value="<?php echo isset($mensalista) ? $mensalista->mensalista_bairro : set_value('mensalista_bairro'); ?>">
								<?php echo form_error('mensalista_bairro', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Cidade</label>
								<input type="text" class="form-control" name="mensalista_cidade" value="<?php echo isset($mensalista) ? $mensalista->mensalista_cidade : set_value('mensalista_cidade'); ?>">
								<?php echo form_error('mensalista_cidade', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Estado</label>
								<input type="text" class="form-control" name="mensalista_estado" value="<?php echo isset($mensalista) ? $mensalista->mensalista_estado : set_value('mensalista_estado'); ?>">
								<?php echo form_error('mensalista_estado', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Complemento</label>
								<input type="text" class="form-control" name="mensalista_complemento" value="<?php echo isset($mensalista) ? $mensalista->mensalista_complemento : set_value('mensalista_complemento'); ?>">
								<?php echo form_error('mensalista_complemento', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Ativo</label>
								<select class="form-control" name="mensalista_ativo">
									<option value="1" <?php echo isset($mensalista) && $mensalista->mensalista_ativo == 1 ? 'selected' : set_select('mensalista_ativo', '1'); ?>>Sim</option>
									<option value="0" <?php echo isset($mensalista) && $mensalista->mensalista_ativo == 0 ? 'selected' : set_select('mensalista_ativo', '0'); ?>>Não</option>
								</select>
								<?php echo form_error('mensalista_ativo', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Dia de Vencimento</label>
								<input type="number" class="form-control" name="mensalista_dia_vencimento" value="<?php echo isset($mensalista) ? $mensalista->mensalista_dia_vencimento : set_value('mensalista_dia_vencimento'); ?>">
								<?php echo form_error('mensalista_dia_vencimento', '<small class="text-danger">', '</small>'); ?>
							</div>

							<div class="form-group">
								<label>Observações</label>
								<textarea class="form-control" name="mensalista_obs"><?php echo isset($mensalista) ? $mensalista->mensalista_obs : set_value('mensalista_obs'); ?></textarea>
								<?php echo form_error('mensalista_obs', '<small class="text-danger">', '</small>'); ?>
							</div>

							<button type="submit" class="btn btn-primary mr-2"><?php echo isset($botao) ? $botao : 'Salvar'; ?></button>
							<a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-danger text-white">Voltar</a>
						</form>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<footer class="footer">
	<div class="w-100 clearfix">
		<span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y'); ?> ThemeKit v2.0. Todos os direitos reservados.</span>
		<span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Costumizado <i class="fa fa-laptop-code text-danger"></i> por <a href="http://lavalite.org/" class="text-dark" target="_blank">Tavilo Breno</a></span>
	</div>
</footer>

</div>
