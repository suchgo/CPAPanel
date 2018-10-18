<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'].'/_app/core/init.php';
  if($User->is_loggedin())
  {
   $User->redirect('/');
  }  

	if($_SERVER['HTTP_REFERER'] == '/logout' )
	{
	 $User->doLogout(); 
	
	} 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CPAPanel - Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
    <div class="login-box">
      <div class="login-logo">
        <b>CPA Panel</b>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      <div id="login-error">
				<?php 
				if (isset($_POST['enter'])) {
			    $username  = safety($_POST['username']);
			    $password  = safety($_POST['password']);

					$User->doLogin($username,$password);
					
				}
				?>      	
      </div>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
          <div class="form-group has-feedback">
            <input name="username" value="<?echo $username?>" autofocus="" type="text" class="form-control form-input" placeholder="Логин"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control form-input" placeholder="Пароль"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
<!--                           <input class="btn green form-input-btn" type="submit"  name="loginSubmit" value="Авторизация"> -->
							<input type="submit" class="btn btn-md btn-primary btn-block" name="enter" value="Войти">
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
		</div><!-- /.col-->
	</div><!-- /.row -->	


<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
