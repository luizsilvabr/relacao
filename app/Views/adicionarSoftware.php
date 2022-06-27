<?php if ($is_admin === '1') { ?>
    <?php echo $this->include('header'); ?>
<?php } else { ?>
    <?php echo $this->include('header2'); ?>
<?php } ?>

<!-- content -->
<div class="content">
    <div class="cardAdd">
        <div class="title">
            <h1 style="margin-top: -120px"><?php echo $title ?></h1>
        </div>
        <form class="formAdd" method="POST">
            <input type="hidden" name="id" value="<?php echo (isset($software) ? $software->IDSOFTWARE : '') ?>">
            <div class="form-group mx-5 mr-5 mb-5">
                <label class="mb-2" for="nome"><b>Nome do Software</b></label>
                <input type="text" class="form-control" required minlength="2" value="<?php echo (isset($software) ? $software->NOMESOFTWARE : '') ?>" name="NOMESOFTWARE" placeholder="Software...">
            </div>
            <?php if ($msg === 'Erro ao inserir software' or $msg === 'Erro ao Atualizar software') { ?>
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


            <div class="row">
                <div class="col-md-4">
                    <a href="<?php echo base_url('/softwares') ?>" class="m-5"><img src="<?php echo base_url('public/imgs/left-arrow.png') ?>" width="40px"></a>
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