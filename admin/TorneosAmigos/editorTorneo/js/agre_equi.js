var i=0
function agregarEquipo(NombreEquipo){
	var txtNomb=document.getElementById('TexNomEqui');
		
	var DivLisEquipo=document.getElementById('lista');
	
	var src=document.createAttribute('src');
		src.nodeValue="img/form_exit.png";
		
	var onClickBorr=document.createAttribute('onclick');
		onClickBorr.nodeValue ="borrarEquipos('d_DatosEqui"+i+"');";
		
	var img=document.createElement('img');
		img.attributes.setNamedItem(src);
		img.attributes.setNamedItem(onClickBorr);
		img.style.width='20px';
	
	var HidEquipo = document.createElement("input");
		HidEquipo.name='h_equi'+i;
		HidEquipo.id="h_idequi"+i;
		HidEquipo.type="hidden";
		HidEquipo.value=txtNomb.value;
		HidEquipo.style.cssFloat='left';
											
	var texto = document.createTextNode(NombreEquipo);
			
	var DivEquipo = document.createElement("div");
		DivEquipo.id = "idequi"+i;
		DivEquipo.style.width ="300px";
		DivEquipo.style.background ="#ddd";
		DivEquipo.style.cssFloat='left';
		DivEquipo.appendChild(texto);
			
	var DivDatosEquipo = document.createElement("div");
		DivDatosEquipo.id = "d_DatosEqui"+i;
	
	DivDatosEquipo.appendChild(HidEquipo);
	DivDatosEquipo.appendChild(DivEquipo);
	DivDatosEquipo.appendChild(img);
	DivLisEquipo.appendChild(DivDatosEquipo);
			
	i++;	
}

function borrarEquipos(idDiv){
	var DivDatosEquipo=document.getElementById(idDiv);
	DivDatosEquipo.parentNode.removeChild(DivDatosEquipo);
}

function obtenerElementos() {
	var arregloEquipos=document.getElementById("HidListEqui");
	arregloEquipos.value='';
	
	for(e=0;e<=i;e++){
		var hidden=document.getElementById("h_idequi"+e);	
		if(hidden!=null){
			if(e==0){
				arregloEquipos.value=hidden.value+',';
			}
			else{
				arregloEquipos.value=arregloEquipos.value+hidden.value+',';
			}			
		}		
	}

	arregloEquipos.value=arregloEquipos.value.slice(0,arregloEquipos.value.length-1);
	cambiarDestino();
    return false;
}

function cambiarDestino(){
	var Formulario=document.getElementById("formulario");
	if(document.formulario.RBGruLlav[0].checked){
		Formulario.action="formularioGrupos.php";
	}
	else{
		Formulario.action="formularioLlaves.php";
	}
}