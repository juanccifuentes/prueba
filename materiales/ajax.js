// Función para recoger los datos de PHP según el navegador, se usa siempre.
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
 
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}
 
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	  xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
 
//Función para recoger los datos del formulario y enviarlos por post  
function enviarDatosEmpleado(){
 
  //div donde se mostrará lo resultados
  divResultado = document.getElementById('resultado');
  //recogemos los valores de los inputs
  centro_trabajo=document.nuevo_empleado2.centro_trabajo.value;
  Precio_hora=document.nuevo_empleado2.Precio_hora.value;
  Uso_maquina=document.nuevo_empleado2.Uso_maquina.value;
  hora=document.nuevo_empleado2.hora.value;
  id_cotizacion=document.nuevo_empleado2.id_cotizacion.value;
 
  //instanciamos el objetoAjax
  ajax=objetoAjax();
 
  //uso del medotod POST
  //archivo que realizará la operacion
  //registro.php
  ajax.open("POST","registro.php",true);
  //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
  ajax.onreadystatechange=function() {
	  //la función responseText tiene todos los datos pedidos al servidor
  	if (ajax.readyState==4) {
  		//mostrar resultados en esta capa
		divResultado.innerHTML = ajax.responseText
  		//llamar a funcion para limpiar los inputs
		LimpiarCampos();
	}
 }
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores a registro.php para que inserte los datos
	ajax.send("centro_trabajo="+centro_trabajo+
			  "&hora="+hora+
			  "&Uso_maquina="+Uso_maquina+
			  "&Precio_hora="+Precio_hora+
			  "&id_cotizacion="+id_cotizacion)
}
 
//función para limpiar los campos
function LimpiarCampos(){
  document.nuevo_empleado2.Precio_hora.value="";
  document.nuevo_empleado2.Uso_maquina.value="";
  
  document.nuevo_empleado2.Precio_hora.focus();
}