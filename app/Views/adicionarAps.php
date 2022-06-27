<?php if ($is_admin === '1') { ?>
    <?php echo $this->include('header'); ?>
<?php } else { ?>
    <?php echo $this->include('header2'); ?>
<?php } ?>

<!-- content -->
<div class="content">
    <div class="cardAddPonto p-5">
        <div class="title mb-5">
            <h1><?php echo $title ?></h1>
        </div>
        <form method="POST">
            <div class="paddingPonto">
                <input type="hidden" name="id" value="<?php echo (isset($equipamento) ? $equipamento->ID : '') ?>">
                <div class="row">

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="PONTOEQUIPAMENTO"><b>Pontos</b></label>
                        <select name="PONTOEQUIPAMENTO" class="form-select" required>
                            <option value="" selected>Selecione um Ponto...</option>
                            <?php foreach ($selectPontos as $selectP) { ?>
                                <option value="<?php echo $selectP->IDPONTO ?>"><?php echo $selectP->NOMEPONTO ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="CIDADEEQUIPAMENTO"><b>Cidades</b></label>
                        <select name="CIDADEEQUIPAMENTO" class="form-select" required>
                            <option value="" selected>Selecione uma Cidade...</option>
                            <?php foreach ($selectCidades as $selectC) { ?>
                                <option value="<?php echo $selectC->IDCIDADE ?>"><?php echo $selectC->NOMECIDADE ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="SOFTWAREEQUIPAMENTO"><b>Softwares</b></label>
                        <select name="SOFTWAREEQUIPAMENTO" class="form-select" required>
                            <option value="" selected>Selecione um Software...</option>
                            <?php foreach ($selectSoftwares as $selectSof) { ?>
                                <option value="<?php echo $selectSof->IDSOFTWARE ?>"><?php echo $selectSof->NOMESOFTWARE ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="MODELOEQUIPAMENTO"><b>Modelos</b></label>
                        <select name="MODELOEQUIPAMENTO" class="form-select" required>
                            <option value="" selected>Selecione um Modelo...</option>
                            <?php foreach ($selectModelos as $selectMod) { ?>
                                <option value="<?php echo $selectMod->IDMODELO ?>"><?php echo $selectMod->NOMEMODELO ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="MODOEQUIPAMENTO"><b>Modos</b></label>
                        <select name="MODOEQUIPAMENTO" class="form-select" required>
                            <option value="" selected>Selecione um Modo...</option>
                            <?php foreach ($selectModos as $selectMods) { ?>
                                <option value="<?php echo $selectMods->IDMODO ?>"><?php echo $selectMods->NOMEMODO ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="DESCRICAOEQUIPAMENTO"><b>Descrição do Equipamento</b></label>
                        <input type="text" class="form-control" value="<?php echo (isset($equipamento) ? $equipamento->DESCRICAOEQUIPAMENTO : '') ?>" name="DESCRICAOEQUIPAMENTO" placeholder="Descrição do Equipamento...">
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="IP"><b>IP</b></label>
                        <input type="text" class="form-control" value="<?php echo (isset($equipamento) ? $equipamento->IP : '') ?>" maxlength="15" name="IP" placeholder="Endereço de IP...">
                    </div>

                    <div class="form-group col-md-6 mb-5">
                        <label class="mb-2" for="Canal"><b>Canal</b></label>
                        <input type="number" class="form-control" value="<?php echo (isset($equipamento) ? $equipamento->CANAL : '') ?>" name="CANAL" placeholder="Número do Canal...">
                    </div>

                    <div class="form-group col-md-12 mb-5">
                        <label class="mb-2" for="obs"><b>Observação:</b></label>
                        <div class="form-floating">
                            <textarea name="COMENTARIOEQUIPAMENTO" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"><?php echo (isset($equipamento) ? $equipamento->COMENTARIOEQUIPAMENTO : '') ?></textarea>
                            <label for="floatingTextarea">observação...</label>
                        </div>
                    </div>
                    <?php if ($msg === 'Erro ao inserir equipamento' or $msg === 'Erro ao Atualizar equipamento') { ?>
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

            <div class="row">
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