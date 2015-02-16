function MM_findObj(n, d)	{ //v4.0
	var p,i,x;	if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && document.getElementById) x=document.getElementById(n); return x;
}
	
function MM_changeProp(objName,x,theProp,theValue)	{ //v3.0
	var obj = MM_findObj(objName);
	if (obj && (theProp.indexOf("style.")==-1 || obj.style)) eval("obj."+theProp+"='"+theValue+"'");
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}


function confirmDelete()	{
	return confirm('Your are about to permanently delete this item. Delete it?');
}

function stateChanged() 
{ 

	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	   { 
		var id = readCookie('id')
		var option = readCookie('option')
		setTimeout("document.getElementById('loading').style.display='none';",1000);
	   } 
}

function ChangeValue(option, value, id, table)
{

	// 31.10.2006 added table var in order to change values in different sections (tables)
	
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
	alert ("Browser does not support HTTP Request")
	return
	}

	var url="/mad/"+table+"/changevalue/"+id
	url=url+"?"+option+"="+value
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("POST",url,true)
	xmlHttp.send()
	document.getElementById("loading").style.display="block"

} 

function MassChangeValue(table, column, value)
{

	xmlHttp=GetXmlHttpObject()

	if (value.length==0)
		{ 
			alert("Changed")
			return
		}
			xmlHttp=GetXmlHttpObject()
			if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request")
			return
		}

	var url="/mad/pages/changecolumns/?"
	url=url+column+"="+value
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("POST",url,true)
	xmlHttp.send()
	document.getElementById("loading").style.display="block"

}

function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	  {
	  objXMLHttp=new XMLHttpRequest()
	  }
	else if (window.ActiveXObject)
	  {
	  objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	  }
	return objXMLHttp
} 



function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e != null) {
	if(e.style.display == 'none') {
	e.style.display = 'block';
	} else {
	e.style.display = 'none';
	}
	}
}

var checkflag = "false";

function setCheckboxesByType(do_check) {
    var elts = document.getElementsByTagName("input");
    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;
 if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            if (elts[i].type == "checkbox") {
                elts[i].checked = do_check;
            }
        } 
    } else {
        if (elts.type == "checkbox") {
            elts.checked = do_check;
        }
    }
}

function ShowSelectTagFor(option, id) {
	document.getElementById(option+ "select" +id).style.display= 'block';
	document.getElementById(option+id).style.display= 'none';
}


function ClipBoard(url,name) {
	url = '<a href="'+url+'">'+name+'</a>'
	clipboardData.setData('Text',url); 
}

function ShowChangeForm(id) {
	document.getElementById("priority"+id).style.display = "none";
	document.getElementById("prioritychangeform"+id).style.display = "block";
}

function MakeChanesAndSave(table,id,value,section) {
	ChangeValue(table,value,id,section);
	document.getElementById("prioritychangeform"+id).style.display = "none";
	document.getElementById("priority"+id).style.display = "block";
	document.getElementById("priority"+id).innerHTML = value	
}

function MakeChanesAndSaveCheckBox(table,id,value,section,cb) {

	cb.checked ? value=1 : value=0
	ChangeValue(table,value,id,section);

/* 	document.getElementById("prioritychangeform"+id).style.display = "none";
	document.getElementById("priority"+id).style.display = "block";
	document.getElementById("priority"+id).innerHTML = value	*/
}

function id(x)
{
    return document.getElementById(x);
}



// Выполнение запроса AJAX
function RunAJAX(url) {

	url=url+"&sid="+Math.random()

	// alert(url)

	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("POST",url,true)
	xmlHttp.send()

}

function insertCurrDate(timestampa) {
	id("labeltimestamp").value = timestampa
}

function ChangeValueOfFormElement(val) {

	document.forms[0].sql.value = val

}


// 15.11.2009
function setOurLink(linkID) {
	
	var myCars=new Array("http://www.ifstudio-translations.com","http://www.1translate.com");

	document.forms[0].ourlink.value = myCars[linkID];

}


// 15.11.2009
function ChangeHiddenFieldValue(fieldon) {

	if (document.getElementById('label'+fieldon).value == 0)
	{
		document.getElementById('label'+fieldon).value = 1
	}
		else document.getElementById('label'+fieldon).value = 0

}