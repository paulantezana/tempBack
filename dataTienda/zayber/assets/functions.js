function current_date(){var today = new Date(),dd = today.getDate(),mm = today.getMonth()+1,yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd}if(mm<10){mm='0'+mm}     
	return dd+'/'+mm+'/'+yyyy; 
}
function NroEntero1D(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 47 && key < 58){if (field.value == "")
		return true;
	regexp = /[0-9]{1}$/ 
	return !(regexp.test(field.value))}
	return false;
}
function NroEntero2D(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 47 && key < 58){
		if (field.value == "")return true;
		regexp = /[0-9]{2}$/ 
		return !(regexp.test(field.value))
	}
	return false;
}
function NroEntero2D_0(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 48 && key < 58){
		if (field.value == "")return true;
		regexp = /[0-9]{2}$/ 
		return !(regexp.test(field.value))
	}
	return false;
}
function NroEntero3D(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 47 && key < 58){
		if (field.value == "")return true;
		regexp = /[0-9]{3}$/ 
		return !(regexp.test(field.value))}
	return false;
}
function NroEntero4D(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 47 && key < 58){
		if (field.value == "")return true;
		regexp = /[0-9]{4}$/ 
		return !(regexp.test(field.value))}
	return false;
}
function NroEntero11D(e,field){key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true;
	if (key > 47 && key < 58){
		if (field.value == "")return true;
		regexp = /[0-9]{11}$/ 
		return !(regexp.test(field.value))}
	return false;
}
function fecha_Barra_Guion(pFecha){
	return pFecha.split('/')[2]+'-'+pFecha.split('/')[1]+'-'+pFecha.split('/')[0];
}
function Valido_Numero_Decimal(e, field){
	key = e.keyCode ? e.keyCode : e.which
  	if (key == 8) return true // backspace
	if (key > 47 && key < 58) {// 0-9
		if (field.value == "") return true
		regexp = /.[0-9]{4}$/
		return !(regexp.test(field.value))
	}
	if(key == 46){  // .v
		if (field.value == "") return false
		regexp = /^[0-9]+$/
		return regexp.test(field.value)
	}
	return false // other key
}
function edad(Fecha){
	var fecha = new Date(Fecha),hoy = new Date();
	var ed = parseInt((hoy -fecha)/365/24/60/60/1000);
	return ed;
}
function ClearMainScreen(valor){
	if(parseInt(valor)===0){
		$("#IdContentFirst").html("");$("#IdContentSecond").html("");$("#IdContentThird").html("");
		$("#IdContentFirst").css("display","block");$("#IdContentSecond").css("display","none");$("#IdContentThird").css("display","none");
	}
	if(parseInt(valor)===1){
		$("#IdContentFirst").css("display","block");$("#IdContentSecond").css("display","none");$("#IdContentThird").css("display","none");
		$("#IdContentSecond").html("");$("#IdContentThird").html("");
	}
	if(parseInt(valor)===2){
		$("#IdContentSecond").html("");$("#IdContentThird").html("");
		$("#IdContentFirst").css("display","none");$("#IdContentSecond").css("display","block");$("#IdContentThird").css("display","none");
	}
	if(parseInt(valor)===3){
		$("#IdContentThird").html("");
		$("#IdContentFirst").css("display","none");$("#IdContentSecond").css("display","none");$("#IdContentThird").css("display","block");
	}
}
function SumarHora_Minutos(Horaa,Minutos){//Horaa="02:34" y Minuto="45"
	var Hrss=Horaa.split(':');
	var mintTotal=parseInt(Hrss[1])+parseInt(Minutos);
	var aDiv=parseInt(mintTotal/60)+parseInt(Hrss[0]);
	var aResto=mintTotal % 60;
	var Hras='';
	var minut='';
	if(aDiv<10){Hras="0"+aDiv;}else{Hras=aDiv;}
	if(aResto<10){minut="0"+aResto;}else{minut=aResto;}
	return (Hras+":"+minut);
}
function Fecha_Hora(){
	var tiempo = new Date();
	var hora = tiempo.getHours();
	var minuto = tiempo.getMinutes();
	var segundo = tiempo.getSeconds();
	var Ano=tiempo.getFullYear();
	var mes=tiempo.getMonth()+1;
	var dia=tiempo.getDate();
	if(mes<10){mes='0'+mes;}
	if(dia<10){dia='0'+dia;}
	if(hora<10){hora='0'+hora;}
	if(minuto<10){minuto='0'+minuto;}
	if(segundo<10){segundo='0'+segundo;}
	return (Ano+'-'+mes+'-'+dia+' '+hora+':'+minuto+':'+segundo);
}
function Ultimo_Dia_Mes(Fecha) {
	var date = new Date(Fecha.split('/')[2],parseInt(Fecha.split('/')[1])-1,Fecha.split('/')[0]);
   var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);   
   return ultimoDia.getDate();
}
function Array_Semana(Sem){var indice=0;
	if(Sem==='Sun'){indice=0;}
	if(Sem==='Mon'){indice=1;}
	if(Sem==='Tue'){indice=2;}
	if(Sem==='Wed'){indice=3;}
	if(Sem==='Thu'){indice=4;}
	if(Sem==='Fri'){indice=5;}
	if(Sem==='Sat'){indice=6;} 
   return indice;
}
 function sumaMes_Fecha(m,pfecha){
	 var fecha= new Date(pfecha.split('/')[2],parseInt(pfecha.split('/')[1])-1,pfecha.split('/')[0]);
	// console.log(fecha);
	 fecha.setMonth(fecha.getMonth()+parseInt(m));
	 var anno=fecha.getFullYear();
	 var mes= fecha.getMonth()+1;
	 var dia= fecha.getDate();
	 mes = (parseInt(mes) < 10) ? ("0" + mes) : mes;
	 dia = (parseInt(dia) < 10) ? ("0" + dia) : dia;
	 var fechaFinal = dia+'/'+mes+'/'+anno;
	 return fechaFinal;
 }
