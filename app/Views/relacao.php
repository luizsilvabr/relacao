<?php echo $this->include('header'); ?>
<div class="content">
    <div class="title mb-2">
        <h1>Relação Unificada</h1>
    </div>
    <form class="searchForm" name="Form" action="<?php echo base_url('relacao/pesquisar') ?>" method="POST" onsubmit="return validateForm()">
        <div class="search search_input">
            <input id="desc" type="text" minlength="3" placeholder="Descrição..." name="desc">
            <select id="servidor" class="form-select" name="servidor">
                <option selected value="">Servidor</option>
                <?php
                $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                mysqli_set_charset($connect, 'utf8');
                $query = mysqli_query($connect, "SELECT * FROM SERVIDOR ORDER BY NOMESERVIDOR ASC;");
                while ($row = mysqli_fetch_array($query)) { ?>
                    <option value="<?php echo $row['IDSERVIDOR'] ?>"><?php echo $row['NOMESERVIDOR'] ?></option>
                <?php } ?>
            </select>
            <select id="ponto" class="form-select" name="ponto">
                <option selected value="">Ponto de Acesso</option>
            </select>
            <button type="submit"><i class="fa fa-search"></i></button>
            <div class="form-text"><span>Pesquise por: Servidor, Ponto de Acesso, Descrição.</span>
                <?php if (!empty($servidorPesquisado) or !empty($pontoPesquisado) or !empty($desc)) { ?>
                    <span class="pesquisaResult">Você pesquisou por
                    <?php } ?>
                    <?php
                    if (!empty($servidorPesquisado)) {
                        $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                        mysqli_set_charset($connect, "utf8");
                        $query = mysqli_query($connect, "SELECT NOMESERVIDOR FROM SERVIDOR WHERE IDSERVIDOR = $servidorPesquisado");
                        $servidorNome = mysqli_fetch_array($query);
                    }
                    ?>
                    <?php if (!empty($servidorPesquisado) and !empty($pontoPesquisado) and !empty($desc)) { ?> Servidor: <?php echo $servidorNome['NOMESERVIDOR'] ?> - Ponto: <?php echo $pontoPesquisado ?> - Descrição: <?php echo $desc ?><?php } ?>
                        <?php if (!empty($servidorPesquisado) and !empty($pontoPesquisado) and empty($desc)) { ?> Servidor: <?php echo $servidorNome['NOMESERVIDOR'] ?> - Ponto: <?php echo $pontoPesquisado ?><?php } ?>
                            <?php if (!empty($servidorPesquisado) and empty($pontoPesquisado) and empty($desc)) { ?> Servidor: <?php echo $servidorNome['NOMESERVIDOR'] ?><?php } ?>
                                <?php if (!empty($servidorPesquisado) and empty($pontoPesquisado) and !empty($desc)) { ?> Servidor: <?php echo $servidorNome['NOMESERVIDOR'] ?> - Descrição: <?php echo $desc ?><?php } ?>
                                    <?php if (empty($servidorPesquisado) and empty($pontoPesquisado) and !empty($desc)) { ?> Descrição: <?php echo $desc ?><?php } ?>
                    </span>
            </div>
        </div>
    </form>
    <?php if (isset($infos) and isset($tables)) { ?>
        <?php if (empty($infos) and empty($tables)) { ?>
            <div class="noData">
                <h5>Sua consulta não foi encontrada...</h5>
            </div>
        <?php } ?>
        <?php
        if (!empty($infos)) {
            foreach ($infos as $info) { ?>
                <div class="itensSearch mb-4 mt-4">
                    <?php if ($info->nomepessoa or $info->telefone or $info->endereco or $info->email or $info->observacao or $info->sinalocal or $info->sinalremoto) { ?>
                        <?php if ($info->ponto != '') { ?>
                            <div class="ponto">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div style="display: flex; justify-content: center; align-items: center" class="col-md-4"><?php echo $info->ponto ?></div>
                                    <div class="col-md-4 text-end px-5">
                                        <a data-bs-toggle="modal" data-bs-target="#editar<?php echo $info->idponto ?>" class="btn btnPerson2"><img src="<?php echo base_url('public/imgs/engine.png') ?>" width="23px"></a>
                                    </div>
                                    <!-- modal editar -->
                                    <div class="modal fade text-dark" id="editar<?php echo $info->idponto ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/edit.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Editar - Ponto</b></h5>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="<?php echo base_url('relacao/editarInfo/' . $info->idponto) ?>">
                                                    <div class="modal-body">
                                                        <div style="text-align: initial; font-size: 17px;font-weight: 100;" class="row paddingPonto">
                                                            <input type="hidden" name="id" value="<?php echo (isset($info) ? $info->idponto : '') ?>">
                                                            <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                            <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                            <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="nome"><b>Nome do Ponto</b></label>
                                                                    <input type="text" class="form-control" required minlength="2" value="<?php echo (isset($info) ? $info->ponto : '') ?>" name="NOMEPONTO" placeholder="Ponto...">
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="nome"><b>Servidor</b></label>
                                                                    <select required name="SERVIDORPONTO" class="form-select" required>
                                                                        <?php
                                                                        if (isset($info)) {
                                                                            $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                                                            mysqli_set_charset($connect, "utf8");
                                                                            $idServidor = $info->SERVIDORPONTO;
                                                                            $query = mysqli_query($connect, "SELECT NOMESERVIDOR FROM SERVIDOR WHERE IDSERVIDOR = $idServidor");
                                                                            $nomeServidor = mysqli_fetch_array($query);
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo (isset($info)) ? $info->SERVIDORPONTO : '' ?>" selected><?php echo (isset($nomeServidor['NOMESERVIDOR']) ? $nomeServidor['NOMESERVIDOR'] : 'Selecione um Servidor...') ?></option>
                                                                        <?php foreach ($selectServidores as $selectS) { ?>
                                                                            <option value="<?php echo $selectS->IDSERVIDOR ?>"><?php echo $selectS->NOMESERVIDOR ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="nome"><b>Recebe Sinal de:</b></label>
                                                                    <select required name="CONECTA" class="form-select" required>
                                                                        <?php
                                                                        if (isset($info)) {
                                                                            $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                                                            mysqli_set_charset($connect, "utf8");
                                                                            $conecta = $info->CONECTA;
                                                                            $query = mysqli_query($connect, "SELECT NOMEPONTO FROM PONTO WHERE IDPONTO = '$conecta'");
                                                                            $recebeSinal = mysqli_fetch_array($query);
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo (isset($info) ? $info->CONECTA : '') ?>" selected><?php echo (isset($recebeSinal['NOMEPONTO']) ? $recebeSinal['NOMEPONTO'] : 'Selecione um Ponto para Receber Sinal...') ?></option>
                                                                        <?php foreach ($selectPontos as $selectP) { ?>
                                                                            <option value="<?php echo $selectP->IDPONTO ?>"><?php echo $selectP->NOMEPONTO ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="nome"><b>Tipo de Mídia</b></label>
                                                                    <select name="MEIO" class="form-select" required>
                                                                        <?php
                                                                        if (isset($info)) {
                                                                            $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                                                            mysqli_set_charset($connect, "utf8");
                                                                            $meio = $info->MEIO;
                                                                            $query = mysqli_query($connect, "SELECT MEIO FROM PONTO WHERE MEIO = '$meio'");
                                                                            $meio = mysqli_fetch_array($query);
                                                                        }
                                                                        ?>
                                                                        <option selected value="<?php echo (isset($info) ? $info->MEIO : '') ?>">
                                                                            <?php
                                                                            if ($meio['MEIO'] == '1') {
                                                                                echo "Wireless";
                                                                            } else if ($meio['MEIO'] == '2') {
                                                                                echo "Fibra";
                                                                            } else if ($meio['MEIO'] == '3') {
                                                                                echo "Rádio Licenciado";
                                                                            } else if ($meio['MEIO'] == '4') {
                                                                                echo "Wireless Cliente";
                                                                            } else if ($meio['MEIO'] == '5') {
                                                                                echo "Fibra Clientes";
                                                                            }
                                                                            ?>
                                                                        </option>
                                                                        <option value="1">Wireless</option>
                                                                        <option value="2">Fibra</option>
                                                                        <option value="3">Rádio Licenciado</option>
                                                                        <option value="4">Wireless Cliente</option>
                                                                        <option value="5">Fibra Clientes</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="sinalocal"><b>Sinal Local</b></label>
                                                                    <input type="number" class="form-control" value="<?php echo (isset($info) ? $info->sinalocal : '') ?>" name="SINALLOCAL" placeholder="Sinal Local...">
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="sinalremoto"><b>Sinal Remoto</b></label>
                                                                    <input type="number" class="form-control" value="<?php echo (isset($info) ? $info->sinalremoto : '') ?>" name="SINALREMOTO" placeholder="Sinal Remoto...">
                                                                </div>

                                                                <div class="form-group col-md-12 mb-5">
                                                                    <label class="mb-2" for="obs"><b>Observação:</b></label>
                                                                    <div>
                                                                        <textarea name="OBSERVACAO" class="form-control"><?php echo (isset($info) ? $info->observacao : '') ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <h3><b>Informações do Ponto:</b></h3>
                                                                </div>

                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="nomeR"><b>Nome</b></label>
                                                                    <input type="text" class="form-control" value="<?php echo (isset($info) ? $info->nomepessoa : '') ?>" name="NOME" placeholder="Nome do responsável...">
                                                                </div>
                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="mail"><b>Email</b></label>
                                                                    <input type="mail" class="form-control" value="<?php echo (isset($info) ? $info->email : '') ?>" name="EMAIL" placeholder="Email do responsável...">
                                                                </div>
                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="tel"><b>Telefone</b></label>
                                                                    <input type="text" class="form-control telefone" minlength="15" maxlength="15" name="TELEFONE" value="<?php echo (isset($info) ? $info->telefone : '') ?>" placeholder="Telefone do responsável...">
                                                                </div>
                                                                <div class="form-group col-md-6 mb-5">
                                                                    <label class="mb-2" for="end"><b>Endereço</b></label>
                                                                    <input type="text" class="form-control" value="<?php echo (isset($info) ? $info->endereco : '') ?>" name="ENDERECO" placeholder="Endereço do ponto...">
                                                                </div>
                                                                <div class="form-group col-md-12 mb-5">
                                                                    <label class="mb-2" for="patri"><b>Patrimonio:</b></label>
                                                                    <div>
                                                                        <textarea name="PATRIMONIO" class="form-control"><?php echo (isset($info) ? $info->patrimonio : '') ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if ($msg === 'Erro ao inserir ponto' or $msg === 'Erro ao Atualizar ponto') { ?>
                                                                    <?php if (isset($errors) != '') { ?>
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
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-4 text-center">
                                                                <button type="submit" class="btn pesquisaResult" style="padding: .375rem 2.75rem !important;">Enviar</button>
                                                            </div>
                                                            <div class="col-md-4"></div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modal<?php echo $info->idponto ?>">Fechar</button>
                                                        <button style="padding: .375rem 1.75rem !important;" class="btn btn-danger" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#excluir<?php echo $info->idponto  ?>"><img src="<?php echo base_url('public/imgs/trash.png') ?>" width="26px"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal editar -->
                                    <!-- modal excluir -->
                                    <div class="modal fade text-dark" id="excluir<?php echo $info->idponto ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/warning.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Excluír - Ponto</b></h5>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span style="font-size: initial;float: left;font-weight: normal;">Tem certeza que deseja deletar este ponto ?</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="<?php echo base_url('relacao/excluirInfo/' . $info->idponto) ?>">
                                                        <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                        <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                        <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                        <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editar<?php echo $info->idponto ?>">Voltar</a>
                                                        <button type="submit" class="btn btn-success">Sim</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal excluir -->
                                </div>
                            </div><?php } ?>
                        <table class="table table-striped table-hover cardPerson mb-4" align="center">
                            <tbody>
                                <div style="box-shadow: 0px 1px 9px 0px rgb(0 0 0 / 30%);" class="row m-0">
                                    <div style="padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; padding-bottom: 1rem; padding-top: 1rem; display: flex;align-items: center;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/user.png') ?>" width="35">&nbsp;&nbsp;<b>Nome do Responsável:&nbsp;&nbsp;</b><?php if ($info->nomepessoa != '') { ?><?php echo $info->nomepessoa ?><?php } else {
                                                                                                                                                                                                                                        echo "-";
                                                                                                                                                                                                                                    } ?>
                                    </div>
                                    <div style="padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/phone.png') ?>" width="35">&nbsp;&nbsp;<b>Telefone:&nbsp;&nbsp;</b><?php if ($info->telefone != '') { ?><a class="text-dark" href="tel:+<?php echo $info->telefone ?>"><?php echo $info->telefone ?></a><?php } else {
                                                                                                                                                                                                                                                                                            echo "-";
                                                                                                                                                                                                                                                                                        } ?>
                                    </div>
                                    <div style="background-color: #f2f2f2; padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/location.png') ?>" width="35">&nbsp;&nbsp;<b>Endereço:&nbsp;&nbsp;</b><?php if ($info->endereco != '') { ?><?php echo $info->endereco ?><?php } else {
                                                                                                                                                                                                                            echo "-";
                                                                                                                                                                                                                        } ?>
                                    </div>
                                    <div style="background-color: #f2f2f2; padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/email.png') ?>" width="35">&nbsp;&nbsp;<b>Email:&nbsp;&nbsp;</b><?php if ($info->email != '') { ?><?php echo $info->email ?><?php } else {
                                                                                                                                                                                                                echo "-";
                                                                                                                                                                                                            } ?>
                                    </div>
                                    <div style="padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/information.png') ?>" width="35">&nbsp;&nbsp;<b>Observação:&nbsp;&nbsp;</b><?php if ($info->observacao != '') { ?><?php echo $info->observacao ?><?php } else {
                                                                                                                                                                                                                                    echo "-";
                                                                                                                                                                                                                                } ?>
                                    </div>
                                    <div style="padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/wifi-signal.png') ?>" width="35">&nbsp;&nbsp;<b>Sinal Local:</b>&nbsp;&nbsp;<?php if ($info->sinalocal != '') { ?><?php echo $info->sinalocal ?><?php } else {
                                                                                                                                                                                                                                    echo "-";
                                                                                                                                                                                                                                } ?>
                                    </div>
                                    <div style="background-color: #f2f2f2; padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/wifi-signal.png') ?>" width="35">&nbsp;&nbsp;<b>Sinal Remoto:</b>&nbsp;&nbsp;<?php if ($info->sinalremoto != '') { ?><?php echo $info->sinalremoto ?><?php } else {
                                                                                                                                                                                                                                        echo "-";
                                                                                                                                                                                                                                    } ?>
                                    </div>
                                    <?php if (isset($info)) {
                                        $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                        mysqli_set_charset($connect, "utf8");
                                        $conecta = $info->CONECTA;
                                        $query = mysqli_query($connect, "SELECT NOMEPONTO FROM PONTO WHERE IDPONTO = '$conecta'");
                                        $envia = mysqli_fetch_array($query);
                                    } ?>
                                    <div style="background-color: #f2f2f2; padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem;" class="col-md-6">
                                        <img src="<?php echo base_url('public/imgs/back-arrow.png') ?>" width="40">&nbsp;&nbsp;<b>Recebe Sinal de:</b>&nbsp;&nbsp;<?php if ($envia != '') { ?><?php echo (isset($envia['NOMEPONTO']) ? $envia['NOMEPONTO'] : '') ?><?php } else {
                                                                                                                                                                                                                                                                    echo "-";
                                                                                                                                                                                                                                                                } ?>
                                    </div>
                                    <div style="padding-right: 2.5rem; padding-left: 2.5rem; padding-top: 1rem; display: flex;align-items: center; padding-bottom: 1rem; justify-content:center" class="col-md-12">
                                        <img src="<?php echo base_url('public/imgs/server.png') ?>" width="35">&nbsp;&nbsp;<b>Servidor:</b>&nbsp;&nbsp;<?php if ($info->servidor != '') { ?><?php echo $info->servidor ?><?php } else {
                                                                                                                                                                                                                            echo "-";
                                                                                                                                                                                                                        } ?>
                                    </div>
                                </div>
                            </tbody>

                        </table>
                    <?php } ?>
                    <?php if ($tables) { ?>


                        <table class="table table-striped table-hover" align="center">
                            <thead class="ponto">
                                <tr class="text-center">
                                    <th>Descrição</th>
                                    <th>Cidade</th>
                                    <th>IP</th>
                                    <th>Modo/Software</th>
                                    <th>Modelo/Canal</th>
                                    <th>Comentario</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tables as $table) { ?>
                                    <?php if ($table->ponto === $info->ponto) { ?>
                                        <tr class="text-center">
                                            <?php if ($table->descricao) { ?><td><?php echo $table->descricao ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->cidade) { ?><td><?php echo $table->cidade ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->ip) { ?><td><?php echo $table->ip ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->modo and $table->nomesoftware) { ?><td><?php echo $table->modo ?>/<?php echo $table->nomesoftware ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->modelo and $table->canal) { ?><td><?php echo $table->modelo ?><?php echo $table->canal ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->comentario) { ?><td><?php echo $table->comentario ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <td>
                                                <a style="margin-right: 0 !important;" class="btnPerson2" data-bs-toggle="modal" data-bs-target="#editar<?php echo $table->idequipamento ?>"><img src="<?php echo base_url('public/imgs/engine.png') ?>" width="23px"></a>
                                            </td>
                                            <!-- modal editar -->
                                            <div class="modal fade text-dark" id="editar<?php echo $table->idequipamento ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/edit.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Editar - Ponto</b></h5>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                            <div class="modal-body">
                                                        <form method="POST" action="<?php echo base_url('relacao/editarTable/' . $table->idequipamento) ?>">
                                                                <div class="paddingPonto">
                                                                    <input type="hidden" name="id" value="<?php echo (isset($table) ? $table->idequipamento : '') ?>">
                                                                    <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                                    <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                                    <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                                    <div class="row">

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="PONTOEQUIPAMENTO"><b>Pontos</b></label>
                                                                            <select name="PONTOEQUIPAMENTO" class="form-select" required>
                                                                                <?php
                                                                                if (isset($table)) {
                                                                                    $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                                                                    mysqli_set_charset($connect, "utf8");
                                                                                    $idPonto = $table->IDPONTO;
                                                                                    $query = mysqli_query($connect, "SELECT NOMEPONTO FROM PONTO WHERE IDPONTO = $idPonto");
                                                                                    $nomeServidor = mysqli_fetch_array($query);
                                                                                }
                                                                                ?>
                                                                                <option value="<?php echo (isset($table) ? $table->IDPONTO : '') ?>" selected><?php echo (isset($nomeServidor['NOMEPONTO']) ? $nomeServidor['NOMEPONTO'] : 'Selecione um Ponto...') ?></option>
                                                                                <?php foreach ($selectPontos as $selectP) { ?>
                                                                                    <option value="<?php echo $selectP->IDPONTO ?>"><?php echo $selectP->NOMEPONTO ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="CIDADEEQUIPAMENTO"><b>Cidades</b></label>
                                                                            <select name="CIDADEEQUIPAMENTO" class="form-select" required>
                                                                                <option value="<?php echo (isset($table) ? $table->IDCIDADE : '') ?>" selected><?php echo (isset($table->cidade) ? $table->cidade : 'Selecione uma Cidade...') ?></option>
                                                                                <?php foreach ($selectCidades as $selectC) { ?>
                                                                                    <option value="<?php echo $selectC->IDCIDADE ?>"><?php echo $selectC->NOMECIDADE ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="SOFTWAREEQUIPAMENTO"><b>Softwares</b></label>
                                                                            <select name="SOFTWAREEQUIPAMENTO" class="form-select" required>
                                                                                <option value="<?php echo (isset($table) ? $table->IDSOFTWARE : '') ?>" selected><?php echo (isset($table->nomesoftware) ? $table->nomesoftware : 'Selecione um Software...') ?></option>
                                                                                <?php foreach ($selectSoftwares as $selectSof) { ?>
                                                                                    <option value="<?php echo $selectSof->IDSOFTWARE ?>"><?php echo $selectSof->NOMESOFTWARE ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="MODELOEQUIPAMENTO"><b>Modelos</b></label>
                                                                            <select name="MODELOEQUIPAMENTO" class="form-select" required>
                                                                                <option value="<?php echo (isset($table) ? $table->IDMODELO : '') ?>" selected><?php echo (isset($table->modelo) ? $table->modelo : 'Selecione um Modelo...') ?></option>
                                                                                <?php foreach ($selectModelos as $selectMod) { ?>
                                                                                    <option value="<?php echo $selectMod->IDMODELO ?>"><?php echo $selectMod->NOMEMODELO ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="MODOEQUIPAMENTO"><b>Modos</b></label>
                                                                            <select name="MODOEQUIPAMENTO" class="form-select" required>
                                                                                <option value="<?php echo $table->MODOEQUIPAMENTO ?>" selected><?php echo (isset($table->modo) ? $table->modo : 'Selecione um Modo...') ?></option>
                                                                                <?php foreach ($selectModos as $selectMods) { ?>
                                                                                    <option value="<?php echo $selectMods->IDMODO ?>"><?php echo $selectMods->NOMEMODO ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="DESCRICAOEQUIPAMENTO"><b>Descrição do Equipamento</b></label>
                                                                            <input type="text" class="form-control" value="<?php echo (isset($table) ? $table->descricao : '') ?>" name="DESCRICAOEQUIPAMENTO" placeholder="Descrição do Equipamento...">
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="IP"><b>IP</b></label>
                                                                            <input type="text" class="form-control" value="<?php echo (isset($table) ? $table->ip : '') ?>" maxlength="15" name="IP" placeholder="Endereço de IP...">
                                                                        </div>

                                                                        <div class="form-group col-md-6 mb-5">
                                                                            <label class="mb-2" for="Canal"><b>Canal</b></label>
                                                                            <input type="number" class="form-control" value="<?php echo (isset($table) ? $table->canal : '') ?>" name="CANAL" placeholder="Número do Canal...">
                                                                        </div>

                                                                        <div class="form-group col-md-12 mb-5">
                                                                            <label class="mb-2" for="obs"><b>Observação:</b></label>
                                                                            <div class="form-floating">
                                                                                <textarea name="COMENTARIOEQUIPAMENTO" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"><?php echo (isset($table) ? $table->comentario : '') ?></textarea>
                                                                                <label for="floatingTextarea">observação...</label>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($msg === 'Erro ao inserir equipamento' or $msg === 'Erro ao Atualizar equipamento') { ?>
                                                                            <?php if (isset($errors) != '') { ?>
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
                                                                    <div class="col-md-4"></div>
                                                                    <div class="col-md-4 text-center">
                                                                        <button type="submit" class="btn pesquisaResult" style="padding: .375rem 2.75rem !important;">Enviar</button>
                                                                    </div>
                                                                    <div class="col-md-4"></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modal<?php echo $table->idequipamento ?>">Fechar</a>
                                                                <a style="padding: .375rem 1.75rem !important;" class="btn btn-danger" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#excluir<?php echo $table->idequipamento  ?>"><img src="<?php echo base_url('public/imgs/trash.png') ?>" width="26px"></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal editar -->

                                            <!-- modal excluir -->
                                            <div class="modal fade text-dark" id="excluir<?php echo $table->idequipamento ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/warning.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Excluír - Ponto</b></h5>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span style="font-size: initial;float: left;font-weight: normal;">Tem certeza que deseja deletar este ponto ?</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST" action="<?php echo base_url('relacao/excluirTable/' . $table->idequipamento) ?>">
                                                                <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                                <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                                <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                                <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editar<?php echo $table->idequipamento ?>">Voltar</a>
                                                                <button type="submit" class="btn btn-success">Sim</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal excluir -->
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    <hr>
                </div>
        <?php }
        } ?>

    <?php } else { ?>
        <div class="noData">
            <h5>Insira no campo acima sua Pesquisa...</h5>
        </div>
    <?php } ?>
    <?php
    if (isset($tables) and !empty($tables) and isset($infos) and empty($infos)) { ?>
        <?php if ($tables) { ?>
            <div class="row ponto2">
                <div class="col-md-4"></div>
                <div style="display: flex; justify-content: center; align-items: center" class="col-md-4 mt-2">Descrição dos Equipamentos</div>
                <div class="col-md-4"></div>
            </div>
            <table class="table ajusteTable2 table-striped table-hover" align="center">
                <thead class="ponto">
                    <tr class="text-center">
                    <th>Descrição</th>
                    <th>Cidade</th>
                    <th>IP</th>
                    <th>Modo/Software</th>
                    <th>Modelo/Canal</th>
                    <th>Comentario</th>
                    <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $table) { ?>
                        <?php if ($table->ponto) { ?>
                            <tr class="text-center">
                            <?php if ($table->descricao) { ?><td><?php echo $table->descricao ?></td><?php } else { ?><td>-</td><?php } ?>
                                    <?php if ($table->cidade) { ?><td><?php echo $table->cidade ?></td><?php } else { ?><td>-</td><?php } ?>
                                    <?php if ($table->ip) { ?><td><?php echo $table->ip ?></td><?php } else { ?><td>-</td><?php } ?>
                                    <?php if ($table->modo and $table->nomesoftware) { ?><td><?php echo $table->modo ?>/<?php echo $table->nomesoftware ?></td><?php } else { ?><td>-</td><?php } ?>
                                    <?php if ($table->modelo and $table->canal) { ?><td><?php echo $table->modelo ?><?php echo $table->canal ?></td><?php } else { ?><td>-</td><?php } ?>
                                    <?php if ($table->comentario) { ?><td><?php echo $table->comentario ?></td><?php } else { ?><td>-</td><?php } ?>
                                <td>
                                    <a style="margin-right: 0 !important;" class="btnPerson" data-bs-toggle="modal" data-bs-target="#editar<?php echo $table->idequipamento ?>"><img src="<?php echo base_url('public/imgs/engine.png') ?>" width="23px"></a>
                                </td>
                                <!-- modal editar -->
                                <div class="modal fade text-dark" id="editar<?php echo $table->idequipamento ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/edit.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Editar - Ponto</b></h5>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="<?php echo base_url('relacao/editarTable/' . $table->idequipamento) ?>">
                                                <div class="modal-body">
                                                    <div class="paddingPonto">
                                                        <input type="hidden" name="id" value="<?php echo (isset($table) ? $table->idequipamento : '') ?>">
                                                        <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                        <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                        <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                        <div class="row">

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="PONTOEQUIPAMENTO"><b>Pontos</b></label>
                                                                <select name="PONTOEQUIPAMENTO" class="form-select" required>
                                                                    <?php
                                                                    if (isset($table)) {
                                                                        $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
                                                                        mysqli_set_charset($connect, "utf8");
                                                                        $idPonto = $table->IDPONTO;
                                                                        $query = mysqli_query($connect, "SELECT NOMEPONTO FROM PONTO WHERE IDPONTO = $idPonto");
                                                                        $nomeServidor = mysqli_fetch_array($query);
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo (isset($table) ? $table->IDPONTO : '') ?>" selected><?php echo (isset($nomeServidor['NOMEPONTO']) ? $nomeServidor['NOMEPONTO'] : 'Selecione um Ponto...') ?></option>
                                                                    <?php foreach ($selectPontos as $selectP) { ?>
                                                                        <option value="<?php echo $selectP->IDPONTO ?>"><?php echo $selectP->NOMEPONTO ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="CIDADEEQUIPAMENTO"><b>Cidades</b></label>
                                                                <select name="CIDADEEQUIPAMENTO" class="form-select" required>
                                                                    <option value="<?php echo (isset($table) ? $table->IDCIDADE : '') ?>" selected><?php echo (isset($table->cidade) ? $table->cidade : 'Selecione uma Cidade...') ?></option>
                                                                    <?php foreach ($selectCidades as $selectC) { ?>
                                                                        <option value="<?php echo $selectC->IDCIDADE ?>"><?php echo $selectC->NOMECIDADE ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="SOFTWAREEQUIPAMENTO"><b>Softwares</b></label>
                                                                <select name="SOFTWAREEQUIPAMENTO" class="form-select" required>
                                                                    <option value="<?php echo (isset($table) ? $table->IDSOFTWARE : '') ?>" selected><?php echo (isset($table->nomesoftware) ? $table->nomesoftware : 'Selecione um Software...') ?></option>
                                                                    <?php foreach ($selectSoftwares as $selectSof) { ?>
                                                                        <option value="<?php echo $selectSof->IDSOFTWARE ?>"><?php echo $selectSof->NOMESOFTWARE ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="MODELOEQUIPAMENTO"><b>Modelos</b></label>
                                                                <select name="MODELOEQUIPAMENTO" class="form-select" required>
                                                                    <option value="<?php echo (isset($table) ? $table->IDMODELO : '') ?>" selected><?php echo (isset($table->modelo) ? $table->modelo : 'Selecione um Modelo...') ?></option>
                                                                    <?php foreach ($selectModelos as $selectMod) { ?>
                                                                        <option value="<?php echo $selectMod->IDMODELO ?>"><?php echo $selectMod->NOMEMODELO ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="MODOEQUIPAMENTO"><b>Modos</b></label>
                                                                <select name="MODOEQUIPAMENTO" class="form-select" required>
                                                                    <option value="<?php echo $table->MODOEQUIPAMENTO ?>" selected><?php echo (isset($table->modo) ? $table->modo : 'Selecione um Modo...') ?></option>
                                                                    <?php foreach ($selectModos as $selectMods) { ?>
                                                                        <option value="<?php echo $selectMods->IDMODO ?>"><?php echo $selectMods->NOMEMODO ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="DESCRICAOEQUIPAMENTO"><b>Descrição do Equipamento</b></label>
                                                                <input type="text" class="form-control" value="<?php echo (isset($table) ? $table->descricao : '') ?>" name="DESCRICAOEQUIPAMENTO" placeholder="Descrição do Equipamento...">
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="IP"><b>IP</b></label>
                                                                <input type="text" class="form-control" value="<?php echo (isset($table) ? $table->ip : '') ?>" maxlength="15" name="IP" placeholder="Endereço de IP...">
                                                            </div>

                                                            <div class="form-group col-md-6 mb-5">
                                                                <label class="mb-2" for="Canal"><b>Canal</b></label>
                                                                <input type="number" class="form-control" value="<?php echo (isset($table) ? $table->canal : '') ?>" name="CANAL" placeholder="Número do Canal...">
                                                            </div>

                                                            <div class="form-group col-md-12 mb-5">
                                                                <label class="mb-2" for="obs"><b>Observação:</b></label>
                                                                <div class="form-floating">
                                                                    <textarea name="COMENTARIOEQUIPAMENTO" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"><?php echo (isset($table) ? $table->comentario : '') ?></textarea>
                                                                    <label for="floatingTextarea">observação...</label>
                                                                </div>
                                                            </div>
                                                            <?php if ($msg === 'Erro ao inserir equipamento' or $msg === 'Erro ao Atualizar equipamento') { ?>
                                                                <?php if (isset($errors) != '') { ?>
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
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4 text-center">
                                                            <button type="submit" class="btn pesquisaResult" name="btnEditarPonto" style="padding: .375rem 2.75rem !important;">Enviar</button>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modal<?php echo $table->idequipamento ?>">Fechar</a>
                                                <a style="padding: .375rem 1.75rem !important;" class="btn btn-danger" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#excluir<?php echo $table->idequipamento  ?>"><img src="<?php echo base_url('public/imgs/trash.png') ?>" width="26px"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal editar -->

                                <!-- modal excluir -->
                                <div class="modal fade text-dark" id="excluir<?php echo $table->idequipamento ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/warning.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Excluír - Ponto</b></h5>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <span style="font-size: initial;float: left;font-weight: normal;">Tem certeza que deseja deletar este ponto ?</span>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="<?php echo base_url('relacao/excluirTable/' . $table->idequipamento) ?>">
                                                    <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                                    <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                                    <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
                                                    <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editar<?php echo $table->idequipamento ?>">Voltar</a>
                                                    <button type="submit" class="btn btn-success">Sim</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal excluir -->
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    <?php } ?>

</div>
<?php echo $this->include('footer') ?>