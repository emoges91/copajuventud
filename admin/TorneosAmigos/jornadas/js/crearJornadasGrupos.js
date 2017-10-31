function invertir(equipoCasa1,equipoVisita2,numGrup,mitJor,jorAct){
			var equipo1;
			var equipo2;
			var otraJorna;
			if(jorAct<=mitJor){
				equipo1="i_"+numGrup+"_"+equipoCasa1+"_"+jorAct;
				equipo2="i_"+numGrup+"_"+equipoVisita2+"_"+jorAct;
				otraJorna=jorAct+mitJor;
				vuelta_ida1="v_"+numGrup+"_"+equipoVisita2+"_"+otraJorna;
				vuelta_ida2="v_"+numGrup+"_"+equipoCasa1+"_"+otraJorna;
			}
			else{
				equipo1="v_"+numGrup+"_"+equipoCasa1+"_"+jorAct;
				equipo2="v_"+numGrup+"_"+equipoVisita2+"_"+jorAct;
				otraJorna=jorAct-mitJor;
				vuelta_ida1="i_"+numGrup+"_"+equipoVisita2+"_"+otraJorna;
				vuelta_ida2="i_"+numGrup+"_"+equipoCasa1+"_"+otraJorna;
			}
			
			var equipo_selecionado1=document.getElementById(equipo1);
			var equipo_selecionado2=document.getElementById(equipo2);	
			var equipo_afectado1=document.getElementById(vuelta_ida1);
			var equipo_afectado2=document.getElementById(vuelta_ida2);
				
			var dato1=equipo_selecionado1.childNodes[0].nodeValue;
			var dato2=equipo_selecionado2.childNodes[0].nodeValue;
			var dato3=equipo_afectado1.childNodes[0].nodeValue;
			var dato4=equipo_afectado2.childNodes[0].nodeValue;
			
			equipo_selecionado1.childNodes[0].nodeValue =dato2;
			equipo_selecionado2.childNodes[0].nodeValue =dato1;
			equipo_afectado1.childNodes[0].nodeValue =dato4;
			equipo_afectado2.childNodes[0].nodeValue =dato3;
			
			var selecionado=document.getElementById(equipo1+"_hdn");
			var selecionado2=document.getElementById(equipo2+"_hdn");
			var vuelta=document.getElementById(vuelta_ida1+"_hdn");
			var vuelta2=document.getElementById(vuelta_ida2+"_hdn");
			
			var p1="";
			var p2="";
			var u1="";
			var u2="";
			
			p1= selecionado.value
			p2 = selecionado2.value;
			
			selecionado.value=p2;
			selecionado2.value=p1;
				
			u1 = vuelta.value;
			u2 = vuelta2.value;
				
			vuelta.value=u2;
			vuelta2.value=u1;
			
			alert("Jornadas volteadas");
		}