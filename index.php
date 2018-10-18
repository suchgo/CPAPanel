<?php include_once 'head.php'; ?>
<?php foreach ($User->getUserInfo() as $userRow) ?>
<div class="col-sm-9 col-lg-10 col-lg-offset-1  main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Панель управления</h1>
			</div>
		</div><!--/.row-->
		
		<div class="panel panel-container">
			<div class="row">
				<a class="iconhover" href="/new-offer">
					<div class="col-xs-6 col-md-6 col-lg-6 no-padding">
						<div class="panel-teal panel-widget border-right">
							<div class="row no-padding"><em class="fa fa-xl fa-plus color-blue iconMainMenu1"></em>
								<h3>Подключить оффер</h3>
							</div>
						</div>
					</div>
				</a>
				<a class="iconhover" href="/my-offers">
					<div class="col-xs-6 col-md-6 col-lg-6 no-padding">
						<div class="panel-teal panel-widget">
							<div class="row no-padding"><em class="fa fa-xl fa-user color-blue iconMainMenu2"></em>
								<h3>Мои офферы</h3>
							</div>
						</div>
					</div>
				</a>
			</div><!--/.row-->
		</div>
	</div>
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script>
		window.onload = function () {
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
	responsive: true,
	scaleLineColor: "rgba(0,0,0,.2)",
	scaleGridLineColor: "rgba(0,0,0,.05)",
	scaleFontColor: "#c5c7cc"
	});
};
	</script>
<?php include_once 'footer.php'; ?>