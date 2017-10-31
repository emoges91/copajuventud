/*crear llaves 2.0*/
var cant_fases=0;// cantidad de fases
var activar=0;
var array_txt_fases=new Array();
 
function principal(){
	rellenar();// rellenar la lista de equipos disponibles
	borrar_fases();//borrar los txt de cantidad de partidos
	borrar_partidos_fases();// borrar las fases de llaves
	crear_fases();
	crear_drag();
}

function crear_fases(){
	var td_fases = document.getElementById('tdfasesCant');
	var numFases =document.getElementById("txt_cant_fase").value;
	cant_fases=numFases;
	for(var i=1;i<=numFases;i++){
		var textNode = document.createTextNode("  Fase "+i+": ");
		var txtNuevo =document.createElement("input");
		txtNuevo.type="text";
		txtNuevo.id="idtxtfases"+i;
		txtNuevo.name="txtfase"+i;
		txtNuevo.size="1";
		txtNuevo.maxLength="2";
		txtNuevo.width="10px";
		td_fases.appendChild(textNode);
		td_fases.appendChild(txtNuevo);
	}
	var BCrearFases = document.createElement("input");
		BCrearFases.type="button";
		BCrearFases.id="idBCrearFase"+i;
		BCrearFases.value="Crear Partidos";
		BCrearFases.size="20px";
		
		if (BCrearFases.addEventListener){
			//Si usa estandares (Mozilla)
			BCrearFases.addEventListener('click',function(event){crear_lista();}, false);
		}
		else if (txtBoton.attachEvent){
		//IE SUCKS….
			BCrearFases.attachEvent('onclick', function(event){ crear_lista();});
		}
		
		td_fases.appendChild(BCrearFases);
}

function obtenerValorTxt(numero){
	var txtNumero =document.getElementById("idtxtfases"+numero).value;
	return txtNumero;
}


function crear_lista(){
	rellenar();// rellenar la lista de equipos disponibles
	var tr_fases = document.getElementById('idtr');
	array_txt_fases.length=0;
	borrar_partidos_fases();// borrar las fases de llaves
	
	for(var a=1;a<=cant_fases;a++){
		var td_fases = document.createElement("td");//calumna para las fases
		td_fases.id="TDFases"+a;
		
		var table2 = document.createElement("table");//tabla para cada fase
		table2.id="idtablePatidos"+a;
		table2.align="center";
		table2.cellPadding="0";
		table2.cellSpacing="0";
		
		var cant_partidos=obtenerValorTxt(a);//obtener la cantidad de partidos de una fase
		array_txt_fases[a]=cant_partidos;
		
		for(var i=1;i<=cant_partidos;i++){
			/* tr de emcabezado de tabla de llave*/						
			var trtit = document.createElement("tr");	
			trtit.id = "idtrtit"+i+a;
			trtit.bgColor="a6d6fa";	
				var td_info_titulo = document.createElement("td");	//td para nodo texto empieza
				var tdtitulo = document.createElement("td");//td para nodo textp partido n
				tdtitulo.id = "idtdtit"+i+a;
					var texto = document.createTextNode("Partido "+i); // nodo texto para el nuemo de partido
				tdtitulo.appendChild(texto);// agregar nuemracion en partidos
		
			/* tr de datos  */	
			var trcont = document.createElement("tr");	
				trcont.id = "idtrcont_"+i+a;
				trcont.bgColor="dfeffb";		
				var td_info = document.createElement("td");//bla
					td_info.vAlign="top";

					/*agregar info de casa y visita*/
					var div_info1 = document.createElement("div");//div para equipo casa
						var texto_info1 = document.createTextNode("Casa");
						div_info1.appendChild(texto_info1);//agregar texto casa
					var div_info2 = document.createElement("div");//div para equipo visita
						var texto_info2 = document.createTextNode("Visita");
						div_info2.appendChild(texto_info2);	//agregar texto visita	
								
				var tdcontenedor = document.createElement("td"); // td para drag los equipos
					tdcontenedor.id = "idtdcont"+i+a;
					tdcontenedor.vAlign="top";
					
					/*div contenedor*/
					var elemento = document.createElement("div");
						elemento.id = "idpartido_"+i+"_"+a;
						elemento.style.width ="200px";
						if(a==1){
							elemento.style.background ="#ccc";
						}
						else{
							elemento.style.background ="#eee";
						}
						var atributo = document.createAttribute("class");
							atributo.nodeValue ="partido_"+i+"_"+a+"  contenedor";
							elemento.attributes.setNamedItem(atributo);// agregar clase a div elemento
					var n_input = document.createElement("input");
						n_input.name='h_partido_'+i+"_"+a;
						n_input.id="h_idpartido_"+i+"_"+a;
						n_input.type="hidden";
						n_input.value="";	
						
					/*titulo*/		
					trtit.appendChild(td_info_titulo); 
					trtit.appendChild(tdtitulo); 
					trcont.appendChild(td_info);
														
					/*datos*/	
					td_info.appendChild(div_info1);//agregar div casa a un td
					td_info.appendChild(div_info2);//agregar div visita a un td
					tdcontenedor.appendChild(elemento);//agregar div con nombre del equipo
					tdcontenedor.appendChild(n_input);// agregar el hidden para pasar partidos	
					trcont.appendChild(tdcontenedor);
				table2.appendChild(trtit);//agregando el encabezado
				table2.appendChild(trcont);// el contenido
			td_fases.appendChild(table2);
			tr_fases.appendChild(td_fases);	
		}		
	}			
	activar=1;
	crear_drag();
}

function borrar_fases(){
	var cell = document.getElementById("tdfasesCant");

	if ( cell.hasChildNodes()){
    	while ( cell.childNodes.length >= 1 ){
        	cell.removeChild( cell.firstChild );       
    	} 
	}
}

function borrar_partidos_fases(){
	if(cant_fases>0&&activar==1){
		for(var i=1;i<=cant_fases;i++){
			var elemento= document.getElementById("TDFases"+i);
			elemento.parentNode.removeChild(elemento);
		}		
	}
	activar=0;
}

function validarguardar() {
	if((cant_fases>0)&&(array_txt_fases.length>0)){
		obtenerElementos();
		return true;
	}
	else{
		return false;
	}
}

function obtenerElementos() {
	var texto='';
	for(var i=1;i<=array_txt_fases[1];i++){
		var llaves = document.getElementById("idpartido_"+i+"_1");
		var hidden=document.getElementById("h_idpartido_"+i+"_1");
		var capas=llaves.getElementsByTagName('div');
		for (e=0;e<capas.length;e++){
			if(e==0){
				texto=capas.item(e).childNodes.item(0).nodeValue.slice(1,capas.item(e).childNodes.item(0).nodeValue.length);
				hidden.value=texto+',';
			}
			else{
				texto=capas.item(e).childNodes.item(0).nodeValue.slice(1,capas.item(e).childNodes.item(0).nodeValue.length);
				hidden.value=hidden.value+texto+",";
			}
		}
		hidden.value=hidden.value.slice(0,hidden.value.length-1);	
	}
	document.formulario.txt_cant_fase.value=cant_fases;
}
