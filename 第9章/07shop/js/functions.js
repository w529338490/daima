//您好
// -------------------------
// JavaScript?Cookies???
// -------------------------
// ??Cookie
function saveCookie(name, value, expires, path, domain, secure){
  var strCookie = name + "=" + value;
  if (expires){
     // ??Cookie???, ?????
     var curTime = new Date();
     curTime.setTime(curTime.getTime() + expires*24*60*60*1000);
     strCookie += "; expires=" + curTime.toGMTString();
  }
  // Cookie???
  strCookie +=  (path) ? "; path=" + path : ""; 
  // Cookie?Domain
  strCookie +=  (domain) ? "; domain=" + domain : "";
  // ????????,??????
  strCookie +=  (secure) ? "; secure" : "";
  document.cookie = strCookie;
}
// ????????Cookie?, null??Cookie???
function getCookie(name){
  var strCookies = document.cookie;
  var cookieName = name + "=";  // Cookie??
  var valueBegin, valueEnd, value;
  // ??????Cookie??
  valueBegin = strCookies.indexOf(cookieName);
  if (valueBegin == -1) return null;  // ???Cookie
  // ????????
  valueEnd = strCookies.indexOf(";", valueBegin);
  if (valueEnd == -1)
      valueEnd = strCookies.length;  // ????Cookie
  // ??Cookie?
  value = strCookies.substring(valueBegin+cookieName.length,valueEnd);
  return value;
}
// ??Cookie????
function checkCookieExist(name){
  if (getCookie(name))
      return true;
  else
      return false;
}
// ??Cookie
function deleteCookie(name, path, domain){
  var strCookie;
  // ??Cookie????
  if (checkCookieExist(name)){
    // ??Cookie???????
    strCookie = name + "="; 
    strCookie += (path) ? "; path=" + path : "";
    strCookie += (domain) ? "; domain=" + domain : "";
    strCookie += "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    document.cookie = strCookie;
  }
}
