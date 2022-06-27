<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('/public/css/iziToast.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/css/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <title>Relação</title>
</head>

<body>
    <!-- navbar -->
    <div class="navbar">
        <div class="logo"><img src="<?php echo base_url('/public/imgs/logo.png') ?>" width="165px"></div>
        <div class="itens">
            <a href="<?php echo base_url('/relacao') ?>"><span>Home</span><img src="<?php echo base_url('public/imgs/home.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/equipamentos/adicionar') ?>"><span>APS</span><img src="<?php echo base_url('public/imgs/aps.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/cidades') ?>"><span>Cidades</span><img src="<?php echo base_url('public/imgs/citys.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/modelos') ?>"><span>Modelo de Equipamentos</span><img src="<?php echo base_url('public/imgs/modelo_equip.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/modoOperacao') ?>"><span>Modo de Operação</span><img src="<?php echo base_url('public/imgs/operation_mode.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('pontos/adicionar') ?>"><span>Pontos</span><img src="<?php echo base_url('public/imgs/pontos.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/servidores') ?>"><span>Servidores</span><img src="<?php echo base_url('public/imgs/server.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('/softwares') ?>"><span>Softwares</span><img src="<?php echo base_url('public/imgs/software.png') ?>" width="40px"></a>
            <a href="<?php echo base_url('usuarios/signOut') ?>"><span>Logout</span><img src="<?php echo base_url('public/imgs/logout.png') ?>" width="40px"></a>
        </div>
    </div>
    <!-- end navbar -->