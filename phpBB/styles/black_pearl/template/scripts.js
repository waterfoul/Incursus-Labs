var PreloadFlag = false;
var expDays = 90;
var exp = new Date();
var tmp = '';
var tmp_counter = 0;
var tmp_open = 0;

exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function SetCookie(name, value)
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape(value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((path == null) ? "" : ("; path=" + path)) +
		((domain == null) ? "" : ("; domain=" + domain)) +
		((secure == true) ? "; secure" : "");
}

function getCookieVal(offset)
{
	var endstr = document.cookie.indexOf(";",offset);
	if (endstr == -1)
	{
		endstr = document.cookie.length;
	}
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name)
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen)
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
		{
			return getCookieVal(j);
		}
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
		{
			break;
		}
	}
	return null;
}

function ShowHide(id1, id2, id3)
{
	var res = expMenu(id1);
	if (id2 != '')
	{
		expMenu(id2);
	}
	if (id3 != '')
	{
		SetCookie(id3, res, exp);
	}
}

function expMenu(id)
{
	var itm = null;
	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm)
	{
		// do nothing
	}
	else if (itm.style)
	{
		if (itm.style.display == "none")
		{
			itm.style.display = "";
			return 1;
		}
		else
		{
			itm.style.display = "none";
			return 2;
		}
	}
	else
	{
		itm.visibility = "show";
		return 1;
	}
}

function showMenu(id)
{
	var itm = null;
	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm)
	{
		// do nothing
	}
	else if (itm.style)
	{
		if (itm.style.display == "none")
		{
			itm.style.display = "";
			return true;
		}
		else
		{
//			itm.style.display = "none";
			return true;
		}
	}
	else
	{
		itm.visibility = "show";
		return true;
	}
}

function hideMenu(id)
{
	var itm = null;
	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm)
	{
		// do nothing
	}
	else if (itm.style)
	{
		if (itm.style.display == "none")
		{
//			itm.style.display = "";
			return true;
		}
		else
		{
			itm.style.display = "none";
			return true;
		}
	}
	else
	{
		itm.visibility = "hide";
		return true;
	}
}

function IsIEMac()
{
	// Any better way to detect IEMac?
	var ua = String(navigator.userAgent).toLowerCase();
	if( document.all && ua.indexOf("mac") >= 0 )
	{
		return true;
	}
	return false;
}


function select_text(obj)
{
	var o = document.getElementById(obj)
	if( !o ) return;
	var r, s;
	if( document.selection && !IsIEMac() )
	{
		// Works on: IE5+
		// To be confirmed: IE4? / IEMac fails?
		r = document.body.createTextRange();
		r.moveToElementText(o);
		r.select();
	}
	else if( document.createRange && (document.getSelection || window.getSelection) )
	{
		// Works on: Netscape/Mozilla/Konqueror/Safari
		// To be confirmed: Konqueror/Safari use window.getSelection ?
		r = document.createRange();
		r.selectNodeContents(o);
		s = window.getSelection ? window.getSelection() : document.getSelection();
		s.removeAllRanges();
		s.addRange(r);
	}
}

function checkAPI(ident)
{
	getElementFromID(ident + "_check_return").innerHTML = "Checking....";
	xhr = getXmlHttp();
	xhr.ident = ident;
	xhr.onreadystatechange=function()
  	{
  		if (this.readyState==4 && this.status==200)
    	{
    		val = this.responseText.split(",");
    		if(val[0] == "BAD KEY OR VCODE")
    			getElementFromID(this.ident + "_check_return").innerHTML="Bad API Credentials, please retry";
    		else
    		{
    			if(val.contains("DEFCON 3"))
    				getElementFromID(this.ident + "_check_return").innerHTML="Incursion Community Verified Capable";
    			if(val.contains("DEFCON 2"))
    				getElementFromID(this.ident + "_check_return").innerHTML="Lowsec Community Capable";
    			if(val.contains("DEFCON 1"))
    				getElementFromID(this.ident + "_check_return").innerHTML="Corporation Capable";
    			if(val.contains("SKILLS"))
    				getElementFromID(this.ident + "_check_return").innerHTML+=", Skill Features Enabled";
    			if(val.contains("STANDINGS"))
    				getElementFromID(this.ident + "_check_return").innerHTML+=", Standings Features Enabled";
    		}
    	}
 	}
	xhr.open("GET","../apiSync/APIkey.php?eveAPIgrab=STATUS&key=" + getElementFromID(ident + "_key").value + "&vcode=" + getElementFromID(ident + "_vcode").value,true);
	xhr.send();
}

function resetApiLevel(ident)
{
	getElementFromID(ident + "_level").selectedIndex = 0;
	getElementFromID(ident + "_level").disabled = true;
}

function getElementFromID(id)
{
	 var itm = null;
	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	return itm;
}

function getXmlHttp(){
	var xmlhttp;
    if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	return xmlhttp;
}

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}
