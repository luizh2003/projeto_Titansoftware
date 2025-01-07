<?php
$nome_arquivo = basename($_SERVER['SCRIPT_FILENAME']);
if($nome_arquivo!='menu.php') 
{
	error_reporting(0);
	//conexao com o banco para nao precisar incluir em todas paginas
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "titansoftwareerp";
	$conn = mysqli_connect($servername, $username, $password, $dbname); //or print (mysql_error()); 
	//echo "Entrou no IF do backoffice";
	$title="titansoftwareerp";
	/*****************************************************aqui comeca dark mode deixa o sistema em noturno********************************/
	?>
    
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Titansoftware</title>
		<!-- Iconic Fonts -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="/realsbet/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="/realsbet/vendors/iconic-fonts/flat-icons/flaticon.css">
		<link rel="stylesheet" href="/realsbet/vendors/iconic-fonts/cryptocoins/cryptocoins.css">
		<link rel="stylesheet" href="/realsbet/vendors/iconic-fonts/cryptocoins/cryptocoins-colors.css">
		<!-- Bootstrap core CSS -->
		<link href="/realsbet/assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery UI -->
		<link href="/realsbet/assets/css/jquery-ui.min.css" rel="stylesheet">
		<!-- Page Specific CSS (Slick Slider.css) -->
		<link href="/realsbet/assets/css/slick.css" rel="stylesheet">
		<!-- medboard styles -->
		<link href="/realsbet/assets/css/style.css" rel="stylesheet">
		<!-- Page Specific CSS (Morris Charts.css) -->
		<link href="/realsbet/assets/css/morris.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <!-- CSS do Select2 -->
    	<link rel="stylesheet" href="/realsbet/select2.css">      
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="32x32" href=""> 
	</head>
	
    <?php
	//print_r($parsed_url);
	if(strpos($nome_arquivo, 'script_')!==0 && strpos($nome_arquivo, 'modal_')!==0)
	{
	?>
	<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
	  <!-- Main Content -->
	  <main class="body-content">
	  <!-- Preloader -->
	  <div id="preloader-wrap">
		<div class="spinner spinner-8">
		  <div class="ms-circle1 ms-child"></div>
		  <div class="ms-circle2 ms-child"></div>
		  <div class="ms-circle3 ms-child"></div>
		  <div class="ms-circle4 ms-child"></div>
		  <div class="ms-circle5 ms-child"></div>
		  <div class="ms-circle6 ms-child"></div>
		  <div class="ms-circle7 ms-child"></div>
		  <div class="ms-circle8 ms-child"></div>
		  <div class="ms-circle9 ms-child"></div>
		  <div class="ms-circle10 ms-child"></div>
		  <div class="ms-circle11 ms-child"></div>
		  <div class="ms-circle12 ms-child"></div>
		</div>
	  </div>
	  <?php /*****************************************************aqui termina dark mode deixa o sistema em noturno********************************/?>
	
    
   
	  <?php /*****************************************aqui comeca menu lateral completo*******************************************************/?>
        <!-- Overlays -->
        <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
        <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
        <!-- Sidebar Navigation Left-->
        <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
        <!-- Logo -->
        <div class="logo-sn ms-d-block-lg">
          <!--<a class="pl-0 ml-0 text-center" href="index.html"><img src="../assets/img/medboard-logo-216x62.png" alt="logo"> </a>-->
          <!--<a href="#" class="text-center mt-2">
          <img src="/realsbet/assets/img/realsbet_logo.webp">
          </a>-->
          <h5 class="text-center text-white mt-4">Titansoftware</h5>    
          <!--<h6 class="text-center text-white mb-3">Admin</h6>-->
        </div>
        
        <!-- Navigation -->
        <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion"> 
            <!-- Doctor -->
            <li class="menu-item">
                <a href="#" class="has-chevron" data-toggle="collapse" data-target="#meusDados" aria-expanded="false" aria-controls="meusDados">
                  <span><i class="fas fa-user"></i>Contas a Pagar</span>
                </a>
                <ul id="meusDados" class="collapse" aria-labelledby="meusDados" data-parent="#side-nav-accordion">
                    <li><a href="/titanSoftwareERP/conta_paga/cadastro.php">Cadastrar</a> </li>
                    <li><a href="/titanSoftwareERP/conta_paga/listar.php">Visualizar</a> </li>
                </ul>
            </li>
            <!-- Doctor -->
        </ul>
	</aside>
	<?php /***************************aqui termina menu lateral completo*******************************************************/?>
	   
       
	<?php /*********************************************aqui comeca menu topo completo***************************************/?>
	  <!-- Navigation Bar -->
	  <nav class="navbar ms-navbar">
		  <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
			<span class="ms-toggler-bar bg-white"></span>
			<span class="ms-toggler-bar bg-white"></span>
			<span class="ms-toggler-bar bg-white"></span>
		  </div>

		  <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
			<li class="ms-nav-item dropdown">
			  <!--<a href="#" class="text-disabled ms-has-notification" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-bell"></i></a>-->
			  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
				<li class="dropdown-menu-header">
				  <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Notifications</span></h6>
				  <span class="badge badge-pill badge-info">4 New</span>
				</li>
				<li class="dropdown-divider"></li>
				<li class="ms-scrollable ms-dropdown-list">
				  <a class="media p-2" href="#">
					<div class="media-body">
					  <span>12 ways to improve your crypto dashboard</span>
					  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 30 seconds ago</p>
					</div>
				  </a>
				  <a class="media p-2" href="#">
					<div class="media-body">
					  <span>You have newly registered users</span>
					  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 45 minutes ago</p>
					</div>
				  </a>
				  <a class="media p-2" href="#">
					<div class="media-body">
					  <span>Your account was logged in from an unauthorized IP</span>
					  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 2 hours ago</p>
					</div>
				  </a>
				  <a class="media p-2" href="#">
					<div class="media-body">
					  <span>An application form has been submitted</span>
					  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 1 day ago</p>
					</div>
				  </a>
				</li>
				<li class="dropdown-divider"></li>
				<li class="dropdown-menu-footer text-center">
				  <a href="#">View all Notifications</a>
				</li>
			  </ul>
			</li>
		  </ul>
		  <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
			<span class="ms-toggler-bar bg-white"></span>
			<span class="ms-toggler-bar bg-white"></span>
			<span class="ms-toggler-bar bg-white"></span>
		  </div>
		</nav>
	</body>
    <?php } ?>
	</html>
    <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="/realsbet/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/realsbet/assets/js/popper.min.js"></script>
    <script src="/realsbet/assets/js/bootstrap.min.js"></script>
    <script src="/realsbet/assets/js/perfect-scrollbar.js"> </script>
    <script src="/realsbet/assets/js/jquery-ui.min.js"> </script>
    
    <!-- Global Required Scripts End -->
    <script src="/realsbet/assets/js/d3.v3.min.js"> </script>
    <script src="/realsbet/assets/js/topojson.v1.min.js"> </script>
    <script src="/realsbet/assets/js/datamaps.all.min.js"> </script>
    
    
    <!-- Page Specific Scripts Start -->
    <script src="/realsbet/assets/js/slick.min.js"> </script>
    <script src="/realsbet/assets/js/moment.js"> </script>
    <script src="/realsbet/assets/js/jquery.webticker.min.js"> </script>
    <script src="/realsbet/assets/js/Chart.bundle.min.js"> </script>
    <script src="/realsbet/assets/js/index-chart.js"> </script>
    
    <!-- Page Specific Scripts Finish -->
    <script src="/realsbet/assets/js/calendar.js"></script>
    <!-- medboard core JavaScript -->
    <script src="/realsbet/assets/js/framework.js"></script>
    <!-- Settings -->
    <script src="/realsbet/assets/js/settings.js"></script>
    <script src="/realsbet/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS do Select2 -->
   	<script src="/realsbet/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.0.7/imask.min.js"></script>
    <script src="/realsbet/viacep.js"></script>
    <script src="/realsbet/func_caixa_alta.js"></script>
<?php
}
?>