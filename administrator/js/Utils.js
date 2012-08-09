/**
 * Classe de utilidades
 * 
 * @author Rodrigo de Mac�do
 */
function Utils(){
	
	this.func = function (){
		alert('!');
	}
}
Utils = new Utils();

/*******************************************************/

function Validar(){
	
	/**
	 * M�todo usado para validar os e-mails
	 * 
	 * @param {Object} strEmail
	 * @return boolean
	 */
	this.email = function (strEmail){
		//pattern
		var er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
		
		//testar o regexp. Se der certo, retorna true
		if((strEmail != "") && (er.test(strEmail))){
			return true;
		}
		
		//se chegar aqui � porque n�o � v�lido
		return false;
	}
	
	/**
	 * M�todo usado para validar datas
	 * 
	 * @param {Object} strEmail
	 * @return boolean
	 */
	this.data = function(strEmail){
		//pattern
		var er = /(0[0-9]|[12][0-9]|3[01])[-\.\/](0[0-9]|1[012])[-\.\/][0-9]{4}/;
		
		//testar o regexp. Se der certo, retorna true
		if((strEmail != "") && (er.test(strEmail))){
			return true;
		}
		
		//se chegar aqui � porque n�o � v�lido
		return false;
	}
	
	/**
	 * M�todo usado para validar datas
	 * 
	 * @param {Object} strEmail
	 * @return boolean
	 */
	this.hora = function(strEmail){
		//pattern
		var er = /(0[0-9]|1[0-9]|2[0123]):[0-5][0-9]/;

		
		//testar o regexp. Se der certo, retorna true
		if((strEmail != "") && (er.test(strEmail))){
			return true;
		}
		
		//se chegar aqui � porque n�o � v�lido
		return false;
	}
}
Validar = new Validar();


/**********************************************************************************/
 
 function Mask() {
	 /**
	  * M�todo usado para mascarar o campo de telefone
	  * 
	  * @param {Object} v
	  * @return Valor mascarado (##)####-####
	  */
	 
	 this.telefone = function (v){
	 	v=v.replace(/\D/g,'');
		v=v.replace(/^(\d\d)(\d)/g,'($1) $2');
		v=v.replace(/(\d{4})(\d)/,'$1-$2');
		return v;
	 }
	 
	 this.cpf = function (v){
		    v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
		    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
		    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
		                                             //de novo (para o segundo bloco de n�meros)
		    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h�fen entre o terceiro e o quarto d�gitos
		    return v
		}
	 	 
	 this.soNumeros = function (v){
		    return v.replace(/\D/g,"")
		}

	this.cep = function (v){
		v=v.replace(/D/g,"")                
        v=v.replace(/^(\d{5})(\d)/,"$1-$2") 
        return v

	}
	
	 /*Fun��o que padroniza CNPJ*/
     this.Cnpj = function(v){
        v=v.replace(/\D/g,"")                   
        v=v.replace(/^(\d{2})(\d)/,"$1.$2")     
        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") 
        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           
        v=v.replace(/(\d{4})(\d)/,"$1-$2")              
        return v
    }


	  
}

 Mascara = new Mask();
 
 
 /*function utf8_decode ( str_data ) {
    // Converts a UTF-8 encoded string to ISO-8859-1  
    // 
    // version: 1006.1915
    // discuss at: http://phpjs.org/functions/utf8_decode    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'    var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0;
    
    str_data += '';
    
    while ( i < str_data.length ) {        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if ((c1 > 191) && (c1 < 224)) {            c2 = str_data.charCodeAt(i+1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i+1);            c3 = str_data.charCodeAt(i+2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    } 
    return tmp_arr.join('');
}*/