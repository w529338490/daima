function isInteger(src) {
	reg = /^(-|\+)?\d+$/;
    return (reg.test(src));//整数
}

function isIntegerPlus(src) {
	reg = /^\d+$/;
    return (reg.test(src));
}

function isIntegerMiner(src) {
	reg = /^-\d+$/;
    return (reg.test(src));
}

function isMoney(src) {
	reg = /^\d+\.\d{2}$/;
    return (reg.test(src));
}

function isFloat(src) {
	reg = /^\d+\.\d{2}$/;
    return (reg.test(src));
}

function isAge(src) {
	reg  = /^(1[0-2]\d|\d{1,2})$/;  
    return (reg.test(src));
}

function isPhone(src) {
	reg = /^(\+\d+ )?(\(\d+\) )?[\d ]+$/; 
    return (reg.test(src));
}

function isName(src) {
	reg = /^[A-Za-z\-]+$/;  
    return (reg.test(src));
}

function isEmail(src) {
	isEmail1    = /^\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w+$/;
	isEmail2    = /^.*@[^_]*$/;
    return (isEmail1.test(src) && isEmail2.test(src));
}


function isPsw(src) {
	 var sxf,regex;
	 sxf='^[\\w]{6,12}$';
  	 regex=new RegExp(sxf);
  	 return regex.test(src);
}

function isZipCode(src) {
	 var ZipCode,regex;
  	 ZipCode="^[\\d]{6}$";
 	 regex=new RegExp(ZipCode);
 	 return regex.test(src);
}


function isZip(str)
{
 var reg = /^\d{6}$/;
 return reg.test(str);
}


function isMobile(str)
{
 var reg = /^\d{11,12}$/;
 return  reg.test(str);
}


function isNum15(str)
{
  var reg=/^\d{15}$/;
  return reg.test(str);
}


function isNum18(str)
{
  var reg=/^\d{17}(?:\d|x)$/;
  return reg.test(str);
}

function isIdentity(src) {
   	isIdCorrect1=/^\d{15}$/;
  	isIdCorrect2=/^\d{18}$/;
	if(isIdCorrect1.test(src)||isIdCorrect2.test(src))
       return true;
	 false;
}

function isTime(str)
{
    var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);
    if (a == null) {alert(''); return false;}
    if (a[1]>24 || a[3]>60 || a[4]>60)
    {
          alert("");
          return false
    }
    return true;
}

function isDateTime(str)
{
 	var r = str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/); 
	if(r==null)return false; 
	var d= new Date(r[1], r[3]-1, r[4]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]);
}

 function isDateLongTime(str)
{
    var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/; 
    var r = str.match(reg); 
    if(r==null)return false; 
    var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]); 
    return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]&&d.getSeconds()==r[7]);
}

function isChar(src) {
	reg = /[^a-zA-Z]/;
    return (reg.test(src));
}

function isCharNum(src) {
	reg = /[^0-9a-zA-Z]/;
    return (reg.test(src));
}

function isCharVar(src) {
	reg = /^([a-zA-z_]{1})([\w]*)$/;
    return (reg.test(src));
}

function isFileExtension(filePath){
 var temp;
 var ExtList = ".mp3.swf.wma.rm.mpg.avi.mpeg.wmv";
 var the_ext = filePath.substr(filePath.lastIndexOf(".")+1).toLowerCase();
 if (ExtList.indexOf(the_ext)==-1){
  return false;
 }
 return true;
}

function isPictreExtension(filePath){
 var temp;
 var ExtList = ".jpg.gif.bmp.png";
 var the_ext = filePath.substr(filePath.lastIndexOf(".")+1).toLowerCase();
 if (ExtList.indexOf(the_ext)==-1){
  return false;
 }
 return true;
}

function isWebsites(strEmail) { 
  var myReg = /^(http:\/\/[a-z0-9]{1,5}\.)+([-\/a-z0-9]+\.)+[a-z0-9]{2,4}$/;
  if(myReg.test(strEmail)) return true; 
  return false; 
  
}


function makeslug(str)
{
	return str.replace(/ /g,"-");
}

function NoticeOpen(url)
{
	open(url,'win','scrollbars=yes,width=600,height=500,resizable=no,left=200,top=100,resizable=false');
}

function getDays()
{
	var daysArray=Array();
	for(i=1;i<=31;i++)
		daysArray[i-1]=i;
	return daysArray;
}
function getMonths()
{
	var monthsArray=Array("01","02","03","04","05","06","07","08","09","10","11","12");
	return monthsArray;
}

function getYears()
{
	var yearsArray=Array();
	j=0;
	for(i=1970;i<=1995;i++)
	{
		yearsArray[j]=i;
		j++;
	}
	return yearsArray;
}
