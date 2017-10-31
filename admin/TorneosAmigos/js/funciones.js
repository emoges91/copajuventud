function sure(){
	if (confirm('Esta seguro/a que desea eliminar?')){
		return true;	
	}else{
		return false;	
	}
}

function mostrarTorneo(url){
	document.location.href=url;
	return true;
}

function voltear(){
	if (confirm('Esta seguro/a que desea cambiar las jornadas?, debe de tener en cuenta que el otro partido no sera modificado.')){
		return true;	
	}else{
		return false;	
	}
}

function ordenJornadas(){
	if (confirm('Esta seguro/a que desea cambiar el orden de las jornadas?')){
		return true;	
	}
	else{
		return false;	
	}
}