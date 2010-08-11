// transfert plusieurs options d'une liste a une autre
function transfererOptions(form,liste1,liste2) {
 var L1 = this.document.forms[form].elements[liste1];
 var L2 = this.document.forms[form].elements[liste2];
 
 for (var i = L1.length - 1; i >= 0; i--) {
  if(L1.options[i].selected) {
   L2.options[L2.length] = new Option(L1.options[i].text, L1.options[i].value);  
   L1.options[i] = null;
  }
 }
}
// transfert l'option option vers la liste deroulante liste
function transfererOption(form,liste1,liste2) {
 var L1 = this.document.forms[form].elements[liste1]; 
 var L2 = this.document.forms[form].elements[liste2];
 
 L2.options[L2.length] = new Option(L1.options[L1.selectedIndex].text, L1.options[L1.selectedIndex].value);  
 L1.options[L1.selectedIndex] = null;
}

function rollover(name,src) {
  document.images[name].src = src;
}

function str2url(str,encoding)
{
	str = str.toUpperCase();
	str = str.toLowerCase();
	
	if (encoding == 'UTF-8' || encoding == 'utf-8') {
		str = str.replace(/[Ã Ã¡Ã¢Ã£Ã¤Ã¥]/g,'a');
		str = str.replace(/[Ã§]/g,'c');
		str = str.replace(/[Ã²Ã³Ã´ÃµÃ¶Ã¸]/g,'o');
		str = str.replace(/[Ã¨Ã©ÃªÃ«]/g,'e');
		str = str.replace(/[Ã¬Ã­Ã®Ã¯]/g,'i');
		str = str.replace(/[Ã¹ÃºÃ»Ã¼Ã¿]/g,'u');
		str = str.replace(/[Ã±]/g,'n');
	} else {
		str = str.replace(/[àáâãäå]/g,'a');
		str = str.replace(/[ç]/g,'c');
		str = str.replace(/[òóôõöø]/g,'o');
		str = str.replace(/[èéêë]/g,'e');
		str = str.replace(/[ìíîï]/g,'i');
		str = str.replace(/[ùúûüÿ]/g,'u');
		str = str.replace(/[ñ]/g,'n');
	}
	
	str = str.replace(/[^a-z0-9_\s-]/g,'');
	str = str.replace(/[\s]+/g,' ');
	str = str.replace(/[ ]/g,'-');
	return str;
	//return str.substr(0,1).toUpperCase()+str.substr(1);
}

function pop(url,width,height)
{
 var nb = parseInt('40');
 var w = parseInt(width)+nb;
 var h = parseInt(height)+nb;
 window.open(url,'_blank','toolbar=no, location=no, directories=no, menuBar=no, status=1, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', left=100, top=100');
}


function clic(link){
  	if(document.images)
  		(new Image()).src=link;
   return true;
}

function pop_mail(name,domaine)
{
    var txt = 'location=no,toolbar=no,directories=no,menubar=no,resizable=no,scrollbars=no,status=no,width=10,height=10,screenY=100,screenX=100';
    window.open('mailto:'+ name + '@' + domaine,'Mail',txt);
}

function cocherTous(checked, f, champ)
{
    for (i = 0; i < document.forms[f].elements.length; i++) {
        if (document.forms[f].elements[i].name.indexOf(champ) >= 0) {
            document.forms[f].elements[i].checked = checked;
        }
    }
}

function add_bookmark(url,title) {
       if ( navigator.appName != 'Microsoft Internet Explorer' ){
           window.sidebar.addPanel(title,url,"");
       }
       else {
           window.external.AddFavorite(url,title);
       }
}

// verifie la validite d'une date au format jj/mm/aaa
function check_date(date,format)
{
 if(format=="fr")
 {
	var regExp=/^(0[1-9]|[12][0-9]|3[01])[\- \/\.](0[1-9]|1[012])[\- \/\.](19|20)\d\d$/g;  // date au format jj/mm/aaaa ou jj-mm-aaaa ou jj mm aaaa ou jj.mm.aaaa avec aaaa compris entre 1900 et 2099.	 
 }
 else
 {
	 var regExp=/^(19|20)\d\d[\- \/\.](0[1-9]|1[012])[\- \/\.](0[1-9]|[12][0-9]|3[01])$/g; // idem ci-dessus mais format anglais (Ex : aaaa/mm/jj)
 }
 var resultat =  date.match(regExp);
 if(resultat!=null && resultat.length==1) return true; else return false;
}


// verifie si une variable javascript existe ou non
function isset(variable) {
    var undefined;
    return ( variable == undefined ? false : true );
}

//affiche ou rend invisible un element html
function afficher_elt(id,value)
{
 // we check that the element exists
 if(isset(document.getElementById(id)))
 {
  var div = document.getElementById(id);  
  if(value==0) {
	 var etat = 'block';
	 var etat_inverse = 'none';	
	 if( div.style.display != 'none')
	 {
	 	etat_inverse = etat;
		etat = 'none';
	 }	 
	 div.style.display=etat;
  }
  else
  {
	if(value=="block") {
     var etat = 'block';
	 var etat_inverse = 'none';			
	}
	else {
     var etat = 'none';
	 var etat_inverse = 'block';
	}    
  }
  div.style.display=etat;
  if(isset(document.getElementById("ImgDown"+id))) document.getElementById("ImgDown"+id).style.display=etat_inverse;
  if(isset(document.getElementById("ImgUp"+id))) document.getElementById("ImgUp"+id).style.display=etat;
 }	
}

function trier(form,tri,ordre) {
document.forms[form].elements['page'].value=1;
document.forms[form].elements['tri'].value=tri;
document.forms[form].elements['ordre'].value=ordre;
document.forms[form].submit();
}

function changer_page(form,page) {
document.forms[form].elements['page'].value=page;
document.forms[form].submit();
}

function valider(form) {
document.forms[form].elements['page'].value=1;
document.forms[form].submit();
}

// show the image "url" in the div "div" and the image "image"
function show_image (div,image,url) {
 if(url=="") {
  document.getElementById(div).style.display="none";
 }
 else {
  document.getElementById(image).src=url;
  document.getElementById(div).style.display="block";
 }
}

// show the tab "Num" of the tabs array "tablist"
function show_tab(Num, tablist)
{
  var tmp;
  var nb_tab = tablist.length;
	// on rend invisible toutes les div
	for(var i=0; i <  nb_tab; i++) {
	 tmp = tablist[i];	 
	 if(isset(document.getElementById(tmp))) document.getElementById(tmp).style.display = 'none';
	 if(isset(document.getElementById('tab_'+tmp))) document.getElementById('tab_'+tmp).className = '';
	}
	// on affiche la div 
	document.getElementById(Num).style.display = 'block';
	document.getElementById('tab_'+Num).className = 'on';	
}

function $(id) {
	return document.getElementById('id');	
}

function escapeName(name) {
	name = name.replace(/&/g,"&#38;")
	name = name.replace(/</g,"&#60;")
	name = name.replace(/>/g,"&#62;")
	name = name.replace(/"/g,"&#34;")
	name = name.replace(/'/g,"&#39;")
	return name;
}

function isKeyEnter(e) {
	var characterCode;
	if(e && e.which){
		e = e
		characterCode = e.which
	} else {
		e = event
		characterCode = e.keyCode
	}
	if (characterCode == 13)
	return true;
	return false
}

