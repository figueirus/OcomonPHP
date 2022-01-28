<?php
/*
Script editado e adaptado por Matheus Ritter Camargo

Data: 
*/
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico"/>
<title>Termo de Identificação e Compromisso - CINFO   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
</head>
<body>
<div id="principal" name="principal">
<form name="form" method="post" action="valida.php">
		<table width="100%">
			<tr>
				<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
			</tr>
			<tr>
				<td colspan="9"><div align="center"><font face="Arial, Helvetica, sans-serif" size="3"><b><font size="5">Termo de Identificação e Compromisso<br>
				  <br>
				  <font size="2" face="Arial"><b>*Campos obrigatórios</b></font>
				  <br><font size="2" ><a href="javascript: printTip();">Dicas para segurança de senha</a></font>
				  <br>
				  </font></b></font></div></td>
			</tr>
			<tr>
				<td colspan="9"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
			</tr>
			<tr>
				<td colspan="3" valign="middle"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Selecione sua Área: </font></div></td>
				<td colspan="6" valign="middle">
					<div align="left">
						<select name="INDICE" onkeypress="checkEverything();" id="INDICE">
							<option value="null">-------------------</option>
							<option value="00">Colégio Lasalle - Canoas</option>
							<option value="02">Pró-Reitoria Acadêmica</option>
							<option value="04">Pró-Reitoria de Desenvolvimento</option>
							<option value="01">Reitoria</option>
						</select>*
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="8" valign="top">
					<div align="center" class="tabela">
						<div align="left"><font face="Arial, Helvetica, sans-serif" size="2" >
						<br>
						<b>Dados Pessoais </b>
						<br>
						<br>
						</font></div>
					</div>
				</td>
				<td width="1">
					<div align="left"></div>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Nome Completo:</font></div></td>
				<td colspan="6" valign="middle">
					<div align="left">
						<input type="text" name="NM_NOVO" id="NM_NOVO" onkeypress="checkEverything();" size="30" maxlength="100">*
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Data de Nascimento: </font></div></td>
				<td colspan="6" valign="middle">
					<div align="left">
						<input type="text" name="DT_ANIV" id="DT_ANIV" onblur="checkEverything();" onkeypress="return dateMask(this,event);" size="8" maxlength="10">*
						<font face="Arial, Helvetica, sans-serif" size="1" color="#FF0000">ex.: ddmmaaaa</font>
					</div>
				</td>
			</tr>
			<tr valign="middle">
				<td colspan="8">
					<div align="center" class="tabela">
						<div align="left"><font face="Arial, Helvetica, sans-serif" size="2" >
						<br>
						<b>Controlador Domínio(Arquivos)/ Recursos de E-mail</b>
						<br>
						<br>
						</font></div>
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="3">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif">
						<font face="Arial, Helvetica, sans-serif">
						<font size="2">Senha:</font></font></font>
					</div>
				</td>
				<td colspan="5">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
						<input onkeyup="checkEverything();" onblur="checkPass('campo_senha')" onkeypress="capLock(event)" type="password" name="SENHA" id="SENHA" size="15" maxlength="16">*
						<font size="1" color="#FF0000">Obs:A senha deve conter no mínimo 1 letra minúscula, 1 maiúscula, 1 número e ter de 8 a 16 caracteres.</font></font> 
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="3">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif">
						<font face="Arial, Helvetica, sans-serif">
						<font size="2">Confirmação :</font></font></font>
				</div>
				</td>
				<td colspan="5">
					<div align="left">
							<font face="Arial, Helvetica, sans-serif" size="2">
							<input type="password" name="SENHA_CONF" id= "SENHA_CONF" onkeyup="checkEverything();" onkeypress="capLock(event)" onblur="checkPass('campo_senha')" size="15" maxlength="16">*<img style="visibility: hidden" id="image_ok" src="http://www.intranet.unilasalle.edu.br/sistemas/contato/usuarios/ok.png"></img><img style="visibility: hidden" id="image_drop" src="http://www.intranet.unilasalle.edu.br/sistemas/contato/usuarios/drop.png"></img>
							<span><div id="divCaps" style="visibility:hidden"><b style="background: RED">A tecla Caps Lock está ativada!</b></div></span>
						</font>
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="8">
					<div align="center" class="tabela">
						<div align="left"><font face="Arial, Helvetica, sans-serif" size="2" >
						<br>
						<b>Dados Gerais</b>
						<br>
						<br>
						</font></div>
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="3">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif">
						<font face="Arial, Helvetica, sans-serif">
						<font size="2">Função</font></font></font>
					</div>
				</td>
				<td colspan="5">
					<div align="left">
						<select name="CARGO" onblur="checkEverything();" id="CARGO">
							<option value="null">-------------------</option>
							<option value="Estagiário">Estagiário</option>
							<option value="Funcionário colégio">Funcionário Colégio</option>
							<option value="Funcionário unilasalle">Funcionário Unilasalle</option>
							<option value="Professor colégio">Professor Colégio</option>
							<option value="Professor unilasalle">Professor Unilasalle</option>
						</select>*
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Setor:</font></div></td>
				<td colspan="6" valign="middle">
					<div align="left">
						<input type="text" name="SETOR" onkeypress="checkEverything();" id="SETOR" size="30" maxlength="100">*
					</div>
				</td>
			</tr>
			
			<tr valign="middle">
				<td colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Centro de Custo:</font></div></td>
				<td colspan="6" valign="middle">
					<div align="left">
						<input type="text" name="CCUSTO" onkeypress="checkEverything();" id="CCUSTO" size="30" maxlength="100">* 
						<a size="2" font="Arial" href="http://www.intranet.unilasalle.edu.br/assets/upload/centro_custos_unilasalle.pdf" target="_blank">Centro de Custos</a>
					</div>
				</td>
			</tr>
			<tr valign="middle">
				<td colspan="3">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif">
						<font face="Arial, Helvetica, sans-serif"></font></font>
						<font face="Arial, Helvetica, sans-serif" size="2">Ramal:
						</font>
					</div>
					<td colspan="6">
						<div align="left">
							<font face="Arial, Helvetica, sans-serif" size="2">
								<input type="text" name="RAMAL" onkeypress="checkEverything();" id="RAMAL" size="4" maxlength="4">*
							</font>
					</div>
					</td>
				</td>
			</tr>
			<tr valign="middle">
				<td colspan="3"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Acessos aos sistemas</font></div></td>
				<td colspan="6">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
							<label for="PERGA">Pergamun</label><input onclick="printPerga()" value="Pergamun" type="checkbox" id="PERGA" name="sis[]"></input> 
							<label for="SA">S.A.:</label><input value="S.A." type="checkbox" id="SA" name="sis[]"></input> 
							<label for="SGL">SGL:</label><input value="SGL" type="checkbox" id="SGL" name="sis[]"></input> 
							<label for="DATAFIT">DataFitness:</label><input value="DataFitness" type="checkbox" id="DATAFIT" name="sis[]"></input>
								<br>
						</font>
						<div style="visibility: hidden" id="pergadiv" name="pergadiv">
							
								<div align="left">Senha:	<input onkeyup="checkEverything()" id="SENHA_PERGA" name="SENHA_PERGA" type="password" onBlur="checkPergaPass()" onkeypress="return pergaMask(this,event)" ></input>
								Confirmação: <input onkeyup="checkEverything()" id="SENHA_PERGA_CONF" name="SENHA_PERGA_CONF" type="password" onBlur="checkPergaPass()" onkeypress="return pergaMask(this,event)" ></input><img style="visibility: hidden" id="image_ok2" src="http://www.intranet.unilasalle.edu.br/sistemas/contato/usuarios/ok.png"></img><img style="visibility: hidden" id="image_drop2" src="http://www.intranet.unilasalle.edu.br/sistemas/contato/usuarios/drop.png"></img></div>
							
					</div>
				</td>
			</tr>
			
			<tr valign="middle">
				<td colspan="3"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Acessos às pastas :</font></div></td>
				<td colspan="6">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
							<textarea onblur="checkEverything()" id="PASTAS" name="PASTAS" style="width: 210px; height: 100px; resize: none"></textarea>
							<font size="1" color="#FF0000">Separe as pastas por Enter (tecla).</font>
						</font>
					</div>
				</td>
			</tr>
			<tr valign="middle">
				<td colspan="3"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Aliases :</font></div></td>
				<td colspan="6">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
						
							<input type="button" id="ALIAS_BOTAO" name="ALIAS_BOTAO" value="Adicionar" onClick="addAlias()" ></input>
							<input type="hidden" value="0" id="theValue" />
							<div name="cria" id="cria"></div>
						</font>
					</div>
				</td>
			</tr>
			<tr valign="middle">
				<td width="28"><div align="left"></div></td>
				<td width="19"><div align="left"></div></td>
				<td width="72"><div align="left"></div></td>
				<td width="7"><div align="left"></div></td>
				<td width="51"><div align="left"></div></td>
				<td width="20"><div align="left"></div></td>
				<td width="38"><div align="left"></div></td>
				<td width="167"><div align="left"></div></td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="8" class="tabela"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2" >
				<br>
				<b>Dados do Respons&aacute;vel/Coordenador/Liderança</b>
				<br>
				<br>
				</font></div></td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="3">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif">
						<font face="Arial, Helvetica, sans-serif">
						<font size="2">Nome:</font></font></font>
					</div>
				</td>
				<td colspan="6">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
							<input type="text" name="NM_RESP" onkeypress="checkEverything();" onblur="convertCaps();" id="NM_RESP" size="30" maxlength="50">*
						</font>
					</div>
				</td>
			</tr>
			<tr valign="middle">
				<td colspan="3"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Email:</font></div></td>
				<td colspan="6">
					<div align="left">
						<font face="Arial, Helvetica, sans-serif" size="2">
							<input type="text" name="MAIL" onkeypress="checkEverything();" id="MAIL" size="30" maxlength="50">*						
						</font>
					</div>
				</td>
			</tr>			
			<tr valign="middle">
				<td colspan="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"></font></div></td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="8">
					<div align="center" class="tabela">
						<div align="middle">
							<font face="Arial, Helvetica, sans-serif" size="2"><b>Muito Obrigado.</b></font>
						</div>
					</div>
				</td>
				<td width="1"><div align="left"></div></td>
			</tr>
			<tr valign="middle">
				<td colspan="8">
					<div align="middle">
						<font face="Arial, Helvetica, sans-serif" size="2">Verifique todos os dados, clique no botão para gerar o formulário, imprima e obtenha as autorizações necessárias.<br> 
						O formulário impresso e assinado deverá ser entregue à TI do Unilasalle.</font><BR>
						<input type="submit" name="Submit" disabled="true" id="gera_form" value="Gerar Formulário"><BR>
						<font face="comic-sams" size="2" background=="#DF0101" id="MSG_ALL">
						<BR>
						<BR>
						</font>
					</div>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<p>&nbsp;</p>
