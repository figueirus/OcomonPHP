
/**
*atualizaDiv 
*
*php_self -> poagina atual
*acao ->acao onde o programa pegar o que deve ser imprimido na div
* divName -> nome da div ...
* arrayVars -> continuação do link da pagina com seus respectivos valores e variaveis a mais ...
*/
function atualizaDiv ( php_self, acao ,divName, arrayVars) 
{
	if(arrayVars == undefined){
		var link = '';
	} else {
		var link = arrayVars; 
	}
	
	var div = document.getElementById(divName);
	if (acao == '') {
		var url = php_self + link;	
	} else {
		var url = php_self + '?acao=' + acao + link;	
	}
    
	//ajaxGet( url, div, false );
    get( url, div );
}

function atualizaFoto ( php_self, acao ) {
	var div = document.getElementById( 'foto_interna' );
	var url = php_self + '?acao=' + acao; 
	//alert(url);
	//ajaxGet( url, div, false );
	get( url, div );
}

function atualizaAdmin ( php_self, acao ) {
	var div = document.getElementById( 'corpo' );
	var url = php_self + '?acao=' + acao; 
	//alert(url);
	//ajaxGet( url, div, false );
	get( url, div );
}

function alterarEstilo( opcao ) 
{
	var div = document.getElementById( 'interna' );
	switch ( opcao ) {
	case 'esconder':		
		div.style.display = 'none';
		break;
		
	case 'mostrar':
		div.style.display = 'inline';
		break;
	}
	
}

function alteraValorPagina ( valor ) 
{	
	var obj = document.getElementById( 'foto' ); 
	var div = document.getElementById( 'interna' );
	div.innerHTML = '<img src=\"'+valor+'\" alt=\"\" onclick=\"alterarEstilo( \'esconder\' );\" />';	
	//alert(div.innerHTML);
}

function setaFocusFirstElement()
{
	sair = '0';
	for (indice=0; indice<document.forms.length; indice++) {
		for (i=0; i<document.forms[indice].elements.length; i++) {
			if ((document.forms[indice].elements[i].type == 'radio') && (document.forms[indice].elements[i].value == ''))     {
				if (document.forms[indice].elements[i].disabled == false) {
					setTimeout('document.forms[indice].elements[i].focus()', 500);
					sair = '1';
					break;
				}
			}

			if ((document.forms[indice].elements[i].type == 'text')&& (document.forms[indice].elements[i].value == '')) {
				if (document.forms[indice].elements[i].disabled ==false) {
					if (document.forms[indice].elements[i].readOnly== false) {
						setTimeout('document.forms[indice].elements[i].focus()', 500);
						sair = '1';
						break;
					}
				}
			}

			if ((document.forms[indice].elements[i].type == 'textarea') && (document.forms[indice].elements[i].value == '')) {
				if (document.forms[indice].elements[i].disabled == false) {
					if (document.forms[indice].elements[i].readOnly== false) {
						setTimeout('document.forms[indice].elements[i].focus()', 500);
						sair = '1';
						break;
					}
				}
			}

			if ((document.forms[indice].elements[i].type == 'checkbox') && (document.forms[indice].elements[i].value == '')) {
				if (document.forms[indice].elements[i].disabled == false) {
					setTimeout('document.forms[indice].elements[i].focus()', 500);
					sair = '1';
					break;
				}
			}

			if ((document.forms[indice].elements[i].type == 'select-one') && (document.forms[indice].elements[i].value == '')) {
				if (document.forms[indice].elements[i].disabled == false) {
						setTimeout('document.forms[indice].elements[i].focus()', 500);
					sair = '1';
					break;
				}
			}
		}
		if (sair == '1') {
			break;
		}
	}
}

function writeToday(formName, elementName, nextElement) 
{
	var tmpObj = eval('document.' +formName+ '.' +elementName);
	if (tmpObj.value == '') {
		var today = new Date(); 
		var tmpDay =  String(today.getDate()); 
		var tmpMonth = String(today.getMonth()+ 1);  
		var tmpYear = String(today.getFullYear());  
		tmpDay  = ((tmpDay.length==1)? '0':'')  + String(tmpDay); 
		tmpMonth = ((tmpMonth.length==1)? '0':'') +  String(tmpMonth); 
		var tmpDate = tmpDay + tmpMonth + tmpYear; 
		tmpObj.value = tmpDate;
	} else { 
		return; 
	}
}

function NewWindow(myPage, myName, Width, Height, Scroll, Resizable) {
	var winTop = ((screen.height - Height) / 2);
	var winLeft= ((screen.width - Width) / 2); 
	winProps = 'top=' +winTop+ ',left=' +winLeft+ ',height=' +Height+ ',width=' +Width+ ',Scrollbars=' +Scroll+ ',Resizable=' +Resizable;
	Win = window.open(myPage, myName, winProps); 
		if (parseInt(navigator.appVersion) >= 4) {  
			Win.window.focus(); //set focus to the window 
		}
		function CloseCalandar()  
		{ 
			try { 
				Win.close(); 
			} catch(e) {} 
		} 
		
}


/*
*Metodos para uso do text Valor
*
* 
*
*/   
function formataValor(campo)
{
    campo.value = filtraCampo(campo);
    vr = campo.value;
    tam = vr.length;

    if ( tam <= 2 ){ 
        campo.value = vr ; }
    if ( (tam > 2) && (tam <= 5) ){
        campo.value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ) ; }
    if ( (tam >= 6) && (tam <= 8) ){
        campo.value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
    if ( (tam >= 9) && (tam <= 11) ){
        campo.value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
    if ( (tam >= 12) && (tam <= 14) ){
        campo.value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ; }
    if ( (tam >= 15) && (tam <= 18) ){
        campo.value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam ) ;}                 		
}   

function filtraCampo(campo)
{
    var s = '';
    var cp = '';
    var regra = new RegExp("[0-9]");
    vr = campo.value;
    tam = vr.length;
            
    for (i = 0; i < tam ; i++) {  
        var conferir = regra.exec(vr.substring(i,i + 1));   
        if (vr.substring(i,i + 1) != "/" && vr.substring(i,i + 1) != "-" && vr.substring(i,i + 1) != "."  && vr.substring(i,i + 1) != "," && conferir != null){
            s = s + vr.substring(i,i + 1);}
    }
    campo.value = s;
    return cp = campo.value
}


