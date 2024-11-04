function getUrlParam(name) {
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(window.location.href);
	if( results == null )
		return "";
	else
		return results[1];
}

function setCookie(cname, cvalue, exdays, domain, path) {
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ";domain=" + domain + ";path=" + path;
}

function getCookie(c_name){
    var i, x, y, ARRcookies = document.cookie.split(";");
    for(i=0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if(x == c_name) {
            return decodeURIComponent(y);
        }
    }

    return null;
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if(typeof window.onload != 'function') {
		window.onload = func;
	}
	else {
		window.onload = function() {
			if(oldonload) {
				oldonload();
			}
			func();
		}
	}
}

function openWindows(w, h, url) {
	var popupWidth = w;
	var popupHeight = h;
	var xPosition = ($(window).width() - popupWidth)/2;
	var yPosition = ($(window).height() - popupHeight)/2;
	
	facebookLoginWindow = window.open(url, "dialog", 
		"location=1,scrollbars=1," +
		"width=" + popupWidth + ",height=" + popupHeight + "," +
		"left=" + xPosition + ",top=" + yPosition);
}