</body>
</html>
<script style="text-align:justify" text="text/javascript" language="javascript">
var flag=0;
var flag2=0;
var flag3=0;
var input=1;
var exp = new Array("024681012","135791113","12345678","23456789","01234567");
//                         0         1            2         3        4
function dateMask(inputData, e){//Formato de data dd/mm/aaaa
    if(document.all) // Internet Explorer
        var tecla = event.keyCode;
    else //Outros Browsers
        var tecla = e.which;

    if(tecla >= 48 && tecla < 58){ // só aceita numeros de 0 a 9
        var data = inputData.value;
    if (data.length == 2 || data.length ==5){
        data += '/';
        inputData.value = data;
    }
    }else if(tecla == 8 || tecla == 0) // Backspace, Delete
        return true;
    else
        return false;
}

function checkNull(){ //verifica se há campos em branco
	var nome=document.getElementById("NM_NOVO").value;
	var dataNasc=document.getElementById("DT_ANIV").value;
	var setor=document.getElementById("SETOR").value;
	var centroCustos=document.getElementById("CCUSTO").value;
	var ramal=document.getElementById("RAMAL").value;
	var nomeResp=document.getElementById("NM_RESP").value;
	var emailResp=document.getElementById("MAIL").value;
	var senha=document.getElementById("SENHA").value;
	var indice=document.getElementById("INDICE").value;
	var senhaconf=document.getElementById("SENHA_CONF").value;
	var cargo=document.getElementById("CARGO").value;
		if((cargo=="null")||(indice=="null")||(senha=="") || (senhaconf=="")||(nome=="")||(dataNasc=="")||(setor=="")||(centroCustos=="")||(ramal=="")||(nomeResp=="")||(emailResp=="")||(senhaconf=="")){
				flag2=1;
		} else {
				flag2=0;
				return true;
				}
}
function convertCaps(){ //converte automaticamente o nome para upper case
	document.form.NM_NOVO.value=document.form.NM_NOVO.value.toUpperCase();
	document.form.NM_RESP.value=document.form.NM_RESP.value.toUpperCase();

}

