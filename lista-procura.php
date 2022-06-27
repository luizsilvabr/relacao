<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>


  <?php
  # PHP 7
  $conexao = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
  $banco = mysqli_select_db($conexao, 'relacao');
  mysqli_set_charset($conexao, 'utf8');

  $servidor = $_POST['servidor'];

  $sql = "SELECT * FROM PONTO WHERE SERVIDORPONTO = $servidor ORDER BY NOMEPONTO ASC;";
  $qr = mysqli_query($conexao, $sql) or die("erro");
  ?>
  <option selected value="">Escolha um Ponto de Acesso</option>
  <?php 
  while ($ln = mysqli_fetch_assoc($qr)) { ?>
    <option value="<?php echo $ln['NOMEPONTO'] ?>"><?php echo $ln['NOMEPONTO']?></option>
  <?php }?>
</body>

</html>