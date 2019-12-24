function ClassImpresion(){
	this.getList_Datos_ReportVentta_Print=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_ReportVentta_Print",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImpresion();
				inst.Create_Print_Comprobante(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.getList_Datos_ReporteNP_Print=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_ReportVentta_Print",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImpresion();
				inst.Create_Print_Comprobante(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Print_Comprobante=function(Datos){var inst=new ClassImpresion();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Print_FBG);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var Cab=Datos["Venta"];
		var Detalle=Datos["Detalle"];
		var Alm=Datos["Alm"];
		var IdComp=Cab[0]["IdComprobante"];
		var fee=(Cab[0]["Fec"]).split('/');
		var pDia=fee[0];
		var pMes=Nombre_Mes(parseInt(fee[1])-1);
		var pAnio=fee[2];
		var doc = new jsPDF();
		if(parseInt(IdComp)===1){//FACTURA
			doc.setFontSize(10);doc.setFont("times");
												doc.text(125, 60, Cab[0]["Serie"]);doc.text(180, 60, Cab[0]["Numero"]);
			var alt=60;
			doc.text(25, alt+1, Cab[0]["RazonSocial"]);
			alt=alt+6;
			doc.text(25, alt+1, Cab[0]["Direccion"]);
			alt=alt+6;
			doc.setFontSize(14);
			doc.text(25, alt+1, Cab[0]["Ruc"]);doc.text(105, alt, Cab[0]["NroFactura"]);
			
					doc.text(155, alt+1, pDia);doc.text(170, alt+1, pMes);doc.text(185, alt+1, pAnio);
			alt=alt+18;
			//DETALLE
			
			for(var i=0;i<Detalle.length;i++){
				doc.setFontSize(12);
				doc.text(7, alt, Detalle[i]["Cantidad"]);
				doc.text(25, alt, Detalle[i]["Unidad"]);
				doc.text(40, alt, Detalle[i]["Producto"]);
				doc.setFontSize(14);
				doc.text(155, alt,Detalle[i]["PUnitario"]);
				doc.text(178, alt,Detalle[i]["Importe"]);
				alt=alt+5;
			}
			doc.setFontSize(14);
			var sonn=(Cab[0]["Son"]).toUpperCase();
			var altT=216;
			doc.text(175, altT, Cab[0]["SubTotal"]); 	doc.setFontSize(12);doc.text(15, 215, sonn);
			altT=altT+7;doc.setFontSize(14);
			doc.text(175, altT, Cab[0]["IGV"]); 
			altT=altT+7;
			doc.text(175, altT, "S/ "+Cab[0]["Total"]); 
			doc.setFontSize(12);
			//doc.text(65, 237, Cab[0]["TipoC"]);
			//doc.text(98, 237, Cab[0]["FecCa"]);
		}
		else if(parseInt(IdComp)===10){//Recibo
			doc.setFontSize(10);doc.setFont("times");
			var alt=10;
			doc.text(20, alt, "RECIBO N� "+Cab[0]["Serie"]+' - '+Cab[0]["Numero"]);
			alt=alt+7;									
			doc.text(10, alt, "Nro Doc : ");doc.text(40, alt, Cab[0]["Ruc"]);
			alt=alt+7;									
			doc.text(10, alt, "Nombres : ");doc.text(40, alt, Cab[0]["RazonSocial"]);
			alt=alt+7;									
			doc.text(10, alt, "Direccion : ");doc.text(40, alt, Cab[0]["Direccion"]);
			alt=alt+7;									
			doc.text(10, alt, "Fecha E : ");doc.text(40, alt, Cab[0]["Fec"]);

			alt=alt+15;
			//DETALLE
			doc.setFontSize(10);
			doc.text(7, alt, "Codigo ");doc.text(30, alt, "Unidad ");doc.text(50, alt, "Producto ");
			doc.text(130, alt, "Cant ");doc.text(150, alt, "P.U ");doc.text(170, alt, "Importe ");
			alt=alt+7;
			for(var i=0;i<Detalle.length;i++){
				doc.text(7, alt, Detalle[i]["Codigo"]);
				doc.text(30, alt,Detalle[i]["Unidad"]);
				doc.text(50, alt, Detalle[i]["Producto"]);
				doc.text(130, alt,Detalle[i]["Cantidad"]);
				doc.text(150, alt,Detalle[i]["PUnitario"]);
				doc.text(170, alt,Detalle[i]["Importe"]);
				alt=alt+5;
			}
			alt=alt+10;doc.setFontSize(14);
			doc.text(150, alt, "Total : ");doc.text(170, alt, Cab[0]["Total"]);
			doc.text(10, alt, "Tipo Venta : ");doc.text(30, alt, Cab[0]["TipoC"]);
			alt=alt+10;
			doc.text(10, alt, Cab[0]["Userr"]);
		}
		else if(parseInt(IdComp)===20){//Guia Remision
			doc.setFontSize(10);doc.setFont("times");
												doc.text(135, 50, Cab[0]["Serie"]);doc.text(180, 50, Cab[0]["Numero"]);
			var alt=60;										var altOD=58;						
			doc.text(20, alt, Cab[0]["RazonSocial"]);     doc.text(138, altOD, Cab[0]["Fec"]);
			alt=alt+5;										altOD=altOD+4;
			doc.text(20, alt, Cab[0]["Direccion"]);		  doc.text(138, altOD, Alm[0]["Direccion"]);
			alt=alt+5;										altOD=altOD+4;
			doc.text(20, alt, Cab[0]["Ruc"]);			  doc.text(138, altOD,"");// Cab[0]["Direccion"]
			alt=alt+5;
					doc.text(45, alt, Cab[0]["Fec"]);	  altOD=altOD+4;doc.text(135, altOD, Cab[0]["NroFactura"]);
			alt=alt+15;
			//DETALLE
			var altD=115;
			doc.setFontSize(10);
			var TotaPe=0;
			for(var i=0;i<Detalle.length;i++){
				doc.setFontSize(12);
				TotaPe=parseFloat(TotaPe)+parseFloat(Detalle[i]["Cantidad"]);
				doc.text(7, altD, Detalle[i]["Codigo"]);
				doc.text(30, altD, Detalle[i]["Producto"]);
				doc.text(135, altD, "0.00");
				doc.text(155, altD,Detalle[i]["Unidad"]);
				doc.text(175, altD,Detalle[i]["Cantidad"]);
				altD=altD+5;
			}
			doc.setFontSize(14);
			TotaPe=parseFloat(TotaPe).toFixed(2);
			doc.text(175, 229," "+TotaPe);
		}
		var string=doc.output('datauristring');
		$('#IdPrintBVF').attr('src', string);
	}
	
	/* PRINT TICKET */
	this.getList_Print_Ticket=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Datos_printTICKETS",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImpresion();console.log(e);
				inst.Create_Print_TICKETVENTA(e);
				//inst.Create_Print_TICKETS(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Print_TICKETS=function(Datos){var inst=new ClassImpresion();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Print_FBG);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var Cab=Datos["Venta"];
		var Detalle=Datos["Detalle"];
		var Empresa=Datos["Empresa"];
		
		var doc = new jsPDF();
		
		doc.setFontSize(12);doc.setFont("times");
		var alt=10;
		doc.text(10, alt, Empresa[0]["RazonSocial"]);
		alt=alt+8;doc.setFontSize(16);doc.text(10, alt, "Ruc : "+Empresa[0]["Ruc"]);
		alt=alt+8;doc.setFontSize(12);doc.text(10, alt, "Direccion : "+Empresa[0]["Direccion"]);
		
		alt=alt+10;doc.setFontSize(12);
		doc.text(20, alt, Cab[0]["Comprobante"]+" N: "+Cab[0]["Serie"]+' - '+Cab[0]["Numero"]);
		alt=alt+7;doc.text(10, alt, "Nro Doc : ");doc.text(40, alt, Cab[0]["Ruc"]);
		alt=alt+7;doc.text(10, alt, "Nombres : ");doc.text(40, alt, Cab[0]["RazonSocial"]);
		alt=alt+7;doc.text(10, alt, "Direccion : ");doc.text(40, alt, Cab[0]["Direccion"]);
		alt=alt+7;doc.text(10, alt, "Fecha E : ");doc.text(40, alt, Cab[0]["Fecha"]);
		
		alt=alt+15;
		//DETALLE
		doc.setFontSize(10);
		doc.text(7, alt, "Codigo ");doc.text(30, alt, "Unidad ");doc.text(50, alt, "Producto ");
		doc.text(150, alt, "Cant ");doc.text(165, alt, "P.U ");doc.text(180, alt, "Importe ");
		alt=alt+7;
		for(var i=0;i<Detalle.length;i++){
			doc.text(7, alt, Detalle[i]["Codigo"]);
			doc.text(30, alt,Detalle[i]["Unidad"]);
			doc.text(50, alt, Detalle[i]["Producto"]);
			doc.text(150, alt,Detalle[i]["Cantidad"]);
			doc.text(165, alt,Detalle[i]["PUnitario"]);
			doc.text(180, alt,Detalle[i]["Importe"]);
			alt=alt+5;
		}
		alt=alt+10;doc.setFontSize(14);
		doc.text(160, alt, "Total : ");doc.text(180, alt, Cab[0]["Total"]);
		doc.text(10, alt, "Tipo Venta : "+Cab[0]["TipoC"]);
		alt=alt+10;
		doc.text(10, alt,"User Reg. "+ Cab[0]["Userr"]);

		var string=doc.output('datauristring');
		$('#IdPrintBVF').attr('src', string);
	}
	this.Create_Print_TICKETVENTA=function(Datos){var inst=new ClassImpresion();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Print_FBG);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var Cab=Datos["Venta"];console.log(Datos);
		var Detalle=Datos["Detalle"];
		var Empresa=Datos["Empresa"];
		
		var doc = new jsPDF('p', 'mm', [81, 600]);
		
		doc.setFontSize(12);doc.setFont("times");
		var alt=10;
		doc.text(30, alt, Empresa[0]["RazonSocial"]);

		alt=alt+6;doc.setFontSize(11);doc.text(5, alt, "Ruc : "+Empresa[0]["Ruc"]);
		alt=alt+6;doc.text(5, alt, "Direccion : ");

		var pageCenter=25;
	    //var paragraph="Apple's iPhone 7 is officially upon us. After a week of pre-orders, the latest in the iPhone lineup officially launches today.\n\nEager Apple fans will be lining up out the door at Apple and carrier stores around the country to grab up the iPhone 7 and iPhone 7 Plus, while Android owners look ";
	    var paragraph= Empresa[0]["Direccion"];
	    var lines =doc.splitTextToSize(paragraph, (50));
	    var dim = doc.getTextDimensions('Text');
	    //console.log(dim);
	    //var lineHeight = dim.h
	    var lineHeight = 8
	    console.log(lines.length);
	    for(var i=0;i<lines.length;i++){
	      lineTop = (lineHeight/2)*i
	      doc.text(lines[i],pageCenter,alt+lineTop,''); //see this line
	    }
		//doc.text(5, alt, "Direccion : "+Empresa[0]["Direccion"]);

		alt=alt+(lines.length*4);
		doc.setFontSize(10);
		doc.text(30, alt, Cab[0]["Comprobante"]+" N: "+Cab[0]["Serie"]+' - '+Cab[0]["Numero"]);
		
		alt=alt+7;doc.text(5, alt, "Nro Doc : ");doc.text(23, alt, Cab[0]["Ruc"]);
		alt=alt+5;doc.text(5, alt, "Nombres : ");doc.text(23, alt, Cab[0]["RazonSocial"]);
		alt=alt+5;doc.text(5, alt, "Direccion : ");doc.text(23, alt, Cab[0]["Direccion"]);
		alt=alt+5;doc.text(5, alt, "Fecha: ");doc.text(23, alt, Cab[0]["Fecha"]);
		
		alt=alt+7;
		//DETALLE
		doc.setFontSize(9);
		//doc.text(7, alt, "Codigo ");
		doc.text(3, alt, "CANT. ");
		//doc.text(12, alt, "Uni ");
		doc.text(13, alt, "PRODUCTO ");
		doc.text(60, alt, "P.U ");doc.text(67, alt, "TOTAL ");
		alt=alt+7;
		for(var i=0;i<Detalle.length;i++){
			//doc.text(7, alt, Detalle[i]["Codigo"]);
			doc.text(3, alt,Detalle[i]["Cantidad"]);
			//doc.text(12, alt,Detalle[i]["Unidad"]);

			var pageCenter=12;
		    //var paragraph="Apple's iPhone 7 is officially upon us. After a week of pre-orders, the latest in the iPhone lineup officially launches today.\n\nEager Apple fans will be lining up out the door at Apple and carrier stores around the country to grab up the iPhone 7 and iPhone 7 Plus, while Android owners look ";
		    var paragraph= Detalle[i]["Producto"];
		    var lines =doc.splitTextToSize(paragraph, (50));
		    var dim = doc.getTextDimensions('Text');
		    var lineHeight = 7
		    for(let j=0;j<lines.length;j++){
		      lineTop = (lineHeight/2)*j
		      doc.text(lines[j],pageCenter,alt+lineTop,''); //see this line
		    }
			alt=alt+(lines.length*2);
			//doc.text(12, alt, Detalle[i]["Producto"]);
			doc.text(60, alt,Detalle[i]["PUnitario"]);
			doc.text(69, alt,Detalle[i]["Importe"]);
			alt=alt+5;
		}
		alt=alt+10;doc.setFontSize(11);
		doc.text(52, alt, "Total : ");doc.text(67, alt, Cab[0]["Total"]);
		doc.text(10, alt, "Tipo Venta : "+Cab[0]["TipoC"]);
		alt=alt+6;
		doc.setFontSize(9);
		doc.text(10, alt,"User Reg. "+ Cab[0]["Userr"]);

    

		var string=doc.output('datauristring');
		$('#IdPrintBVF').attr('src', string);
	}

	
	/* PRINT FACTURA Y BOLETA */
	this.getList_Print_FacturaBoleta=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Print_FacturaBoleta",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImpresion();
				if(e.length>0){
					//inst.Create_Print_FacturaBoleta(params[0],e[0]["enlace"]);
					window.open(e[0]["enlace"]);
				}else{
					alertify.error("Error, no se puede visualizar vista preliminar.");
				}
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Print_FacturaBoleta=function(IdVenta,Ruta){var inst=new ClassImpresion();
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_VisorFBV_Venta);
		$('#myModal').modal({keyboard:false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		$('#IdPrintFB').html('<object id="myPdf" width="100%" height="500px" type="application/pdf" data="' + Ruta +'"></object>');
	}
	
	/* PRINT GUIA REMISION */
	this.getList_Print_GuiaRemision=function(params){
		$.blockUI();
		$.ajax({type:"POST",url:url_ajax_request,data:{object:"objReport",action:"getList_Print_GuiaRemision",array:params},
			async:true,dataType:"json",success:function(e){$.unblockUI();var inst=new ClassImpresion();
				inst.Create_Print_GuiaRemision(e);
			},error:function(jqXHR,textStatus,errorMessage){console.log(jqXHR.responseText);}
		});
	}
	this.Create_Print_GuiaRemision=function(Datos){var inst=new ClassImpresion();console.log(Datos);
		$("#modal_Manten").html("");$("#modal_Manten").html(Form_Modal_Print_FBG);
		$('#myModal').modal({keyboard: false,backdrop:false});
		$('.modal-dialog').draggable({handle: ".modal-header"});
		
		var Cab=Datos["Venta"];console.log(Cab);
		var Detalle=Datos["Detalle"];
		var Empresa=Datos["Empresa"];
		
		var doc = new jsPDF();
		doc.setFontSize(14);doc.setFont("times");
		doc.text(20, 20,"GUIA REMISION");
		doc.setFontSize(10);
												doc.text(135, 50, Cab[0]["Serie"]);doc.text(180, 50, Cab[0]["Numero"]);
			var alt=60;										var altOD=58;						
			doc.text(20, alt, Cab[0]["RazonSocial"]);     doc.text(138, altOD, Cab[0]["Fecha"]);
			alt=alt+5;										altOD=altOD+4;
			doc.text(20, alt, Cab[0]["Direccion"]);		  doc.text(138, altOD, "Direccion");
			alt=alt+5;										altOD=altOD+4;
			doc.text(20, alt, Cab[0]["Ruc"]);			  doc.text(138, altOD,"");// Cab[0]["Direccion"]
			alt=alt+5;
					doc.text(45, alt, Cab[0]["Fecha"]);	  altOD=altOD+4;doc.text(135, altOD, Cab[0]["NroFactura"]);
			alt=alt+15;
			//DETALLE
			var altD=115;
			doc.setFontSize(10);
			var TotaPe=0;
			for(var i=0;i<Detalle.length;i++){
				doc.setFontSize(12);
				TotaPe=parseFloat(TotaPe)+parseFloat(Detalle[i]["Cantidad"]);
				doc.text(7, altD, Detalle[i]["Codigo"]);
				doc.text(30, altD, Detalle[i]["Producto"]);
				doc.text(135, altD, "0.00");
				doc.text(155, altD,Detalle[i]["Unidad"]);
				doc.text(175, altD,Detalle[i]["Cantidad"]);
				altD=altD+5;
			}
			console.log(TotaPe);
		altD=altD+10;doc.setFontSize(14);
		doc.text(160, altD, "Total : ");doc.text(180, altD,""+TotaPe);
		doc.text(10, altD, "Tipo Venta : "+Cab[0]["TipoC"]);
		altD=altD+10;
		doc.text(10, altD,"User Reg. "+ Cab[0]["Userr"]);

		var string=doc.output('datauristring');
		$('#IdPrintBVF').attr('src', string);
	}
	
}