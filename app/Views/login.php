<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css')?>">
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="titleSection">
            <div class="text-center">
                <img src="<?php echo base_url('public/imgs/lpnet-logo.png')?>" width="300px">
                <span class="titleLogin">Relação Unificada</span>
            </div>
        </div>
        <div class="inputSection">
            <form action="<?php echo base_url('usuarios/signIn') ?>" method="post">
                <h1 class="text-center mb-5"><b>Bem Vindo!</b></h1>
                <input type="text" name="USUARIO" required class="form-controlP mb-5" placeholder="Username:">
                <input type="password" name="SENHA" required class="form-controlP mb-5" placeholder="Senha:">
                <input type="checkbox">
                <label for="manterLogado"><b>Manter Logado</b></label>
                <?php $msg = session()->getFlashData('msg') ?>
                <?php if ($msg != '') { ?>
                    <div class="errorLogin">
                        <ul>
                            <p><b><?php echo $msg ?></b></p>
                        </ul>
                    </div>
                <?php } ?>
                <div class="centerButton">
                    <button type="submit" class="btn btn-personLogin mt-4">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>