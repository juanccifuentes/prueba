function detectarAjax()
{
    var request = false;
    try
    {
        request = new XMLHttpRequest();/*PARA E FIREFOX*/
    }
    catch (err1)
    {
        try
        {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (err2)
        {
            try
            {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (err3)
            {
                request = false;
            }
        }
    }
    return request;
}
var resultado = detectarAjax();
//-----------------------------------------

function insertar()
{
   var url = "procesar.php";
    var select = document.getElementById('select').value;
	var id = document.getElementById('id').value;
    var valores = "select="+select+"&id="+id;
	var mensaje= "Clasificacion realizada Con exito";
    //alert(vinculo);
    resultado.open("POST", url, true);
    resultado.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    resultado.onreadystatechange = resultado.onreadystatechange = function()//onreadystatechange no lleva camel case
    {
        if (resultado.readyState == 4)
        {  // alert(resultado.readyState);
            if (resultado.status == 200)
            {
             var http = resultado.responseText;
                if (http)
                {
                    document.getElementById('resultado').innerHTML=http;
                }
            }
        }
       };
	alert(mensaje);
    resultado.send(valores);
    var select = document.getElementById('select').focus();
}









