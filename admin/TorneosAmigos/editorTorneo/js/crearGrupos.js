var cantidad_grupos=0;
var cantidad_tr=0;

function crear_lista(){
	rellenar();
	borrar_lista();
	var suma=4;
	cantidad_grupos=document.formulario.CAN_GRU.value;
	if((cantidad_grupos>0)){	
		
		var i,i2;
		i2=0;
		for(i=1;i<=cantidad_grupos;i++){
			var elemento1 = document.createElement("br");//crear br
			var n_input = document.createElement("input");//crear hidden button
				n_input.name='h_grupo'+i;
				n_input.id="h_idgrupo"+i;
				n_input.type="hidden";
				n_input.value="";
			var atributo = document.createAttribute("class");//crear atributo clase
				atributo.nodeValue ="Grupo"+i;
			var elemento = document.createElement("div"); /// crear elemento div para contenerbr y class
				elemento.id = "idGrupo"+i;
				elemento.style.width ="300px";
				elemento.style.background ="#ccc";
				elemento.attributes.setNamedItem(atributo);//asignar classs
				elemento.appendChild(elemento1);//asignar br
			var texto = document.createTextNode("Grupo "+i);//crear nodo de texto
			var tdtitulo = document.createElement("td");//crear td para el titulo
				tdtitulo.id = "idtdtit"+i;
				tdtitulo.appendChild(texto);
			var tdcontenedor = document.createElement("td"); ///crear td para el hidden y el div
				tdcontenedor.id = "idtdcont"+i;
				tdcontenedor.appendChild(elemento);//asignar div
				tdcontenedor.appendChild(n_input);//asignar hidden
			var trtit = document.createElement("tr");//crear fila en la tabla
				trtit.id = "idtrtit"+i;		
				trtit.appendChild(tdtitulo); 
			var trcont = document.createElement("tr");	
				trcont.id = "idtrcont"+i;		
				trcont.appendChild(tdcontenedor);
			var table2 = document.createElement("table");
				table2.id="idtable2"+i;
				table2.align="center";
				table2.appendChild(trtit);
				table2.appendChild(trcont);
			var td = document.createElement("td");
				td.id = "idtd"+i;
				td.appendChild(table2);
			if(suma==4){
				var tr = document.createElement("tr");
				i2++;
				cantidad_tr=i2;
				tr.id = "idtr"+i2;
				tr.appendChild(td);
				suma=0;		
			}
			else{
				tr.appendChild(td);
			}
			
			var crear=document.getElementById('grupos');
			crear.appendChild(tr);
			suma++;
		}
	}
crear_drag();
}

function borrar_lista(){
	if(cantidad_grupos>0){
		if((cantidad_tr>0)){
			var i,nombre;
			for(i=1;i<=cantidad_tr;i++){
				nombre="idtr"+i;
				elemento= document.getElementById(nombre);
				elemento.parentNode.removeChild(elemento);
			}
		}
	}
}

function obtenerElementos() {
	var texto='';
	for(i=1;i<=cantidad_grupos;i++){
		var grupos = document.getElementById("idGrupo"+i);
		var hidden=document.getElementById("h_idgrupo"+i);
		var capas=grupos.getElementsByTagName('div');
		
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
	document.formulario.CAN_GRU.value=cantidad_grupos;	
  	return false;
}