function Nombre_Mes(pMes) {
	var Nombre=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"];   
   return Nombre[pMes];
} 
function sumar_Dia_Fecha(d, fecha){
	//console.log("1="+fecha);
	 var Fecha = new Date();
	 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
	 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
	 var aFecha = sFecha.split(sep);
	 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
	 fecha= new Date(fecha);
	 fecha.setDate(fecha.getDate()+parseInt(d));
	 var anno=fecha.getFullYear();
	 var mes= fecha.getMonth()+1;
	 var dia= fecha.getDate();
	 mes = (mes < 10) ? ("0" + mes) : mes;
	 //dia = (dia < 10) ? ("0" + dia) : dia;
	 var fechaFinal = dia+sep+mes+sep+anno;
	 //console.log("2="+fechaFinal);
	 return (fechaFinal);
}
 
function CLetras(Numero,mayusc,IdMoneda){
	//console.log(Numero);
	var literal = "";
    var parte_decimal="";
	
	var Num = Numero.split('.');
	
	if(Num.length>1){
		parte_decimal = " con " + Num[1] + "/100";
	}else{
		parte_decimal = " con 00/100";
	}
    
	if(parseInt(Num[0])===0){
		literal = "cero ";
	}
	else if(parseInt(Num[0])> 999999){
		literal = getMillones(Num[0]);
	}
	else if(parseInt(Num[0])> 999){
		literal = getMiles(Num[0]);
	}
	else if(parseInt(Num[0])> 99){
		literal = getCentenas(Num[0]);
	}
	else if(parseInt(Num[0])> 9){
		literal = getDecenas(Num[0]);
	}
	else{
		literal = getUnidades(Num[0]);
	}
    var Mond="";
	
	if(mayusc){
		if(parseInt(IdMoneda)===1){
			Mond=" SOLES";
		}else{
			Mond=" DOLARES";
		}
		//console.log(literal);
		return (literal.toUpperCase()+parte_decimal)+Mond;
	}else{
		if(parseInt(IdMoneda)===1){
			Mond=" Soles";
		}else{
			Mond=" Dolares";
		}
		return (literal.toLowerCase()+parte_decimal)+Mond;
	} 
	
}
function getUnidades(numero){
	// 1 - 9            
    //si tuviera algun 0 antes se lo quita -> 09 = 9 o 009=9
	var UNIDADES = new Array("","un ", "dos ", "tres ", "cuatro ", "cinco ", "seis ", "siete ", "ocho ", "nueve ");
	//var num = numero.substring(numero.Length - 1);
	return UNIDADES[parseInt(numero)];

}
function getDecenas(numero){
	var DECENAS = new Array("diez ", "once ", "doce ", "trece ", "catorce ", "quince ", "dieciseis ",
        "diecisiete ", "dieciocho ", "diecinueve", "veinte ", "treinta ", "cuarenta ",
        "cincuenta ", "sesenta ", "setenta ", "ochenta ", "noventa ");
	// 99
	var n = parseInt(numero);
	if(n<10){
		return getUnidades(numero);
	}
    else if(n>19){
		var valUnid=parseInt(parseInt(numero) % 10);
		var ud=getUnidades(valUnid);
		if(ud===""){
			var decc=parseInt(parseInt(numero) / 10);
			return DECENAS[parseInt(decc) + 8];
		}else{
			var decc=parseInt(parseInt(numero) / 10);
			return DECENAS[parseInt(decc) + 8] + "y " + ud;
		}
	}else{
		return DECENAS[n - 10];
	}
}
function getCentenas(numero){  
	var CENTENAS =new Array ("","ciento ", "doscientos ", "trecientos ", "cuatrocientos ", "quinientos ", "seiscientos ",
        "setecientos ", "ochocientos ", "novecientos ");
	// 999 o 099
	if(parseInt(numero)>99){
		if(parseInt(numero)===100){
			return " cien ";
		}else{
			var cc=parseInt(parseInt(numero) / 100);
			var dd=parseInt(parseInt(numero) % 100);
			return CENTENAS[cc] + getDecenas(dd);
		}
	}
	else{
		return getDecenas(parseInt(numero));
	}
}
function getMiles(numero){   
	// 999 999
    //obtiene las centenas
	var cent=parseInt(parseInt(numero) % 1000);
    //obtiene los miles
    var m = parseInt(parseInt(numero) / 1000);
    var n = "";
    //se comprueba que miles tenga valor entero
    if(parseInt(m) > 0)
    {
        n = getCentenas(m);
        return n + "mil " + getCentenas(cent);
    }
    else
    {
        return "" + getCentenas(cent);
    }
}
function getMillones(numero){   
	//000 000 000        
    //se obtiene los miles
	
    var miles = parseInt(parseInt(numero) % 1000000);
    //se obtiene los millones
	
    var millon = parseInt(parseInt(numero) / 1000000);
    var n = "";
    if (millon.Length > 1)
    {
        n = getCentenas(millon) + "millones ";
    }
    else
    {
        n = getUnidades(millon) + "millon ";
    }
    return n + getMiles(miles);
}
function CantDias_Entre2Fechas(Fecha1,Fecha2){
	var Fecha2=Fecha2.split('/');
	var Fecha1=Fecha1.split('/');
	var f1= new Date(Fecha1[2],parseInt(Fecha1[1])-1,Fecha1[0]);
	var f2= new Date(Fecha2[2],parseInt(Fecha2[1])-1,Fecha2[0]);
	var difM = f2 - f1 // diferencia en milisegundos
	var difD = difM / (1000 * 60 * 60 * 24) // diferencia en dias
	if(difD<0){difD=parseInt(difD)*(-1);}
	 return difD;
}
function Completar_Cero(cantC,Numero){
	var valor='';
	var lo=Numero.length;
	
	for(var i=0;i<(parseInt(cantC)-lo);i++){
		valor=valor+'0';
	}
	valor=valor+Numero;
	return valor;
}



