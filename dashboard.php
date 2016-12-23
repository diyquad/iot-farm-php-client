<?php

// Rapporte toutes les erreurs à part les E_NOTICE
// C'est la configuration par défaut de php.ini
error_reporting(E_ALL & ~E_NOTICE);

include("fonctions.php");
session_start();
if(!isset($_SESSION['username'])) {
	header('Location: index.php');      
	exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="admin-themes-lab">
    <meta name="author" content="themes-lab">
    <link rel="shortcut icon" href="assets/global/images/favicon.ico" type="image/png">
    <title>Robot Perso</title>
    <link href="assets/global/css/style.css" rel="stylesheet">
    <link href="assets/global/css/theme.css" rel="stylesheet">
    <link href="assets/global/css/ui.css" rel="stylesheet">
    <link href="assets/admin/layout4/css/layout.css" rel="stylesheet">
    <script src="assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
  </head>
  <!-- BEGIN BODY -->
  <body class="sidebar-top fixed-topbar fixed-sidebar theme-sdtl color-default">
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <section>
      <?php include("partials/menu.php"); ?>
              <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
          <div class="row">
            
            <div class="col-md-12">
	            <div class="col-md-3">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-tint bg-green"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-moisture1">0</p>
	                      <p class="text">Humidité <strong>Dwarf</strong></p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-3">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-tint bg-blue"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-moisture2">0</p>
	                      <p class="text">Humidité <strong>White</strong></p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-3">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-lightbulb-o bg-yellow" id="lumiere"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-light">0</p>
	                      <p class="text">Lumière</p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	             <div class="col-md-3">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-lightbulb-o bg-yellow" id="lumiere"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="rpi-status">DISCONNECTED ;(</p>
	                      <p class="text">RPI NODE</p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	             <div class="row">
		 	<div class="col-md-12" id="pompe">
				<div class="btn btn-primary" id="pompe-on">Pompe ON</div>
				<div class="btn btn-primary" id="pompe-off">Pompe OFF</div>
				<div class="btn btn-primary" id="pompe-arrosage">Pompe ARROSAGE</div>
			</div>	
	      </div>

	           <div class="col-md-6">
		           <div align="center"><h2>Dernière informations</h2></div>
		            <div id="liste-infos"> </div>
		            
		          
		       </div>
            </div>  
          </div><!-- FIN ROW 1 -->
                  
          
          <div class="row m-t-10">
            <div id="liste-infos"> </div>
            
          </div>
          
         	      
	      <div class="row"><!-- debut champs ajouter infos -->
			<div class="col-md-12" style="text-align: center;">
				<button class="btn btn-primary" id="ajout-infos">Ajouter une info</button>
				<div class="row" id="form-infos"><!-- debut champs masquer -->
					<div class="col-sm-12">
						<input data-provide="datepicker" id="date-infos" placeholder="Date.."><br/>
						<input type="text" id="titre-infos" placeholder="titre infos" size="50"><br/>
						<textarea id="text-infos" placeholder="Commentaire..." rows="4" cols="48"></textarea><br/>
						<a class="btn btn-primary" id="valider-infos">Ajouter</a>
					</div>
				</div>
				<div class="row" id="confirmation-infos"><!-- debut champs masquer -->
					<div class="col-sm-12">
						<p> info ajouté </p>
					</div>
				</div>
			</div>		
	      </div>
	      
	      <div class="row">
			<div class="col-sm-12" id="chart-container">
				<div id="chart-moisture" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	
			</div>		
	      </div>
	      
         
                
        </div>
        <!-- END PAGE CONTENT -->
      </div>
      <!-- END MAIN CONTENT -->
          
    </section>
    
    <!-- BEGIN PRELOADER -->
    <div class="loader-overlay">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
    </div>
    <!-- END PRELOADER -->
    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a> 
    <script src="assets/global/plugins/jquery/jquery-3.1.0.min.js"></script>
    <script src="assets/global/plugins/jquery/jquery-migrate-3.0.0.min.js"></script>
    <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/global/plugins/gsap/main-gsap.min.js"></script>
    <script src="assets/global/plugins/tether/js/tether.min.js"></script>
    <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/global/plugins/appear/jquery.appear.js"></script>
    <script src="assets/global/plugins/jquery-cookies/jquery.cookies.min.js"></script> <!-- Jquery Cookies, for theme -->
    <script src="assets/global/plugins/jquery-block-ui/jquery.blockUI.min.js"></script> <!-- simulate synchronous behavior when using AJAX -->
    <script src="assets/global/plugins/bootbox/bootbox.min.js"></script> <!-- Modal with Validation -->
    <script src="assets/global/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> <!-- Custom Scrollbar sidebar -->
    <script src="assets/global/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js"></script> <!-- Show Dropdown on Mouseover -->
    <script src="assets/global/plugins/retina/retina.min.js"></script> <!-- Retina Display -->
    <script src="assets/global/js/application.js"></script> <!-- Main Application Script -->
    <script src="assets/global/js/plugins.js"></script> <!-- Main Plugin Initialization Script -->
    <!-- BEGIN PAGE SCRIPT -->
    <!-- END PAGE SCRIPT -->
    <script src="assets/admin/layout4/js/layout.js"></script>
    <script src="assets/global/js/custom.js"></script> <!-- Search Script -->
    <script>
		$('#pompe-on').on('mousedown', function(){
		    console.log('HTML: --->Demande de pompe');
		    socket.emit('pompe-on');
		});
		$('#pompe-off').on('mousedown', function(){
		  	console.log('HTML: --->Demande de pompe');
		  	socket.emit('pompe-off');
		});
		$('#pompe-arrosage').on('mousedown', function(){
		  	console.log('HTML: --->Demande de pompe');
		  	socket.emit('pompe-arrosage');
		});
		
		//ON se connecte au port 5001
		var address = "89.2.170.137:5001"
        //Connection avec le robot
        console.log('HTML: attempting to connect to robot');
        console.log('@' + address);
        socket = io.connect(address);
		
		
		//On va gerer les dats
		var datafinale = new Array();
		var moisture2 = new Array();
		var intermediaire,i=0;
		
				
		
	</script>
    
  </body>
</html>