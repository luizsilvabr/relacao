<?php echo $this->include('header2'); ?>
<div class="content">
    <div class="title mb-2">
        <h1>Relação Unificada</h1>
    </div>
    <form class="searchForm" name="Form" action="<?php echo base_url('relacaoUnificada/pesquisar') ?>" method="POST" onsubmit="return validateForm()">
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
                <?php if ($info->nomepessoa or $info->telefone or $info->endereco or $info->email or $info->observacao or $info->sinalocal or $info->sinalremoto) { ?>
                    <?php if ($info->ponto != '') { ?>
                        <div class="itensSearch mb-4 mt-4">

                            <div class="ponto">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div style="display: flex; justify-content: center; align-items: center" class="col-md-4"><?php echo $info->ponto ?></div>
                                    <div class="col-md-4 text-end px-5"></div>
                                    <?php if (!empty($servidorPesquisado)) { ?><input type="hidden" name="servidorPesquisado" value="<?php echo $servidorPesquisado ?>"><?php } ?>
                                    <?php if (!empty($pontoPesquisado)) { ?><input type="hidden" name="pontoPesquisado" value="<?php echo $pontoPesquisado ?>"><?php } ?>
                                    <?php if (!empty($desc)) { ?><input type="hidden" name="desc" value="<?php echo $desc ?>"><?php } ?>
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
                                    <th>Modo</th>
                                    <th>Software</th>
                                    <th>Modelo</th>
                                    <th>Comentario</th>
                                    <th>Canal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tables as $table) { ?>
                                    <?php if ($table->ponto === $info->ponto) { ?>
                                        <tr class="text-center">
                                            <?php if ($table->descricao) { ?><td><?php echo $table->descricao ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->cidade) { ?><td><?php echo $table->cidade ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->ip) { ?><td><?php echo $table->ip ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->modo) { ?><td><?php echo $table->modo ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->nomesoftware) { ?><td><?php echo $table->nomesoftware ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->modelo) { ?><td><?php echo $table->modelo ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->comentario) { ?><td><?php echo $table->comentario ?></td><?php } else { ?><td>-</td><?php } ?>
                                            <?php if ($table->canal) { ?><td><?php echo $table->canal ?></td><?php } else { ?><td>-</td><?php } ?>
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
                        <div style="display: flex; justify-content:center; align-items:center;" class="col-md-4 mt-2">Descrição dos Equipamentos</div>
                        <div class="col-md-4"></div>
                    </div>
                    <table class="table ajusteTable2 table-striped table-hover" align="center">
                        <thead class="ponto">
                            <tr class="text-center">
                                <th>Descrição</th>
                                <th>Ponto</th>
                                <th>Cidade</th>
                                <th>IP</th>
                                <th>Modo</th>
                                <th>Software</th>
                                <th>Modelo</th>
                                <th>Canal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tables as $table) { ?>
                                <?php if ($table->ponto) { ?>
                                    <tr class="text-center">
                                        <?php if ($table->descricao) { ?><td><?php echo $table->descricao ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->ponto) { ?><td><?php echo $table->ponto ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->cidade) { ?><td><?php echo $table->cidade ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->ip) { ?><td><?php echo $table->ip ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->modo) { ?><td><?php echo $table->modo ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->nomesoftware) { ?><td><?php echo $table->nomesoftware ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->modelo) { ?><td><?php echo $table->modelo ?></td><?php } else { ?><td>-</td><?php } ?>
                                        <?php if ($table->canal) { ?><td><?php echo $table->canal ?></td><?php } else { ?><td>-</td><?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            <?php } ?>

</div>
<?php echo $this->include('footer') ?>