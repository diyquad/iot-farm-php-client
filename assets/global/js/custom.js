//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//

/* global io */
/* global $ */

function formattedDate(date) {
    var d = new Date(date || Date.now()),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day,month, year].join('/');
}


$(document).ready(function() 
{
	console.log('ready');		
	
	//var socket = io();
	var j=0;
	
	//notify server of connection
	socket.emit('connected'); 
	socket.on("node-connected", function() {
		$("#rpi-status").html("<strong>Connected!!</strong>");

	}); 
	socket.on('disconnect', function () {
        console.log("disconnected");  
    });
    
	socket.emit('get-all-sensors');
	
	//On affiche la video
	$("#canvas-video").attr('src' , "http://89.2.170.137:8080/?action=stream");
	//On recupere l'etat du RPI et des sensors
	
	socket.on("all-sensors", function(data) {
		datajson = data.data;
		console.log(datajson);
		$("#live-moisture1").html(datajson['moisture']);
		$("#live-moisture2").html(datajson['moisture2']);
		$("#live-light").html(datajson['lumiere']);
		$("#live-temp").html(datajson['temp']);
		if(datajson['lumiere']>800 || datajson['lumiere']<5) {
			$("#lumiere").removeClass('bg-yellow');
			$("#lumiere").addClass('bg-dark');
			$("#lumiere").removeClass('fa fa-sun-o');
			$("#lumiere").addClass('fa fa-moon-o ');
		} else {
			$("#lumiere").removeClass('bg-dark');
			$("#lumiere").addClass('bg-yellow');
			$("#lumiere").removeClass('fa fa-moon-o');
			$("#lumiere").addClass('fa fa-sun-o');
			
			
		}

	});
	
	var lesdatas = [];
	socket.emit('get-humidity-sensor');
	
		
	/*
		Lancement du graphique 1seconde apres le chargement de la page, pour recuperer les datas avant
	*/
	
	//Call AJAX POUR obtenir les datas
			
	
	
	//On lance le refresh graphe et des autres datas
    setInterval(function() {
	    //Refresh des sensors
	    socket.emit('get-all-sensors');
	    
	    var dateNow = new Date($.now());
	    dateNow.setDate(dateNow.getDate()+1);
		dateNowFormat = [dateNow.getFullYear() ,dateNow.getMonth()+1, dateNow.getDate()].join('-');
		$.ajax( {
			type:'Get',
			url:'http://robotperso.eu/api/api.php/sensors?filter[]=date,le,'+dateNowFormat+'&transform=1&order=id,desc&page=1,1',
			success:function(data) {
				console.log('http://robotperso.eu/api/api.php/sensors?filter[]=date,le,'+dateNowFormat+'&transform=1&order=id,desc&page=1,1');
				var x = (new Date(data.sensors[0]['date'])).getTime();
				var y = data.sensors[0]['humidite1'];
				var z = data.sensors[0]['humidite2'];
				chart1.series[0].addPoint([x, y], true, true);
				chart1.series[1].addPoint([x, z], true, true);
				console.log('Ajout des points - x:'+x +'- y:'+ y);
				console.log('Ajout des points2 - x:'+x +'- z:'+ z);
			}
		});
	},300000);
	
	
	/*
		Gestion du formulaire
	*/
	$("#form-infos").hide();
	$("#confirmation-infos").hide();
	$("#ajout-infos").click(function () {
		$("#form-infos").toggle();
	});
	
	$("#valider-infos").click(function () {
		var data = {};
		var dateNow = new Date($.now());
		//data['date'] = [dateNow.getFullYear() ,dateNow.getMonth()+1, dateNow.getDate()].join('-');
		data['date'] = new Date().toISOString().slice(0, 19).replace('T', ' ');
		data['titre'] = $("#titre-infos").val();
		data['texte'] = $("#text-infos").val();
		$.ajax( {
			type:'POST',
			url:'http://robotperso.eu/api/api.php/infos',
			data: data,
			success:function(data) {
				console.log(data);			 	
			}
		});	
		//socket.emit('save-infos', data);
		$("#valider-infos").hide();
		$("#form-infos").hide();
		getInfos();

	});
	socket.on("save-infos-ok", function(data) {
		console.log('Confirmation infos sauvegarder en BD ');
		$("#confirmation-infos").show();
	});
	getInfos();
	
	
	
	/*
		
		Gestion du reboot 
		
	*/
	$("#reboot").click(function () {
		socket.emit('reboot');
		$("#live-moisture1").html('-');
		$("#live-moisture2").html('-');
		$("#live-light").html('-');
		$("#live-temp").html('-');
		$("#rpi-status").html("<strong>Reboot in progress...</strong>");				
			

		setInterval(function() {
			location.reload();
		},150000);
	});
	

		
});
function getInfos() {
	$.ajax( {
		type:'Get',
		url:'http://robotperso.eu/api/api.php/infos?transform=1&order=date,desc&page=1',
		success:function(data) {
			var i=0;
			$('#liste-infos').html('');
			while(i<data['infos'].length) {
				$('#liste-infos').append(formattedDate(data['infos'][i]['date']) + ' : ');
				$('#liste-infos').append('<strong>'+data['infos'][i]['titre']+'</strong><br/>');
				$('#liste-infos').append(data['infos'][i]['texte']+'<br/>');
				$('#liste-infos').append('<br>');
				i++;
			}
		}
	});	
}