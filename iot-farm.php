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
	         <?php include("partials/menufinal.php"); ?> 
	        
          <div class="row">
	          <div class="col-md-12">
	            <div class="col-md-2 col-md-offset-1">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-tint bg-green"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-moisture1"></p>
	                      <p class="text">Humidité <strong>Dwarf</strong></p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-2">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-tint bg-blue"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-moisture2"></p>
	                      <p class="text">Humidité <strong>White</strong></p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-2">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-lightbulb-o bg-yellow" id="lumiere"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-light"></p>
	                      <p class="text">Lumière</p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-2">
	              <div class="panel">
	                <div class="panel-content widget-info">
	                  <div class="row">
	                    <div class="left">
	                      <i class="fa fa-thermometer-full bg-blue" id="temperature"></i>
	                    </div>
	                    <div class="right">
	                      <p class="number" id="live-temp"></p>
	                      <p class="text">Temperature</p>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	             <div class="col-md-2">
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
	            <div class="col-md-6 col-md-offset-3" align="center">
					<img src="assets/global/images/loading.png" class="img-responsive" id="canvas-video" /> <!-- VIDEOS STREAM -->
	            </div>
	            	            </div>
		           <div class="row m-t-12">
			           <div align="center"><h2>Dernière informations</h2></div>
			            <div id="liste-infos"> </div>
			            
			          
			       </div>
	            </div>  
	          </div><!-- FIN ROW 1 -->
                  
          
          <div class="row m-t-10">
            <div id="liste-infos"> </div>
            
          </div>
          
          <div class="row">
		 	<div class="col-md-12" id="pompe">
				<div class="btn btn-primary" id="pompe-on">Pompe ON</div>
				<div class="btn btn-primary" id="pompe-off">Pompe OFF</div>
				<div class="btn btn-primary" id="pompe-arrosage">Pompe ARROSAGE</div>
			</div>	
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
	      
          <div class="row">
            <div class="col-md-12">
              <h3 class="m-t-30 m-b-10"><strong>Quick Menu</strong></h3>
              <p >This can be use for quick access of menu in a page.</p>
              <div class="panel">
                <div class="panel-content clearfix">
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-bulb bg-green"></i>
                      </div>
                      <p class="text">Projects</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-cloud-upload bg-aero"></i>
                      </div>
                      <p class="text">Tasks</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-camera bg-blue"></i>
                      </div>
                      <p class="text">Timeline</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="fa fa-envelope-o bg-purple"></i>
                      </div>
                      <p class="text">Stats</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-music-tone-alt bg-pink"></i>
                      </div>
                      <p class="text">Calendar</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-users bg-orange"></i>
                      </div>
                      <p class="text">Groups</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-calendar bg-blue"></i>
                      </div>
                      <p class="text">Timeline</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="fa fa-envelope-o bg-purple"></i>
                      </div>
                      <p class="text">Stats</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-bar-chart bg-dark"></i>
                      </div>
                      <p class="text">Calendar</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-users bg-yellow"></i>
                      </div>
                      <p class="text">Users</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="fa fa-envelope-o bg-purple"></i>
                      </div>
                      <p class="text">Messages</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-cup bg-red"></i>
                      </div>
                      <p class="text">Alerts</p>
                    </div>
                  </div>
                  <div class="quick-link">
                    <div class="row">
                      <div class="icon">
                        <i class="icon-basket bg-blue-dark"></i>
                      </div>
                      <p class="text">Emails</p>
                    </div>
                  </div>
                </div>
              </div>
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
		var temperature = new Array();
		var intermediaire,i=0;
		
		//On calcul les dates pour avoir les datas entre J-5 et J
		//DAte du jour+1
		var dateNow = new Date($.now());
		dateNow.setDate(dateNow.getDate()+1);
		dateNowFormat = [dateNow.getFullYear() ,dateNow.getMonth()+1, dateNow.getDate()].join('-');
		//console.log('Format Now: '+dateNowFormat);
		//Date d'il y a 5jours
		var data = new Date($.now()); // without jquery remove this $.now()
		data.setDate(data.getDate()-5);
		dformat = [data.getFullYear() ,data.getMonth()+1, data.getDate()].join('-');

		console.log('http://robotperso.eu/api/api.php/sensors?transform=1&order=date,desc&filter[]=date,ge,'+dformat+'&filter[]=date,le,'+dateNowFormat);
		//Call AJAX POUR obtenir les datas
		$.ajax( {
			type:'Get',
			url:'http://robotperso.eu/api/api.php/sensors?transform=1&order=date,asc&filter[]=date,ge,'+dformat+'&filter[]=date,le,'+dateNowFormat,
			success:function(data) {
				lesdatas = data.sensors;
				i=0;
				while(i<lesdatas.length) {
					//intermediaire = jQuery.parseJSON(lesdatas[i][2]);
					datafinale[i] = new Array(lesdatas[i]['date'],lesdatas[i]['humidite1']);
					moisture2[i]= new Array(lesdatas[i]['date'],lesdatas[i]['humidite2']);
					temperature[i]= new Array(lesdatas[i]['date'],lesdatas[i]['temperature']);
					//console.log(datafinale[i]);
					i++;
		 		}
		 		//Apres 0,5 on creer les datas
			 	setTimeout(function (socket) {
			 		Highcharts.setOptions({
				        global: {
				            useUTC: false
				        }
				    });
				    // Create the chart
				    chart1 = Highcharts.stockChart('chart-moisture', {
				        rangeSelector: {
				            buttons: [{
				                count: 1,
				                type: 'hour',
				                text: '1H'
				            },{
				                count: 12,
				                type: 'hour',
				                text: '12H'
				            }, {
				                count: 24,
				                type: 'hour',
				                text: '24H'
				            },
				            {
				                count: 2,
				                type: 'day',
				                text: '2D'
				            },{
				                count: 5,
				                type: 'day',
				                text: '5D'
				            }, {
				                type: 'all',
				                text: 'All'
				            }],
				            inputEnabled: false,
				            selected: 0
				        },
				
				        title: {
				            text: 'Humidité en temps réel'
				        },
				        exporting: {
				            enabled: false
				        },
				        series: [{
				            name: 'Dwarf ',
				            data: (function () {
				                var data = [],
				                    time = (new Date()).getTime(),
				                    i;
				                for (i = 0; i < datafinale.length; i = i + 1) {
				                    data.push([
				                        time = (new Date(datafinale[i][0])).getTime(),
				                        datafinale[i][1]
				                        
				                    ]);
				                   
				                }
				                return data;
				            }())
				        },{
					    	name: 'White',
				            data: (function () {
				                var data = [],
				                    time = (new Date()).getTime(),
				                    i;
				                for (i = 0; i < datafinale.length; i = i + 1) {
				                    data.push([
				                        time = (new Date(moisture2[i][0])).getTime(),
				                        moisture2[i][1]
				                        
				                    ]);
				                }
				                return data;
				            }())
					    }]
				    });
				    
				    
				    
				    chart1 = Highcharts.stockChart('chart-temperature', {
				        rangeSelector: {
				            buttons: [{
				                count: 1,
				                type: 'hour',
				                text: '1H'
				            },{
				                count: 12,
				                type: 'hour',
				                text: '12H'
				            }, {
				                count: 24,
				                type: 'hour',
				                text: '24H'
				            },
				            {
				                count: 2,
				                type: 'day',
				                text: '2D'
				            },{
				                count: 5,
				                type: 'day',
				                text: '5D'
				            }, {
				                type: 'all',
				                text: 'All'
				            }],
				            inputEnabled: false,
				            selected: 0
				        },
				
				        title: {
				            text: 'Temperature en temps réel'
				        },
				        exporting: {
				            enabled: false
				        },
				        series: [{
				            name: 'General ',
				            data: (function () {
				                var data = [],
				                    time = (new Date()).getTime(),
				                    i;
				                for (i = 0; i < temperature.length; i = i + 1) {
				                    data.push([
				                        time = (new Date(temperature[i][0])).getTime(),
				                        temperature[i][1]
				                        
				                    ]);
				                   
				                }
				                return data;
				            }())
				        }]
				    });
				},500);	
			}
		});	
		
		
	</script>
    
  </body>
</html>