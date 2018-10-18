<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'].'/_app/core/init.php';
  if(!$User->is_loggedin())
  {
   $User->redirect('/login');
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CPA Panel</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/datepicker3.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  
  <!--Custom Font-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	<?php foreach ($User->getUserInfo() as $userRow) ?>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid" style="padding-right: 30px; padding-left: 50px;">
			<div class="row">
				<div class="col-lg-12">
					<div class="navbar-header">
						<a class="navbar-brand" href="/"><span>CPA</span> PANEL </a>
						<ul class="nav navbar-right" style="margin:12px 12px;">
							<li>
								<div>
									<div class="profile-userpic">
										<i class="fa fa-user-circle img-responsive" aria-hidden="true"></i>
									</div>
									<div class="profile-usertitle-name">
										<h5><strong><?=$userRow['username'];?></strong></h5>
									</div> 
									<div class="profile-usertitle" style="margin-top: 3px;">
										<?php 
										if (isset($_POST['signout']))
											$User->doLogout();
										?>        
										<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
											<input type="submit" class="btn btn-sm btn-danger" value="Выйти" name="signout">
										</form>
									</div>												  
								</div>
							</li>
						</ul>					  
					</div>
				</div>
			</div>	
		</div><!-- /.container-fluid -->
	</nav>