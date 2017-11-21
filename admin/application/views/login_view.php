<?php
$username = array('name' => 'username', 'placeholder' => 'Nombre de usuario', 'class' => 'form-control', 'id' => 'username');
$password = array('name' => 'password', 'placeholder' => 'Contraseña', 'class' => 'form-control', 'id' => 'password');
$submit = array('name' => 'submit', 'value' => 'Iniciar sesión', 'title' => 'Iniciar sesión');
?>
<div class="jumbotron login-window">
    <div class="container">
        <div class="row">
            <div id="formulario_login">
                <div id="campos_login">
                    <img src="<?=base_url()?>public/img/logo1.jpg" class="img-responsive center-block margin-bottom" alt="ganti logo"/>
                    <?= form_open(base_url() . 'login/new_user') ?>
                    <div class="form-group">
                        <?= form_error('username', '<span class="form-error">', '</span>') ?>
                        <?= form_input($username) ?>
                    </div>
                    <div class="form-group">
                        <?= form_error('password', '<span class="form-error">', '</span>') ?>
                        <?= form_password($password) ?>
                        <?= form_hidden('token', $token) ?>
                    </div>
                    <?= form_submit($submit, '', 'class="btn red-submit"') ?>
                    <?= form_close() ?>
                    <?php
                    if ($this->session->flashdata('usuario_incorrecto')) {
                        ?>
                        <p><?= $this->session->flashdata('usuario_incorrecto') ?></p>
                    <?php
                    }
                    ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>