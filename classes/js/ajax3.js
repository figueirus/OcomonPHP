function getXmlHttpRequest() {
    try{
        Xmlhttp = new XMLHttpRequest();
    }catch(ee){
        try{
            Xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                Xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(E){
                Xmlhttp = false;
            }
        }
    }
    return Xmlhttp;
}


function get(url, obj) {
    if (obj == null) obj = "main";
    var objMain = obj;
    if (objMain == null) {
        alert(obj + " � nulo!");
        return;
    }
   
//    var status = "<img src='imagens/animated_loading.gif' width='16' height='16' align='absbottom'>Carregando " + url + "...";
   // var status = "<center><img src='js/bigrotation2.gif' width='20' height='20' align='absbottom' class='bg'> Carregando...";
	
	// carregadores:
	// -> mozilla_blu.gif
	// -> bigrotation2
	// -> rotating_arrow
	// -> wait
	
    //var status = "Carregando...";

    if (objMain.innerHTML == status) return;

    objMain.innerHTML = status;
   
    gXmlhttp = getXmlHttpRequest();

    gXmlhttp.open('GET', url, false);
    gXmlhttp.onreadystatechange = function() {
        if (gXmlhttp.readyState == 3){
                try {
                    //objMain.innerHTML = status + parseInt((gXmlhttp.responseText.length * 100)/gXmlhttp.getResponseHeader("Content-Length")) + "%";
                    objMain.innerHTML = status;
                }catch(ie){
    //                alert(ie.message);
                }
        }
		
        if (gXmlhttp.readyState == 4) {
            if (gXmlhttp.status == 200) {
                objMain.innerHTML = gXmlhttp.responseText;
            } else {
                objMain.innerHTML = "Ocorreu um erro ao carregar arquivo:\n" + gXmlhttp.statusText;
            }
        }
    }
    gXmlhttp.send(null);

   window.status = 'Conclu�do.';
}