function checkEverything(){ //valida todos os campos
	checkNull();
	if(flag2==1||flag==1||flag3==1){
		document.getElementById("gera_form").disabled = true;
		document.getElementById("MSG_ALL").innerHTML="Preencha todos os campos corretamente!";
	} else {
		document.getElementById("gera_form").disabled = false;
		document.getElementById("MSG_ALL").innerHTML="";
			}
}

function checkPass(campo){ // valida o campo senha
		var pass1=document.getElementById("SENHA").value;
	    var pass2=document.getElementById("SENHA_CONF").value;
		var nasc = document.getElementById("DT_ANIV").value;
		var nasc = nasc.replace(/\//g,"");
		var data = new RegExp(nasc); 
		var nome = document.getElementById("NM_NOVO").value;
		nome = nome.split(" ");
		var nome0 = new RegExp(nome[0]);
		var nome1 = new RegExp(nome[1]);
		
	
	if((pass1==pass2)&&(pass1.length>=8)&&(pass1.match(/[a-z]+/))&&(pass1.match(/[A-Z]+/))&&(pass1.match(/\d+/))){
			flag=0;
		}else{
			flag=1;
		}
	if ((pass1.match(data))||(pass1.match(nome0))||(pass1.match(nome1))||(pass1.match(exp[0]))||(pass1.match(exp[1]))||(pass1.match(exp[2]))||(pass1.match(exp[3]))||(pass1.match(exp[4]))){
			flag=1;
		}
		
	if(flag==1){
			document.getElementById("image_ok").style.visibility='hidden';
			document.getElementById("image_drop").style.visibility='visible';
		}else{
			document.getElementById("image_drop").style.visibility='hidden';
			document.getElementById("image_ok").style.visibility='visible';
		}
	}


  var contCampo = 1;// <-- contador de campos
function addAlias(ALIAS_CAMPO) { //adiciona campos de alias ao clicar no botão ADICIONAR, máximo é 5 e mínimo 1
  var ni = document.getElementById('cria');
  var numi = document.getElementById('theValue');
  var num = (document.getElementById("theValue").value -1)+ 2;
  numi.value = num;
  // var divIdName = document.getElementById('ALIAS_CAMPO').name;
  // var qwe = document.getElementById('ALIAS_CAMPO').name;
  var newdiv = document.createElement('div');
  // newdiv.setAttribute("id",divIdName);
	if(contCampo<5){
		newdiv.innerHTML = "<input type='text' id='ALIAS_CAMPO' onblur='checkEverything()' name='ALIAS_CAMPO[]'> </input><input type='button' value='Remover'onclick=\"removeElement(\'ALIAS_CAMPO\')\"></input>";
		ni.appendChild(newdiv);
		contCampo++;
	}else{
		alert("Excedeu o limite de "+contCampo+" campos!");
	}
}

var nomecampo = document.getElementById('ALIAS_CAMPO').name;
function removeElement(nomecampo) {//remove os campos que foram adicionado dinamicamente, apenas eles
  var d = document.getElementById('cria');
  var olddiv = document.getElementById(nomecampo);
  d.removeChild(olddiv);
  contCampo--;
}


function checkPergaPass(){
	var pergamun = document.getElementById('PERGA').checked;
	var pass1 = document.getElementById("SENHA_PERGA").value;
	var pass2= document.getElementById("SENHA_PERGA_CONF").value;
	var nasc = document.getElementById("DT_ANIV").value; // pega a data de nascimento
	var nasc = nasc.replace(/\//g,""); // tira as barras da data de nascimento
	var data = new RegExp(nasc); //transforma a a variável da data de nascimento, já sem as barras, em uma expressão regular
	// verifica se as senhas são iguais e se têm 8 ou mais dígitos
	if((pass1==pass2)&&(pass1.length>=8)){
			flag3=0;
		}else 
			flag3=1;
	
	if ((pergamun==true)&&(pass1=="")&&(pass2="")){
			flag3=1;
	}
	
	if ((pass1.match(data))||(pass1.match(exp[0]))||(pass1.match(exp[1]))||(pass1.match(exp[2]))||(pass1.match(exp[3]))||(pass1.match(exp[4]))){ //testa se a data de nascimento foi posta na senha
			flag3=1;
		}
		
	if(flag3==1){
			document.getElementById("image_ok2").style.visibility='hidden';
			document.getElementById("image_drop2").style.visibility='visible';
		}else{
			document.getElementById("image_drop2").style.visibility='hidden';
			document.getElementById("image_ok2").style.visibility='visible';
			}
}
	
function pergaMask(inputData, e){//só número para a senha do pergamun
    if(document.all) // Internet Explorer
        var tecla = event.keyCode;
    else //Outros Browsers
        var tecla = e.which;

    if(tecla >= 48 && tecla < 58){ // só aceita numeros de 0 a 9
        var campo = inputData.value;
    }else if(tecla == 8 || tecla == 0){ // Backspace, Delete
		return true;
    }else
        return false;
}

function capLock(e){ //detecta se o capslock está ativo
    kc = e.keyCode?e.keyCode:e.which;
    sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
		if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk))
			document.getElementById('divCaps').style.visibility = 'visible';
		else
			document.getElementById('divCaps').style.visibility = 'hidden';
}

function printTip(){
	var msg = new Array("Para obter senhas seguras, também de acordo com o formulario, não utilize dados do cadastro como "+
						"'Nome' nem 'Data de Nascimento'. Não utilize sequências numéricas numéricas e não anote sua senha,"+
						" caso precise anotar, certifique-se de que estará em um local seguro.");
	alert(msg);
}

function printPerga(){ //se clicado no sistema pergamum abrirá campo senha para cadastro
		var pergamun = document.getElementById('PERGA').checked;
		
	if(pergamun==true){
		alert("Selecionando o sistema pergamun, duas caixas de texto abrirão. Nelas insira sua senha e logo após a cofirmação!"+
		"  A senha deve ser composta por números, entre 8 e 12 caracteres, não utilize dados do formulário para compo-la.");
		document.getElementById('pergadiv').style.visibility = 'visible';
		flag3=1;
		checkEverything();
	}
	else{
		document.getElementById('pergadiv').style.visibility = 'hidden';		
		flag3=0;
		checkEverything();
	}
}
  
</script>



