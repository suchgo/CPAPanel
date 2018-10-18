<?php include_once 'head.php'; ?>
	<div class="col-sm-9 col-lg-10 col-lg-offset-1 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Добавить новый оффер</h1>
			</div>
		</div><!--/.row-->
	
		<div class="panel panel-container col-sm-12">
			<div class="row">
				<div class="col-lg-12" id="panel-container">	
				</div>
			</div>	
			<form id="choose-offer-form">
				<div class="row">
					<div class="col-md-4 ">
						<div class="form-group">
							<label>Выберите оффер</label>
							<select name="offer_id" class="form-control">
								<option>-</option>
								<?php if ($User->getListOffers() !== null ) {  ?>
								<?php foreach ($User->getListOffers() as $offersList) : ?>
								<option value="<?=$offersList['id']; ?>"><?=$offersList['name']; ?></option>
								<?php endforeach; ?>
								<?php } else echo "Ошибка. Вы можете вернуться на<a href='/'> Главную страницу</a>" ?>			
							</select>
						</div>
					</div>				
					<div class="col-md-4">
						<div class="form-group">
							<label>Описание (без пробелов)</label>
							<input name="tag_name" class="form-control" placeholder="Описание">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Реф. ссылка оффера</label>
							<input name="ref_offer"  class="form-control" placeholder="Ссылка оффера">
						</div>
					</div>																			
				</div><!--/.row-->
					<div class="row">
						<div class="col-md-12 ">
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-md col-md-12 " name="addOffer" id="addOffer" value="Подключить" />
							</div>
						</div>					
					</div>
			</form>

		</div>
	</div>	<!--/.main-->
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
		  $('#addOffer').click(function() {
					var data = $("#choose-offer-form").serialize();
		      $.ajax({
		          url: 'user-controller.php',
		          type: "POST",
		          data: data,
		          beforeSend: function() {
									$("#panel-container").show().html('');         		
		          },
		          success: function(data) {

			           if(data=="ok")
			           {
			             $("<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Оффер успешно добавлен!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container').fadeOut(5000);
			             $("#choose-offer-form").get(0).reset();
			              // setTimeout(function(){
			              //   location.reload();
			              // }, 2500);   
			           }
			           else if(data=="space")
			           {
						   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>В поле 'Описание' запрещенно использовать пробел!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
					   else if(data=="limit")
			           {
						   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Превышен лимит подключения данного офера!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
			           else if(data=="duplicate")
			           {
						   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Оффер с таким названием уже добавлен!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
					   else
			           {
						   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Заполните все поля!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
		          }
		      });
					return false;
		  });
		});  
</script>		
<?php include_once 'footer.php'; ?>