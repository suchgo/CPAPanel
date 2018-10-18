<?php include_once 'head.php'; ?>
	<div class="col-sm-9 col-lg-offset-1 col-lg-10 main">
		<?php foreach ($User->getCurrentOfferInfo() as $currentOfferRow); ?>
		<?php foreach ($User->getScriptTimeWork() as $currentScriptTimeWork); ?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Управление оффером - <?=$currentOfferRow['offer_name']?></h1>
			</div>
		</div><!--/.row-->
		<div class="panel panel-default">
			<div class="panel-heading"><a style="font-size: 14px;" class="btn-link" href="my-offers">Вернуться к списку офферов</a></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12" id="panel-container">
						<?php
							$User->addBase();
							$User->userBase();
							$User->clearLog();
							$User->logBase();
						 ?>
					</div>
					<div class="tabs">
						<ul class="nav nav-pills">
							<li class="active"><a href="#pilltab1" data-toggle="tab" aria-expanded="true">Ссылки JetSwap</a></li>
							<li class=""><a href="#pilltab2" data-toggle="tab" aria-expanded="false">Загрузить базу</a></li>
							<li class=""><a href="#pilltab3" data-toggle="tab" aria-expanded="false">Логи</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="pilltab1">
								<?php
									if($currentOfferRow['status']==1){
										if($currentOfferRow['jetswap_link_main']!='')
											echo '<div class="form-group"><label>Основной скрипт. Время показа сайта - "'.$currentScriptTimeWork['main_show_time'].'". Интервал показа сайта(рекомендовано) - "'.$currentScriptTimeWork['main_impression_interval'].'"</label><input value="'.htmlspecialchars($currentOfferRow['jetswap_link_main'], ENT_QUOTES).'" readonly class="form-control"></div>';
										else
											echo "<div class='form-group'><label>Основной скрипт</label><div class='alert bg-warning' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Для получения ссылки обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div></div>";
										if($currentOfferRow['jetswap_link_traffic']!='')
											echo '<div class="form-group"><label>Скрипт для трафика. Время показа сайта - "'.$currentScriptTimeWork['traffic_show_time'].'". Интервал показа сайта(рекомендовано) - "'.$currentScriptTimeWork['traffic_impression_interval'].'"</label><input value="'.htmlspecialchars($currentOfferRow['jetswap_link_traffic'], ENT_QUOTES).'" readonly class="form-control"></div>';
										else
											echo "<div class='form-group'><label>Скрипт для трафика</label><div class='alert bg-warning' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Для получения ссылки обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div></div>";
										if($currentOfferRow['jetswap_link_activity']!='')
											echo '<div class="form-group"><label>Скрипт для активности. Время показа сайта - "'.$currentScriptTimeWork['activity_show_time'].'". Интервал показа сайта(рекомендовано) - "'.$currentScriptTimeWork['activity_impression_interval'].'"</label><input value="'.htmlspecialchars($currentOfferRow['jetswap_link_activity'], ENT_QUOTES).'" readonly class="form-control"></div>';
										else
											echo "<div class='form-group'><label>Скрипт для активности</label><div class='alert bg-warning' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Для получения ссылки обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div></div>";
									}
									else{
										echo "<div class='alert bg-warning' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Модерируется! Обратитесь к администратору для ускорения процесса.<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
									}
								?>
							</div>
							<div class="tab-pane fade" id="pilltab2">
								<?php if(!$GLOBALS['error_db_user']):?>
								<div class="row">
									<form method="POST" enctype="multipart/form-data">									
										<div class="col-md-12">
											<label>Строки должны быть строго формата mail:pass. Домен почт - <?=$currentScriptTimeWork['domain']?></label>
											<div class="form-group">
												<textarea placeholder="mail:pass" name="db_mails" style="resize: none;height: 300px;" class="form-control" wrap="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php if(!$GLOBALS['error_db_user']) echo $User->userBase(); ?></textarea>
											</div>
										</div>
										<div class="col-md-12 ">
											<input type="submit" class="btn btn-lg btn-primary col-md-12 " id="btn-todo" name="addBase" value="Загрузить" />
										</div>
									</form>
								</div>
								<?php else:?>
									<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>База не подключена. Обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>
								<?php endif ?>
							</div>
							<div class="tab-pane fade" id="pilltab3">
								<?php if(!$GLOBALS['error_log_user']):?>
								<div class="row">
									<form method="POST" enctype="multipart/form-data">									
										<div class="col-md-12">
											<div class="form-group">
												<textarea readonly placeholder="mail:pass: IP: date and time" name="db_mails" style="resize: none;height: 300px;" class="form-control" wrap="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php if(!$GLOBALS['error_log_user']) echo $User->logBase(); ?></textarea>
											</div>
										</div>
										<div class="col-md-12 ">
											<input type="submit" class="btn btn-lg btn-primary col-md-12 " id="btn-todo" name="clearLog" value="Очистить логи" />
										</div>
									</form>
								</div>
								<?php else:?>
									<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Логи недоступны. Обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>
								<?php endif ?>
							</div>
						</div>
					</div>																		
				</div><!--/.row-->	
			</div>
		</div>
	</div>	<!--/.main-->
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>

	document.addEventListener('DOMContentLoaded', function() {
	$('.pull-right').click(function() {
	  $('div.alert').fadeOut(1000);
	}); 
	}, false);

	 
	</script>		
<?php include_once 'footer.php'; ?>