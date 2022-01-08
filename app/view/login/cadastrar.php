<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title><?php echo APP_NOME ?> - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>/public/css/estilos.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?php echo URL ?>/public/css/login.css?v=<?php echo time(); ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="row wrapper">
      <div class="col-sm-5 mx-auto">
        <form method="post" autocomplete="off">
          <h1 class="mb-3 text-center">GestãoBit</h1>
          <?php if ($dados['error']) {
            echo '
                <div class="alert alert-danger" role="alert">
                    ' . $dados['error'] . '
                </div>
            ';
          } ?>
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" value="" autofocus>
          <label for="senha">Senha</label>
          <input type="password" class="form-control" name="senha" id="senha" value="">
          <label for="resenha">Repita a Senha</label>
          <input type="password" class="form-control" name="resenha" id="resenha" value="">
          <div class="mt-3">
            <button class="btn btn-lg btn-primary btn-block form-control" type="submit">Cadastrar</button>
          </div>
        </form>
        <a href="<?php echo URL ?>/login" style="color: black;float: right;text-decoration: none;"><i class="fa fa-user" aria-hidden="true"></i> Já tenho uma conta</a>

      </div>
    </div>
  </div>
</body>

</html>