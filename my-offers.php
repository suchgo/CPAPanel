<?php include_once 'head.php'; ?>
	<div class="col-sm-9 col-lg-offset-1 col-lg-10 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Мои офферы</h1>
			</div>
		</div><!--/.row-->

		<div class="panel panel-container col-sm-12">
			<div class="row">
				<div class="col-lg-12" id="panel-container">	
				</div>
			</div>
			<div class="row">
                <div class="panel-body">
                    <ol class="todo-list">
						<form id="deleteOfferForm">
							<?php if($User->getUserOffers()==null)echo "<label>Пусто.</label>";
							foreach ($User->getUserOffers() as $userOffers):?>
								<li class="todo-list-item">
									<a href="/edit-offer?id=<?=$userOffers['id']?>"><?=$userOffers['offer_name']?></a>
									<div class="pull-right action-buttons"><a title="Удалить оффер" style="cursor:pointer;" class="deleteOffer" class="trash" name="deleteOffer<?=$userOffers['id']?>" data-id="<?=$userOffers['id']?>"><em class="fa fa-trash"></em></a></div>
								</li>
							<?php endforeach;?>
						</form>
                    </ol>
                </div>
			</div><!--/.row-->
		</div>
	</div>	<!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
		  $('.todo-list-item').on('click', '.deleteOffer', function() { 
			  var dell = $(this).attr('data-id');
			  var dellName = $(this).attr('name');
		      $.ajax({
		          url: 'deleteOffer-controller.php',
		          type: "POST",
		          data: {id:dell, action:dellName},
		          beforeSend: function() {
					$("#panel-container").show().html('');         		
		          },
		          success: function(data) {
			           if(data=="ok")
			           {
						 $("<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Оффер успешно удален!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(500).appendTo('#panel-container').fadeOut(1700);
			             setTimeout(function(){
			             location.reload();
			             }, 1800);  
			           }
					   else
			           {
						   $("<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Ошибка удаления оффера. Обратитесь к администратору!<a href='#' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div> ").fadeIn(800).appendTo('#panel-container')
			           }
		          }
		      });
					return false;
		  });
		});
	</script>
<?php include_once 'footer.php'; ?>