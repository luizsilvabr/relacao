<?php if ($is_admin === '1') { ?>
    <?php echo $this->include('header'); ?>
<?php } else { ?>
    <?php echo $this->include('header2'); ?>
<?php } ?>
<!-- content -->
<div class="contentNoFlex">
    <div class="title mb-2">
        <h1>Servidores</h1>
    </div>
    <a class="btn btn-success btnInsert" href="<?php echo base_url('servidores/adicionar') ?>">Adicionar novo sistema</a>
    <table class="table table-striped table-hover" id="tableServer">
        <thead class="tableHead">
            <tr class="text-center">
                <th>#</th>
                <th>Servidores</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($servidores) { ?>
                <?php foreach ($servidores as $servidor) { ?>
                    <tr class="text-center">
                        <td><?php echo $servidor->IDSERVIDOR ?></td>
                        <td><?php echo $servidor->NOMESERVIDOR ?></td>
                        <td>
                            <a class="btnPerson" href="<?php echo base_url('servidores/editar/' . $servidor->IDSERVIDOR) ?>"><img src="<?php echo base_url('public/imgs/pen.png') ?>" width="23px"></a>
                            <a class="btnPerson" data-bs-toggle="modal" data-bs-target="#modal<?php echo $servidor->IDSERVIDOR ?>"><img src="<?php echo base_url('public/imgs/trash.png') ?>" width="23px"></a>
                            <!-- Modal -->
                            <div class="modal fade" id="modal<?php echo $servidor->IDSERVIDOR ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><img src="<?php echo base_url('public/imgs/warning.png') ?>" width="30px">&nbsp;<h5 class="mt-2"><b>Atenção</b></h5>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <span>Tem certeza que deseja deletar este servidor ?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                                            <a class="btn btn-success" href="<?php echo base_url('servidores/excluir/' . $servidor->IDSERVIDOR) ?>">Sim</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr class="text-center">
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- end content -->

<?php echo $this->include('footer'); ?>