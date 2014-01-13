// get element of page by id (cross-browser)
function elementById(Name) {
	if(navigator.appName.indexOf("Microsoft")!=-1) {
	// IE
		if(!eval('document.all("'+Name+'")')) return 0; else return document.all(Name);
  	}
  	else {
	// NN & others
    		if(!eval('document.'+Name))  {
			if (document.getElementById) {
				return eval('document.getElementById("'+Name+'")');
			} else
			return 0;
    		}
    		else
		return eval('document.'+Name);
	}
}
// set element property (cross-browser)
function setProp(Name, Param, Val) {
    		if(!eval('document.'+Name))  {
			if (document.getElementById) {
				eval('document.getElementById("'+Name+'").style.'+Param+'='+Val);
			} else
			return 0;
    		}
    		else
		eval('document.'+Name+'.'+Param+'='+Val);
}
// get element property (cross-browser)
function getProp(Name, Param) {
    		if(!eval('document.'+Name))  {
			if (document.getElementById) {
				return eval('document.getElementById("'+Name+'").style.'+Param);
			} else
			return 0;
    		}
    		else
		return eval('document.'+Name+'.'+Param);
}
// for admin
function pclick(s)
{
	var state = (getProp('cb'+s, 'display')=='none') ? "''" : "'none'";
	var i = elementById('ci'+s);
	setProp('cb'+s, 'display', state);
		x = i.src;
	if (x.search('_down')!=-1)
		i.src = urlToImg + 'images/catitem.gif';
	else
		i.src = urlToImg + 'images/catitem_down.gif';
}
// open url in new window
function openUrl(s) 
{
	window.open(s);
}
 // send mail
function sendMail(a, b) 
{
	location.href = 'mai'+'lto'+':'+a+'@'+b;
}
// toggle stylesheet
function toggleStylesheet(anchor1, anchor2)
{
	var objToggle = elementById('togglestyle');
	var cssScreen = elementById('screenstyle');
	var cssPrint = elementById('printstyle');
	if (cssScreen.href!=cssPrint.href)
	{
		mainstylehref=cssScreen.href;
		cssScreen.href=cssPrint.href;
		objToggle.innerHTML = anchor2;
	} 
	else 
	{
		cssScreen.href=mainstylehref;
		objToggle.innerHTML = anchor1;
	}
	objToggle.blur();
}
// detect flash version
function flashVersion()
{
    if (!navigator.f)
    {
    	navigator.f = '0';
    }
	var plugin = 0;

	plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;

	if (plugin)
	{
		navigator.f = parseInt(plugin.description.substring(plugin.description.indexOf(".")-1));
	}
	else    
	    if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0 && (navigator.userAgent.indexOf("Windows 95")>=0 || navigator.userAgent.indexOf("Windows NT")>=0 || navigator.userAgent.indexOf("Windows 98")>=0 || navigator.userAgent.indexOf("Windows XP")>=0))
	    {
	        navigator.f = '0';
	        document.write('<SCRIPT LANGUAGE=VBScript>\n');
	        document.write(' FlashMode = false\n');
	        document.write(' on error resume next\n');
	        document.write(' FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.8"))\n');
	        document.write(' If FlashMode = True Then\n');
	        document.write('    navigator.f = "8"\n');
	        document.write(' Else\n');
	        document.write('    FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.7"))\n');
	        document.write('    If FlashMode = True Then\n');
	        document.write('        navigator.f = "7"\n');
	        document.write('    Else\n');
	        document.write('        FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.6"))\n');
	        document.write('        If FlashMode = True Then\n');
	        document.write('            navigator.f = "6"\n');
	        document.write('        Else\n');
	        document.write('            FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.5"))\n');
	        document.write('            If FlashMode = True Then\n');
	        document.write('                navigator.f = "5"\n');
	        document.write('            Else\n');
	        document.write('                FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.4"))\n');
	        document.write('                If FlashMode = True Then\n');
	        document.write('                    navigator.f = "4"\n');
	        document.write('                Else\n');
	        document.write('                    FlashMode = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.3"))\n');
	        document.write('                    If FlashMode = True Then\n');
	        document.write('                        navigator.f = "3"\n');
	        document.write('                    Else\n');
	        document.write('                        navigator.f = "0"\n');
	        document.write('                    End If\n');
	        document.write('                End If\n');
	        document.write('            End If\n');
	        document.write('        End If\n');
	        document.write('    End If\n');
	        document.write(' End If\n');
	        document.write('</SCRIPT>\n');
	    }
	    else
	    {
	        navigator.f = '0';
	    }

	return navigator.f;
}
//
function flashConditionWrite(IfFlash, IfNotFlash, NeedFlashVersion)
{
    var f;
    f = flashVersion();
	if (f >= NeedFlashVersion)
	{
		document.write(IfFlash);
	}
	else
	{
		document.write(IfNotFlash);
	}
}
// on resize handler
function getWindowWidth()
{
	var w = document.body.clientWidth;
	w = (w>971)?w:970;
	return w;
}
// goto home
function gotoHome()
{
	location.href = 'http://' + location.host;
}
// faq
function toggleAnswer(id)
{
	var state = (getProp('answer'+id, 'display')=='none') ? "''" : "'none'";
	setProp('answer'+id, 'display', state);
	elementById('arr'+id).innerHTML = (state=="''") ? '&darr;' : '&rarr;';
}