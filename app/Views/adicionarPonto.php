<?php if ($is_admin === '1') { ?>
    <?php echo $this->include('header'); ?>
<?php } else { ?>
    <?php echo $this->include('header2'); ?>
<?php } ?>

<!-- content -->
<div class="content">
    <div class="cardAddPonto">
        <div class="title p-5">
            <h1><?php echo $title ?></h1>
        </div>
        <form method="POST">
            <div class="paddingPonto">
                <input type="hidden" name="id" value="<?php echo (isset($ponto) ? $ponto->IDPONTO : '') ?>">
                <div class="row">
                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="nome"><b>Nome do Ponto</b></label>
                        <input type="text" class="form-control" required minlength="2" value="<?php echo (isset($ponto) ? $ponto->NOMEPONTO : '') ?>" name="NOMEPONTO" placeholder="Ponto...">
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="nome"><b>Servidor</b></label>
                        <select required name="SERVIDORPONTO" class="form-select" required>
                            <option value="" selected>Selecione um Servidor...</option>
                            <?php foreach ($selectServidores as $selectS) { ?>
                                <option value="<?php echo $selectS->IDSERVIDOR ?>"><?php echo $selectS->NOMESERVIDOR ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="nome"><b>Recebe Sinal de:</b></label>
                        <select required name="CONECTA" class="form-select" required>
                            <option selected>Selecione um Ponto para Receber Sinal...</option>
                            <?php foreach ($selectPontos as $selectP) { ?>
                                <option value="<?php echo $selectP->IDPONTO ?>"><?php echo $selectP->NOMEPONTO ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="nome"><b>Tipo de Mídia</b></label>
                        <select name="MEIO" class="form-select" required>
                            <option selected>Selecione um Tipo de Mídia...</option>
                            <option value="1">Wireless</option>
                            <option value="2">Fibra</option>
                            <option value="3">Rádio Licenciado</option>
                            <option value="4">Wireless Cliente</option>
                            <option value="5">Fibra Clientes</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="sinalocal"><b>Sinal Local</b></label>
                        <input type="number" class="form-control" value="<?php echo (isset($ponto) ? $ponto->sinalocal : '') ?>" name="SINALLOCAL" placeholder="Sinal Local...">
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="sinalremoto"><b>Sinal Remoto</b></label>
                        <input type="number" class="form-control" value="<?php echo (isset($ponto) ? $ponto->sinalremoto : '') ?>" name="SINALREMOTO" placeholder="Sinal Remoto...">
                    </div>

                    <div class="form-group col-md-12 mb-5">
                        <label class="mb-2" for="obs"><b>Observação:</b></label>
                        <div class="form-floating">
                            <textarea name="OBSERVACAO" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"><?php echo (isset($ponto) ? $ponto->OBSERVACAO : '') ?></textarea>
                            <label for="floatingTextarea">observação...</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <h3><b>Informações do Ponto:</b></h3>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="nomeR"><b>Nome</b></label>
                        <input type="text" class="form-control" minlength="2" value="<?php echo (isset($ponto) ? $ponto->NOME : '') ?>" name="NOME" placeholder="Nome do responsável...">
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="mail"><b>Email</b></label>
                        <input type="mail" class="form-control" value="<?php echo (isset($ponto) ? $ponto->EMAIL : '') ?>" name="EMAIL" placeholder="Email do responsável...">
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="tel"><b>Telefone</b></label>
                        <input type="text" class="form-control telefone" minlength="15" maxlength="15" name="TELEFONE" value="<?php echo (isset($ponto) ? $ponto->TELEFONE : '') ?>" placeholder="Telefone do responsável...">
                    </div>
                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="end"><b>Endereço</b></label>
                        <input type="text" class="form-control" value="<?php echo (isset($ponto) ? $ponto->ENDERECO : '') ?>" name="ENDERECO" placeholder="Endereço do ponto...">
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        <label class="mb-2" for="patri"><b>Patrimonio:</b></label>
                        <div class="form-floating">
                            <textarea name="PATRIMONIO" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"><?php echo (isset($ponto) ? $ponto->PATRIMONIO : '') ?></textarea>
                            <label for="floatingTextarea2">patrimonio...</label>
                        </div>
                    </div>
                    <?php if ($msg === 'Erro ao inserir ponto' or $msg === 'Erro ao Atualizar ponto') { ?>
                        <?php if ($errors != '') { ?>
                            <div class="error m-5">
                                <ul class="m-4">
                                    <?php foreach ($errors as $erro) { ?>
                                        <li>&nbsp;&nbsp;<?php echo $erro ?></li>
                                    <?php } ?>
                                    <small>&nbsp;&nbsp; <b>Por favor verifique os campos acima...</b></small>
                                </ul>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <a href="<?php echo base_url('/relacao') ?>" class="m-5"><img src="<?php echo base_url('public/imgs/left-arrow.png') ?>" width="40px"></a>
                </div>
                <div class="col-md-4 text-center">
                    <button type="submit" class="btn pesquisaResult px-5">Enviar</button>
                </div>
                <div class="col-md-4"></div>
            </div>
        </form>
    </div>
</div>
<!-- end content -->

<?php echo $this->include('footer'); ?>