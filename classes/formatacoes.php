<?
##### FORMATAÇÃO DE DIVERSAS #####
<script>
	//--->Função para a formatação dos campos...<---
	function Mascara(tipo, campo, teclaPress) {
		if (window.event)
		{
			var tecla = teclaPress.keyCode;
		} else {
			tecla = teclaPress.which;
		}
		var s = new String(campo.value);
		// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
		s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');

		tam = s.length + 1;

		if ( tecla != 9 && tecla != 8 ) {
			switch (tipo)
			{
			case 'CPF' :
				if (tam > 3 && tam < 7)
					campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
				if (tam >= 7 && tam < 10)
					campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
				if (tam >= 10 && tam < 12)
					campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
			break;
			
			 case 'HORA' :
				if (tam > 2 && tam < 4)
					campo.value = s.substr(0,2) + ':' + s.substr(2, tam);
				if (tam > 4 && tam < 11)
					campo.value = s.substr(0,2) + ':' + s.substr(2,2) + ':' + s.substr(4,tam-4);
			break;
			
			case 'CNPJ' :

				if (tam > 2 && tam < 6)
					campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
				if (tam >= 6 && tam < 9)
					campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
				if (tam >= 9 && tam < 13)
					campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
				if (tam >= 13 && tam < 15)
					campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
			break;

			case 'TEL' :
				if (tam > 2 && tam < 4)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
				if (tam >= 7 && tam < 11)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
			break;

			case 'DATA' :
				if (tam > 2 && tam < 4)
					campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
				if (tam > 4 && tam < 11)
					campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
			break;
			
			case 'CEP' :
				if (tam > 5 && tam < 7)
					campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
			break;
			}
		}
	}

	//--->Função para verificar se o valor digitado é número...<---
	function digitos(event){
		if (window.event) {
			// IE
			key = event.keyCode;
		} else if ( event.which ) {
			// netscape
			key = event.which;
		}
		if ( key != 8 || key != 13 || key < 48 || key > 57 )
			return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
		return true;
	}
</script>

// <input name="cep" type="text" id="cep" maxlength="9" size="8" onkeypress=\"return digitos(event, this);\" onkeyup=\"Mascara('CEP',this,event);\">
##########################################

##### FORMATAÇÃO DE DATA #####
<input type="text" id="campo" maxlength="10" onkeyup="barra(this)">

<script language="javascript">
	function barra(objeto){
		if (objeto.value.length == 2 || objeto.value.length == 5 ){
			objeto.value = objeto.value+"/";
		}
	}
</script>
##########################################

##### FORMATAÇÃO DE MOEDA #####
	function Limpar(valor, validos) {
		// retira caracteres invalidos da string
		var result = "";
		var aux;
		for (var i=0; i < valor.length; i++) {
			aux = validos.indexOf(valor.substring(i, i+1));
			if (aux>=0) {
				result += aux;
			}
		}
		return result;
	}

//Formata número tipo moeda usando o evento onKeyDown
	function Formata(campo,tammax,teclapres,decimal) {
		var tecla = teclapres.keyCode;
		vr = Limpar(campo.value,"0123456789");
		tam = vr.length;
		dec=decimal
		if (tam < tammax && tecla != 8){ 
			tam = vr.length + 1 ; 
		}
		if (tecla == 8 ){
			tam = tam - 1 ; 
		}
		if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
			if ( tam <= dec ){ 
				campo.value = vr ; 
			}
			if ( (tam > dec) && (tam <= 5) ){
				campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 6) && (tam <= 8) ){
				campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 9) && (tam <= 11) ){
				campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 12) && (tam <= 14) ){
				campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 15) && (tam <= 17) ){
				campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
			}
		} 
	}

<texto1: <input type="text" name="texto" size="20" onKeydown="Formata(this,20,event,2)">





?>