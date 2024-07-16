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
                                <a data-toggle="tooltip" data-placement="top" title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a data-toggle="tooltip" data-placement="top" title="Editar <?php echo str_replace("a", "á", ucfirst($this->router->fetch_class())); ?>" href="<?php echo base_url('usuarios'); ?>" href="<?php echo base_url($this->router->fetch_class()); ?>">Listagem de <?php echo str_replace("a", "á", ucfirst($this->router->fetch_class())); ?></a>
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
                    <div class="card-header"><i class="ik ik-calendar ik-2x"></i>&nbsp;<b>Última atualização:</b>&nbsp; <?php echo isset($usuario) ? formata_data_banco_com_hora($usuario->data_ultima_atualizacao) : ''; ?></div>
                    <div class="card-body">
                        <form class="forms-sample" name="form_core" method="POST">
                            <div class="form-group row">
                                <div class="col-md-6 mb-20">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo isset($usuario) ? $usuario->first_name : set_value('first_name'); ?>">
                                    <?php echo form_error('first_name', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>Sobrenome</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo isset($usuario) ? $usuario->last_name : set_value('last_name'); ?>">
                                    <?php echo form_error('last_name', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-20">
                                    <label>Usuário</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo isset($usuario) ? $usuario->username : set_value('usuario'); ?>">
                                    <?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>E-mail (Login)</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo isset($usuario) ? $usuario->email : set_value('email'); ?>">
                                    <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-20">
                                    <label>Senha</label>
                                    <input type="password" class="form-control" name="password" placeholder="Senha">
                                    <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>Corfirmação de Senha</label>
                                    <input type="password" class="form-control" name="passconf" placeholder="Confirmação da Senha">
                                    <?php echo form_error('passconf', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-20">
                                    <label>Perfil de Acesso</label>
                                    <select name="perfil" class="form-control">
                                        <?php if (isset($usuario)) : ?>
                                            <option value="1" <?php echo ($perfil_usuario->id == 1) ? 'selected' : ''; ?>>Administrador</option>
                                            <option value="2" <?php echo ($perfil_usuario->id == 2) ? 'selected' : ''; ?>>Atendente</option>
                                        <?php else : ?>
                                            <option value="1">Administrador</option>
                                            <option value="2">Atendente</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label>Ativo</label>
                                    <select name="active" class="form-control">
                                        <?php if (isset($usuario)) : ?>
                                            <option value="0" <?php echo ($usuario->active == 0) ? 'selected' : ''; ?>>Não</option>
                                            <option value="1" <?php echo ($usuario->active == 1) ? 'selected' : ''; ?>>Sim</option>
                                        <?php else : ?>
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>
                            <?php if(isset($usuario)): ?>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="usuario_id" value="<?php echo $usuario->id; ?>">
                                </div>
                            </div>
                            <?php endif; ?>

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