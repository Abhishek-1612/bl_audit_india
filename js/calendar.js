// CodeThatCalendar STANDARD
// Version: 2.0.1 (04.06.2005.1)
// THE SCRIPT IS FREE FOR NON-COMMERCIAL AND COMMERCIAL USE.
// Copyright (c) 2003-2005 by CodeThat.Com
// http://www.codethat.com/

function UA(){var t=this,nv=navigator,n=nv.userAgent.toLowerCase();t.win=n.indexOf('win')>=0;t.mac=n.indexOf('mac')>=0;t.DOM=document.getElementById?true:false;t.dynDOM=document.createElement&&document.addEventListener;t.khtml=nv.vendor=='KDE';var idx=n.indexOf('opera');t.opera=idx!=-1;if(t.opera){t.vers=parseFloat(n.substr(idx+6));t.major=Math.floor(t.vers);t.opera5=t.major==5;t.opera6=t.major==6;t.opera7=t.major==7;t.opera7up=t.vers>=7;}t.oldOpera=t.opera5||t.opera6;idx=n.indexOf('msie');if(idx>=0&&!t.opera&&!t.khtml){t.vers=parseFloat(n.substr(idx+5));t.ie3down=t.vers<4;t.ie=t.ie4up=document.all&&document.all.item&&!t.ie3down;t.ie5up=t.ie&&t.DOM;t.ie55up=t.ie&&t.vers>=5.5;t.ie6up=t.ie&&t.vers>=6}t.cm=document.compatMode;t.css1cm=t.cm=='CSS1Compat';t.nn4=nv.appName=="Netscape"&&!t.DOM&&!t.opera;if(t.nn4)t.vers=parseFloat(nv.appVersion);t.moz=t.nn6up=t.gecko=n.indexOf('gecko')!=-1;if(t.gecko)t.vers=parseFloat(n.substr(n.indexOf('rv:')+3));t.nn7up=t.gecko&&t.vers>1;t.hj=n.indexOf('hotjava')!=-1;t.aol=n.indexOf('aol')!=-1;t.aol4up=t.aol&&t.ie4up;t.major=Math.floor(t.vers);t.supp=t.supported=t.oldOpera||t.opera7up||t.ie||t.moz||t.nn4||t.DOM};function Undef(o){
    return typeof(o)=='undefined'||o===''||o==null};function Def(o){
    return!Undef(o)};var ua=new UA();function CodeThatSetMY(m,y,f){switch(f){case 0:{++m;if(m==12){m=0;y++;}break;}case 1:{--m;if(m==-1){m=11;y--;}break;}case 2:{++y;break;}case 3:{--y;break;}case 4:{break;}}if(!window.opener)window.opener=window.parent;var c;if(ua.moz&&ua.vers>=1.4){if(this.opener)c=this.opener.codethatcalendar;else c=this.parent.codethatcalendar;window.opener=this.parent;}else if(window.opener)c=window.opener.codethatcalendar;if(c){c.date.setFullYear(y);c.date.setMonth(m);}location.reload();};function CodeThatFind(d,f){if(d.getElementById&&Def(d.getElementById(f))){
    return d.getElementById(f);}else if(ua.ie4up){
    return d.all[f];}else{if(d.forms.item)for(var i=0;d.forms.item(i)!=null;++i){if(d.forms.item(i).namedItem&&d.forms.item(i).namedItem(f))
    return d.forms.item(i).namedItem(f);if(d.forms.item(i).elements&&d.forms.item(i).elements[f])
    return d.forms.item(i).elements[f];}for(var form in d.forms)if(d.forms[form].elements&&d.forms[form].elements[f])
    return d.forms[form].elements[f];}
    return null;};function CodeThatAlign(n){
    return n<10?("0"+n):(""+n);;};function CodeThatDateFormat(f,d,m,y){var s=f;d=d<10?("0"+d):d;s=s.replace("dd",d);m++;m=m<10?("0"+m):m;s=s.replace("MM",m);s=s.replace("yyyy",y);if(CodeThatFind(document,'time')){var t=CodeThatFind(document,'time').value;var hours=parseInt(t.substring(0,2)-0);if(hours<0||hours>23){hours=hours%24;hours+=(hours<0?24:0);}s=s.replace("HH",CodeThatAlign(hours));var minutes=parseInt(t.substring(3,5)-0);if(minutes<0||minutes>59){minutes=minutes%60;minutes+=(minutes<0?60:0);}s=s.replace("mm",CodeThatAlign(minutes));var seconds=parseInt(t.substring(6,8)-0);if(seconds<0||seconds>59){seconds=seconds%60;seconds+=(seconds<0?60:0);}s=s.replace("ss",CodeThatAlign(seconds));}
    return s;};function CodeThatSetDay(c,f,d,m,y,i,ifr){var doc;var w=window.opener||this.parent;if(w&&!i)doc=w.document;else doc=document;var e=CodeThatFind(doc,c);if(Def(e)){e.value=CodeThatDateFormat(f,d,m,y);if(e.onchange)e.onchange();}if(w&&!i){if(Def(w)&&Def(ifr)){var iframe=CodeThatFind(doc,ifr);if(Def(iframe))iframe.style.visibility='hidden';if(ua.opera6){var d=CodeThatFind(doc,"calendar_div");if(Def(d))d.style.visibility='hidden';}}else{window.close();}}};function CodeThatCalendar(def){this.def=def;this.links={};this.styles={};this.hideifr=true;};{var CTc=CodeThatCalendar.prototype;CTc.getCss=function(key,d){
    return "";};CTc.hide=function(){if(window.parent&&this.hideifr&&this.ifr){var iframe=CodeThatFind(window.parent.document,this.ifr);if(iframe)iframe.style.visibility='hidden';}};CTc.create=function(d,ctl){var i=false;this.i=i;if(!this.date)this.date=window.date||new Date();var def=this.def;var acts='';if(this.ifr&&def.headerstyle.type!="comboboxes"){acts='onMouseOver="window.parent.codethatcalendar.hideifr=false;"';acts+=" onMouseOut=\"window.parent.codethatcalendar.hideifr=true;setTimeout('window.parent.codethatcalendar.hide();',1000);\""}d.write("<table "+(Def(this.ifr)?"align=\"center\"":"")+" cellspacing=0 cellpadding=0 "+acts+" width="+def.width+" border="+(def.border_width||0)+" bordercolor='"+(def.border_color||'#000000')+"'>");d.write("<tr>");if(i)this.createButtons(d,i);else{if(def.headerstyle.type=="buttons")this.createButtons(d,i);else if(def.headerstyle.type=="comboboxes")this.createCombos(d);}d.write("</tr>");var day=0;d.write("<tr>");this.createWeekdays(d);d.write("</tr>");var w=this.createMonth(d);if(def.showtime){this.createTime(d);}if(ua.opera&&w==4){d.write("<tr><td colspan=7>&nbsp;<td></tr>");}d.write("</table>");};CTc.createTime=function(d){d.write("<tr><td colspan=7 align=center>"+(ua.nn4?"<form>":"")+"<input "+(ua.nn4?"name":"id")+"='time' type=textarea value='"+CodeThatAlign(this.date.getHours())+":"+CodeThatAlign(this.date.getMinutes())+":"+CodeThatAlign(this.date.getSeconds())+"'>"+(ua.nn4?"</form>":"")+"</td></tr>");};CTc.createMonth=function(d){var cd=this.date.getDate();var cm=this.date.getMonth();var cy=this.date.getYear();var cday=this.date.getDay();var def=this.def;var cur_day=1;this.date.setDate(cur_day);var thisweek=false;var start=(this.date.getDay()-def.firstday);start+=(start<0?7:0);cur_day-=start;var css,thismonth=false,weekend,thisday;var w;for(w=0;w<6;++w){d.write("<tr>");for(var day=0;day<7;++day){weekend=day+def.firstday;weekend-=(weekend<7?0:7);weekend=weekend==0||weekend==6;this.date.setDate(cur_day);if(this.date.getDate()==1)thismonth=!thismonth;if(day==0){if(w!=0){thisweek=cd-this.date.getDate();if(thisweek<7&&thisweek>=0)thisweek=true;else thisweek=false;}else thisweek=(start+cd)<8;}if(day==7&&thisweek)thisweek=false;thisday=this.date.getDate()==cd&&thismonth;css=thisday?"cd_css":(thisweek?"tw_css":(thismonth?(weekend?"we_css":"wd_css"):(weekend?"weom_css":"wdom_css")));d.write("<td align=center width=14% "+this.getCss(css)+"><A "+this.getCss(css)+this.getRef()+">");d.write(this.date.getDate());d.write("</A></td>");cur_day=this.date.getDate()+1;}d.write("</tr>");this.date.setDate(cur_day);if(this.date.getDate()<8&&w>3)break;}this.date.setDate(cd);this.date.setMonth(cm);this.date.setYear(cy);
    return w;};CTc.setLink=function(s,l){this.links[s]=l;};CTc.setStyle=function(s,l){this.styles[s]=l;};CTc.getStyle=function(){var c;if(this.i){var fd=CodeThatDateFormat(this.def.dtype,this.date.getDate(),this.date.getMonth(),this.date.getFullYear());if(this.styles[fd])c=this.styles[fd];}
    return c;};CTc.getRef=function(){var ref;if(this.i){var fd=CodeThatDateFormat(this.def.dtype,this.date.getDate(),this.date.getMonth(),this.date.getFullYear());if(this.links[fd])ref=" href='"+this.links[fd]+"'";}ref=ref||(" href='javascript:CodeThatSetDay(\""+this.ctl+"\",\""+this.def.dtype+"\","+this.date.getDate()+","+this.date.getMonth()+","+this.date.getFullYear()+","+this.i+",\""+(Def(this.ifr)?this.ifr:"")+"\")'");
    return ref;};CTc.createWeekdays=function(d){var def=this.def;var weekend;for(var day=0;day<7;++day){weekend=day+def.firstday;weekend-=(weekend<7?0:7);d.write("<td align=center "+this.getCss("dn_css")+">"+def.daynames[weekend]+"</td>");}};CTc.createButtons=function(d,i){var col=9,dh=this.def.headerstyle;for(var p in dh)--col;if(dh.imgprevy&&!i)d.write("<td width=14% align=left><a href='javascript:CodeThatSetMY("+this.date.getMonth()+","+this.date.getFullYear()+",3)'><IMG border=0 src='"+dh.imgprevy+"'</IMG></A>");if(dh.imgprevm&&!i)d.write("<td width=14% align=left><a href='javascript:CodeThatSetMY("+this.date.getMonth()+","+this.date.getFullYear()+",1)'><IMG border=0 src='"+dh.imgprevm+"'</IMG></A>");d.write("<td colspan="+col+" align=center "+this.getCss("css",dh)+">"+this.def.monthnames[this.date.getMonth()]+"&nbsp;"+this.date.getFullYear()+"</td>");if(dh.imgnextm&&!i)d.write("<td width=14% align=right><a href='javascript:CodeThatSetMY("+this.date.getMonth()+","+this.date.getFullYear()+",0)'><IMG border=0 src='"+dh.imgnextm+"'</IMG></A></td>");if(dh.imgnexty&&!i)d.write("<td width=14% align=right><a href='javascript:CodeThatSetMY("+this.date.getMonth()+","+this.date.getFullYear()+",2)'><IMG border=0 src='"+dh.imgnexty+"'</IMG></A></td>");};CTc.createCombos=function(d,l){var dh=this.def.headerstyle;d.write("<td colspan=7 "+this.getCss("css",dh)+">");if(ua.nn4)d.write("<form>");d.write("<select align=left "+this.getCss("css",dh)+" "+(ua.nn4?"name":"id")+"='month' onchange='CodeThatSetMY(CodeThatFind(document,\"month\").selectedIndex,"+dh.yearrange[0]+"+CodeThatFind(document,\"year\").selectedIndex,4);'>");var i=0;for(;i<12;++i)d.write("<option "+(i==this.date.getMonth()?"selected='selected'":"")+" value='"+i+"'>"+this.def.monthnames[i]+"</option>");d.write("</select>");d.write("<select align=right "+this.getCss("css",dh)+" "+(ua.nn4?"name":"id")+"='year' onchange='CodeThatSetMY(CodeThatFind(document,\"month\").selectedIndex,"+dh.yearrange[0]+"+CodeThatFind(document,\"year\").selectedIndex,4);'>");for(i=dh.yearrange[0];i<=dh.yearrange[1];++i)d.write("<option "+(i==this.date.getFullYear()?"selected='selected'":"")+" value='"+i+"'>"+i+"</option>");d.write("</select>");if(ua.nn4)d.write("</form>");d.write("</td>");};CTc.parseValue=function(s,d){var f=this.def.dtype;d=d||this.date;var t;if(f.indexOf("yyyy")!=-1){t=parseInt(s.substr(f.indexOf("yyyy"),4)-0);if(!isNaN(t)&&typeof(t)!='undefined')d.setFullYear(t);}if(f.indexOf("MM")!=-1){t=parseInt(s.substr(f.indexOf("MM"),2)-1);if(!isNaN(t)&&typeof(t)!='undefined')d.setMonth(t);}if(f.indexOf("dd")!=-1){t=parseInt(s.substr(f.indexOf("dd"),2)-0);if(!isNaN(t)&&typeof(t)!='undefined')d.setDate(t);}if(f.indexOf("HH")!=-1){t=parseInt(s.substr(f.indexOf("HH"),2)-0);if(!isNaN(t)&&typeof(t)!='undefined')d.setHours(t);}if(f.indexOf("mm")!=-1){t=parseInt(s.substr(f.indexOf("mm"),2)-0);if(!isNaN(t)&&typeof(t)!='undefined')d.setMinutes(t);}if(f.indexOf("ss")!=-1){t=parseInt(s.substr(f.indexOf("ss"),2)-0);if(!isNaN(t)&&typeof(t)!='undefined')d.setSeconds(t);}};CTc.popup=function(ctl){window.codethatcalendar=this;this.ctl=ctl;var e=CodeThatFind(document,ctl);this.date=new Date();if(e.value!="")this.parseValue(e.value);var w=window.open("calendar.html","",'width='+this.def.windoww+',height='+this.def.windowh+',status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');w.opener=window;w.focus();};CTc.innerpopup=function(ctl,ifr){window.codethatcalendar=this;this.ctl=ctl;this.ifr=ifr;this.hideifr=false;var e=CodeThatFind(document,ctl);this.date=new Date();if(e.value!="")this.parseValue(e.value);var w=CodeThatFind(document,ifr);if(ua.oldOpera){w=document.frames[ifr];w.location.reload();var d=CodeThatFind(document,"calendar_div");d.style.visibility='visible';}else{w.src="codethatcalendar_ifr.html";w.style.visibility='visible';}w.opener=window;w.height=this.def.windowh;w.width=this.def.windoww;if(ua.moz){}else{w.focus();}};}
    
    var turnOffYearSpan = false;     
    var weekStartsOnSunday = false;  
    var showWeekNumber = true; 
    
    var languageCode = 'en';	
                                
    
    var calendar_display_time = true;
    
    var formname='';
    
    
    
    var todayStringFormat = '[todayString] [UCFdayString]. [day]. [monthString] [year]';
    var pathToImages = '/images/calender/';	
    
    var speedOfSelectBoxSliding = 200;	
    var intervalSelectBox_minutes = 5;	
    
    var calendar_offsetTop = 0;		
    var calendar_offsetLeft = 0;	
    var calendarDiv = false;
    
    var MSIE = false;
    var Opera = false;
    if(navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('Opera')<0)MSIE=true;
    if(navigator.userAgent.indexOf('Opera')>=0)Opera=true;
    
    
    switch(languageCode){
        case "en":	/* English */
            var monthArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            var monthArrayShort = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
            var dayArray = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    var weekString = 'Week';
            var todayString = '';
            break;
        
    }
    
    if (weekStartsOnSunday) {
       var tempDayName = dayArray[6];
       for(var theIx = 6; theIx > 0; theIx--) {
          dayArray[theIx] = dayArray[theIx-1];
       }
       dayArray[0] = tempDayName;
    }
    
    
    
    var daysInMonthArray = [31,28,31,30,31,30,31,31,30,31,30,31];
    var currentMonth;
    var currentYear;
    var currentHour;
    var currentMinute;
    var calendarContentDiv;
    var returnDateTo;
    var returnFormat;
    var activeSelectBoxMonth;
    var activeSelectBoxYear;
    var activeSelectBoxHour;
    var activeSelectBoxMinute;
    
    var iframeObj = false;
    //// fix for EI frame problem on time dropdowns 09/30/2006
    var iframeObj2 =false;
    function EIS_FIX_EI1(where2fixit)
    {
    
            if(!iframeObj2)return;
            iframeObj2.style.display = 'block';
            iframeObj2.style.height =document.getElementById(where2fixit).offsetHeight+1;
            iframeObj2.style.width=document.getElementById(where2fixit).offsetWidth;
            iframeObj2.style.left=getleftPos(document.getElementById(where2fixit))+1-calendar_offsetLeft;
            iframeObj2.style.top=getTopPos(document.getElementById(where2fixit))-document.getElementById(where2fixit).offsetHeight-calendar_offsetTop;
    }
    
    function EIS_Hide_Frame()
    {		if(iframeObj2)iframeObj2.style.display = 'none';}
    //// fix for EI frame problem on time dropdowns 09/30/2006
    var returnDateToYear;
    var returnDateToMonth;
    var returnDateToDay;
    var returnDateToHour;
    var returnDateToMinute;
    
    var inputYear;
    var inputMonth;
    var inputDay;
    var inputHour;
    var inputMinute;
    var calendarDisplayTime = false;
    
    var selectBoxHighlightColor = '#D60808'; // Highlight color of select boxes
    var selectBoxRolloverBgColor = '#E2EBED'; // Background color on drop down lists(rollover)
    
    var selectBoxMovementInProgress = false;
    var activeSelectBox = false;
    
    function cancelCalendarEvent()
    {
        return false;
    }
    function isLeapYear(inputYear)
    {
        if(inputYear%400==0||(inputYear%4==0&&inputYear%100!=0)) return true;
        return false;
    
    }
    var activeSelectBoxMonth = false;
    var activeSelectBoxDirection = false;
    
    function highlightMonthYear()
    {
        if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
        activeSelectBox = this;
    
    
        if(this.className=='monthYearActive'){
            this.className='';
        }else{
            this.className = 'monthYearActive';
            activeSelectBoxMonth = this;
        }
    
        if(this.innerHTML.indexOf('-')>=0 || this.innerHTML.indexOf('+')>=0){
            if(this.className=='monthYearActive')
                selectBoxMovementInProgress = true;
            else
                selectBoxMovementInProgress = false;
            if(this.innerHTML.indexOf('-')>=0)activeSelectBoxDirection = -1; else activeSelectBoxDirection = 1;
    
        }else selectBoxMovementInProgress = false;
    
    }
    
    function showMonthDropDown()
    {
        if(document.getElementById('monthDropDown').style.display=='block'){
            document.getElementById('monthDropDown').style.display='none';
            //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        }else{
            document.getElementById('monthDropDown').style.display='block';
            document.getElementById('yearDropDown').style.display='none';
            document.getElementById('hourDropDown').style.display='none';
            document.getElementById('minuteDropDown').style.display='none';
                if (MSIE)
            { EIS_FIX_EI1('monthDropDown')}
            //// fix for EI frame problem on time dropdowns 09/30/2006
    
        }
    }
    
    function showYearDropDown()
    {
        if(document.getElementById('yearDropDown').style.display=='block'){
            document.getElementById('yearDropDown').style.display='none';
            //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        }else{
            document.getElementById('yearDropDown').style.display='block';
            document.getElementById('monthDropDown').style.display='none';
            document.getElementById('hourDropDown').style.display='none';
            document.getElementById('minuteDropDown').style.display='none';
                if (MSIE)
            { EIS_FIX_EI1('yearDropDown')}
            //// fix for EI frame problem on time dropdowns 09/30/2006
    
        }
    
    }
    function showHourDropDown()
    {
        if(document.getElementById('hourDropDown').style.display=='block'){
            document.getElementById('hourDropDown').style.display='none';
            //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        }else{
            document.getElementById('hourDropDown').style.display='block';
            document.getElementById('monthDropDown').style.display='none';
            document.getElementById('yearDropDown').style.display='none';
            document.getElementById('minuteDropDown').style.display='none';
                    if (MSIE)
            { EIS_FIX_EI1('hourDropDown')}
            //// fix for EI frame problem on time dropdowns 09/30/2006
        }
    
    }
    function showMinuteDropDown()
    {
        if(document.getElementById('minuteDropDown').style.display=='block'){
            document.getElementById('minuteDropDown').style.display='none';
            //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        }else{
            document.getElementById('minuteDropDown').style.display='block';
            document.getElementById('monthDropDown').style.display='none';
            document.getElementById('yearDropDown').style.display='none';
            document.getElementById('hourDropDown').style.display='none';
                    if (MSIE)
            { EIS_FIX_EI1('minuteDropDown')}
            //// fix for EI frame problem on time dropdowns 09/30/2006
        }
    
    }
    
    function selectMonth()
    {
        document.getElementById('calendar_month_txt').innerHTML = this.innerHTML
        currentMonth = this.id.replace(/[^\d]/g,'');
    
        document.getElementById('monthDropDown').style.display='none';
        //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        for(var no=0;no<monthArray.length;no++){
            document.getElementById('monthDiv_'+no).style.color='';
        }
        this.style.color = selectBoxHighlightColor;
        activeSelectBoxMonth = this;
        writeCalendarContent();
    
    }
    
    function selectHour()
    {
        document.getElementById('calendar_hour_txt').innerHTML = this.innerHTML
        currentHour = this.innerHTML.replace(/[^\d]/g,'');
        document.getElementById('hourDropDown').style.display='none';
        //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        if(activeSelectBoxHour){
            activeSelectBoxHour.style.color='';
        }
        activeSelectBoxHour=this;
        this.style.color = selectBoxHighlightColor;
    }
    
    function selectMinute()
    {
        document.getElementById('calendar_minute_txt').innerHTML = this.innerHTML
        currentMinute = this.innerHTML.replace(/[^\d]/g,'');
        document.getElementById('minuteDropDown').style.display='none';
        //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        if(activeSelectBoxMinute){
            activeSelectBoxMinute.style.color='';
        }
        activeSelectBoxMinute=this;
        this.style.color = selectBoxHighlightColor;
    }
    
    
    function selectYear()
    {
        document.getElementById('calendar_year_txt').innerHTML = this.innerHTML
        currentYear = this.innerHTML.replace(/[^\d]/g,'');
        document.getElementById('yearDropDown').style.display='none';
        //// fix for EI frame problem on time dropdowns 09/30/2006
                    EIS_Hide_Frame();
        if(activeSelectBoxYear){
            activeSelectBoxYear.style.color='';
        }
        activeSelectBoxYear=this;
        this.style.color = selectBoxHighlightColor;
        writeCalendarContent();
    
    }
    
    function switchMonth()
    {
        if(this.src.indexOf('left')>=0){
            currentMonth=currentMonth-1;;
            if(currentMonth<0){
                currentMonth=11;
                currentYear=currentYear-1;
            }
        }else{
            currentMonth=currentMonth+1;;
            if(currentMonth>11){
                currentMonth=0;
                currentYear=currentYear/1+1;
            }
        }
    
        writeCalendarContent();
    
    
    }
    
    function createMonthDiv(){
        var div = document.createElement('DIV');
        div.className='monthYearPicker';
        div.id = 'monthPicker';
    
        for(var no=0;no<monthArray.length;no++){
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = monthArray[no];
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = highlightMonthYear;
            subDiv.onclick = selectMonth;
            subDiv.id = 'monthDiv_' + no;
            subDiv.style.width = '56px';
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
            if(currentMonth && currentMonth==no){
                subDiv.style.color = selectBoxHighlightColor;
                activeSelectBoxMonth = subDiv;
            }
    
        }
        return div;
    
    }
    
    function changeSelectBoxYear(e,inputObj)
    {
        if(!inputObj)inputObj =this;
        var yearItems = inputObj.parentNode.getElementsByTagName('DIV');
        if(inputObj.innerHTML.indexOf('-')>=0){
            var startYear = yearItems[1].innerHTML/1 -1;
            if(activeSelectBoxYear){
                activeSelectBoxYear.style.color='';
            }
        }else{
            var startYear = yearItems[1].innerHTML/1 +1;
            if(activeSelectBoxYear){
                activeSelectBoxYear.style.color='';
    
            }
        }
    
        for(var no=1;no<yearItems.length-1;no++){
            yearItems[no].innerHTML = startYear+no-1;
            yearItems[no].id = 'yearDiv' + (startYear/1+no/1-1);
    
        }
        if(activeSelectBoxYear){
            activeSelectBoxYear.style.color='';
            if(document.getElementById('yearDiv'+currentYear)){
                activeSelectBoxYear = document.getElementById('yearDiv'+currentYear);
                activeSelectBoxYear.style.color=selectBoxHighlightColor;;
            }
        }
    }
    function changeSelectBoxHour(e,inputObj)
    {
        if(!inputObj)inputObj = this;
    
        var hourItems = inputObj.parentNode.getElementsByTagName('DIV');
        if(inputObj.innerHTML.indexOf('-')>=0){
            var startHour = hourItems[1].innerHTML/1 -1;
            if(startHour<0)startHour=0;
            if(activeSelectBoxHour){
                activeSelectBoxHour.style.color='';
            }
        }else{
            var startHour = hourItems[1].innerHTML/1 +1;
            if(startHour>14)startHour = 14;
            if(activeSelectBoxHour){
                activeSelectBoxHour.style.color='';
    
            }
        }
        var prefix = '';
        for(var no=1;no<hourItems.length-1;no++){
            if((startHour/1 + no/1) < 11)prefix = '0'; else prefix = '';
            hourItems[no].innerHTML = prefix + (startHour+no-1);
    
            hourItems[no].id = 'hourDiv' + (startHour/1+no/1-1);
    
        }
        if(activeSelectBoxHour){
            activeSelectBoxHour.style.color='';
            if(document.getElementById('hourDiv'+currentHour)){
                activeSelectBoxHour = document.getElementById('hourDiv'+currentHour);
                activeSelectBoxHour.style.color=selectBoxHighlightColor;;
            }
        }
    }
    
    function updateYearDiv()
    {
        var yearSpan = 5;
        if (turnOffYearSpan) {
           yearSpan = 0;
        }
        var div = document.getElementById('yearDropDown');
        var yearItems = div.getElementsByTagName('DIV');
        for(var no=1;no<yearItems.length-1;no++){
            yearItems[no].innerHTML = currentYear/1 -yearSpan + no;
            if(currentYear==(currentYear/1 -yearSpan + no)){
                yearItems[no].style.color = selectBoxHighlightColor;
                activeSelectBoxYear = yearItems[no];
            }else{
                yearItems[no].style.color = '';
            }
        }
    }
    
    function updateMonthDiv()
    {
        for(no=0;no<12;no++){
            document.getElementById('monthDiv_' + no).style.color = '';
        }
        document.getElementById('monthDiv_' + currentMonth).style.color = selectBoxHighlightColor;
        activeSelectBoxMonth = 	document.getElementById('monthDiv_' + currentMonth);
    
    }
    
    
    function updateHourDiv()
    {
        var div = document.getElementById('hourDropDown');
        var hourItems = div.getElementsByTagName('DIV');
    
        var addHours = 0;
        if((currentHour/1 -6 + 1)<0){
            addHours = 	(currentHour/1 -6 + 1)*-1;
        }
        for(var no=1;no<hourItems.length-1;no++){
            var prefix='';
            if((currentHour/1 -6 + no + addHours) < 10)prefix='0';
            hourItems[no].innerHTML = prefix +  (currentHour/1 -6 + no + addHours);
            if(currentHour==(currentHour/1 -6 + no)){
                hourItems[no].style.color = selectBoxHighlightColor;
                activeSelectBoxHour = hourItems[no];
            }else{
                hourItems[no].style.color = '';
            }
        }
    }
    
    function updateMinuteDiv()
    {
        for(no=0;no<60;no+=intervalSelectBox_minutes){
            var prefix = '';
            if(no<10)prefix = '0';
    
            document.getElementById('minuteDiv_' + prefix + no).style.color = '';
        }
        if(document.getElementById('minuteDiv_' + currentMinute)){
            document.getElementById('minuteDiv_' + currentMinute).style.color = selectBoxHighlightColor;
            activeSelectBoxMinute = document.getElementById('minuteDiv_' + currentMinute);
        }
    }
    
    
    
    function createYearDiv()
    {
    
        if(!document.getElementById('yearDropDown')){
            var div = document.createElement('DIV');
            div.className='monthYearPicker';
        }else{
            var div = document.getElementById('yearDropDown');
            var subDivs = div.getElementsByTagName('DIV');
            for(var no=0;no<subDivs.length;no++){
                subDivs[no].parentNode.removeChild(subDivs[no]);
            }
        }
    
    
        var d = new Date();
        if(currentYear){
            d.setFullYear(currentYear);
        }
    
        var startYear = d.getFullYear()/1 - 5;
    
        var yearSpan = 10;
        if (! turnOffYearSpan) {
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = '&nbsp;&nbsp;- ';
            subDiv.onclick = changeSelectBoxYear;
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
        } else {
           startYear = d.getFullYear()/1 - 0;
           yearSpan = 2;
        }
    
        for(var no=startYear;no<(startYear+yearSpan);no++){
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = no;
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = highlightMonthYear;
            subDiv.onclick = selectYear;
            subDiv.id = 'yearDiv' + no;
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
            if(currentYear && currentYear==no){
                subDiv.style.color = selectBoxHighlightColor;
                activeSelectBoxYear = subDiv;
            }
        }
        if (! turnOffYearSpan) {
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = '&nbsp;&nbsp;+ ';
            subDiv.onclick = changeSelectBoxYear;
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
        }
        return div;
    }
    
    /* This function creates the hour div at the bottom bar */
    
    function slideCalendarSelectBox()
    {
        if(selectBoxMovementInProgress){
            if(activeSelectBox.parentNode.id=='hourDropDown'){
                changeSelectBoxHour(false,activeSelectBox);
            }
            if(activeSelectBox.parentNode.id=='yearDropDown'){
                changeSelectBoxYear(false,activeSelectBox);
            }
    
        }
        setTimeout('slideCalendarSelectBox()',speedOfSelectBoxSliding);
    
    }
    
    function createHourDiv()
    {
        if(!document.getElementById('hourDropDown')){
            var div = document.createElement('DIV');
            div.className='monthYearPicker';
        }else{
            var div = document.getElementById('hourDropDown');
            var subDivs = div.getElementsByTagName('DIV');
            for(var no=0;no<subDivs.length;no++){
                subDivs[no].parentNode.removeChild(subDivs[no]);
            }
        }
    
        if(!currentHour)currentHour=0;
        var startHour = currentHour/1;
        if(startHour>14)startHour=14;
    
        var subDiv = document.createElement('DIV');
        subDiv.innerHTML = '&nbsp;&nbsp;- ';
        subDiv.onclick = changeSelectBoxHour;
        subDiv.onmouseover = highlightMonthYear;
        subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
        subDiv.onselectstart = cancelCalendarEvent;
        div.appendChild(subDiv);
    
        for(var no=startHour;no<startHour+10;no++){
            var prefix = '';
            if(no/1<10)prefix='0';
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = prefix + no;
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = highlightMonthYear;
            subDiv.onclick = selectHour;
            subDiv.id = 'hourDiv' + no;
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
            if(currentYear && currentYear==no){
                subDiv.style.color = selectBoxHighlightColor;
                activeSelectBoxYear = subDiv;
            }
        }
        var subDiv = document.createElement('DIV');
        subDiv.innerHTML = '&nbsp;&nbsp;+ ';
        subDiv.onclick = changeSelectBoxHour;
        subDiv.onmouseover = highlightMonthYear;
        subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
        subDiv.onselectstart = cancelCalendarEvent;
        div.appendChild(subDiv);
    
        return div;
    }
    /* This function creates the minute div at the bottom bar */
    
    function createMinuteDiv()
    {
        if(!document.getElementById('minuteDropDown')){
            var div = document.createElement('DIV');
            div.className='monthYearPicker';
        }else{
            var div = document.getElementById('minuteDropDown');
            var subDivs = div.getElementsByTagName('DIV');
            for(var no=0;no<subDivs.length;no++){
                subDivs[no].parentNode.removeChild(subDivs[no]);
            }
        }
        var startMinute = 0;
        var prefix = '';
        for(var no=startMinute;no<60;no+=intervalSelectBox_minutes){
    
            if(no<10)prefix='0'; else prefix = '';
            var subDiv = document.createElement('DIV');
            subDiv.innerHTML = prefix + no;
            subDiv.onmouseover = highlightMonthYear;
            subDiv.onmouseout = highlightMonthYear;
            subDiv.onclick = selectMinute;
            subDiv.id = 'minuteDiv_' + prefix +  no;
            subDiv.onselectstart = cancelCalendarEvent;
            div.appendChild(subDiv);
            if(currentYear && currentYear==no){
                subDiv.style.color = selectBoxHighlightColor;
                activeSelectBoxYear = subDiv;
            }
        }
        return div;
    }
    
    function highlightSelect()
    {
    
        if(this.className=='selectBoxTime'){
            this.className = 'selectBoxTimeOver';
            this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_time_over.gif';
        }else if(this.className=='selectBoxTimeOver'){
            this.className = 'selectBoxTime';
            this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_time.gif';
        }
    
        if(this.className=='selectBox'){
            this.className = 'selectBoxOver';
            this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_over.gif';
        }else if(this.className=='selectBoxOver'){
            this.className = 'selectBox';
            this.getElementsByTagName('IMG')[0].src = pathToImages + 'down.gif';
        }
    
    }
    
    function highlightArrow()
    {
        if(this.src.indexOf('over')>=0){
            if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left.gif';
            if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right.gif';
        }else{
            if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left_over.gif';
            if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right_over.gif';
        }
    }
    
    function highlightClose()
    {
        if(this.src.indexOf('over')>=0){
            this.src = pathToImages + 'close_new.gif';
        }else{
            this.src = pathToImages + 'close_over.gif';
        }
    
    }
    
    function closeCalendar(){
    
        document.getElementById('yearDropDown').style.display='none';
        document.getElementById('monthDropDown').style.display='none';
        document.getElementById('hourDropDown').style.display='none';
        document.getElementById('minuteDropDown').style.display='none';
    
        calendarDiv.style.display='none';
        if(iframeObj){
            iframeObj.style.display='none';
             //// //// fix for EI frame problem on time dropdowns 09/30/2006
                EIS_Hide_Frame();}
        if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
        if(activeSelectBoxYear)activeSelectBoxYear.className='';
    
    
    }
    
    function writeTopBar()
    {
    
        var topBar = document.createElement('DIV');
        topBar.className = 'topBar';
        topBar.id = 'topBar';
        calendarDiv.appendChild(topBar);
    
        // Left arrow
        var leftDiv = document.createElement('DIV');
        leftDiv.style.marginRight = '1px';
        var img = document.createElement('IMG');
        img.src = pathToImages + 'left.gif';
        img.onmouseover = highlightArrow;
        img.onclick = switchMonth;
        img.onmouseout = highlightArrow;
        leftDiv.appendChild(img);
        topBar.appendChild(leftDiv);
        if(Opera)leftDiv.style.width = '16px';
    
        // Right arrow
        var rightDiv = document.createElement('DIV');
        rightDiv.style.marginRight = '1px';
        var img = document.createElement('IMG');
        img.src = pathToImages + 'right.gif';
        img.onclick = switchMonth;
        img.onmouseover = highlightArrow;
        img.onmouseout = highlightArrow;
        rightDiv.appendChild(img);
        if(Opera)rightDiv.style.width = '16px';
        topBar.appendChild(rightDiv);
    
    
        // Month selector
        var monthDiv = document.createElement('DIV');
        monthDiv.id = 'monthSelect';
        monthDiv.onmouseover = highlightSelect;
        monthDiv.onmouseout = highlightSelect;
        monthDiv.onclick = showMonthDropDown;
        var span = document.createElement('SPAN');
        span.innerHTML = monthArray[currentMonth];
        span.id = 'calendar_month_txt';
        monthDiv.appendChild(span);
    
        var img = document.createElement('IMG');
        img.src = pathToImages + 'down.gif';
        img.style.position = 'absolute';
        img.style.right = '0px';
        monthDiv.appendChild(img);
        monthDiv.className = 'selectBox';
        if(Opera){
            img.style.cssText = 'float:right;position:relative';
            img.style.position = 'relative';
            img.style.styleFloat = 'right';
        }
        topBar.appendChild(monthDiv);
    
        var monthPicker = createMonthDiv();
        monthPicker.style.left = '37px';
        monthPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
        monthPicker.style.width ='60px';
        monthPicker.id = 'monthDropDown';
    
        calendarDiv.appendChild(monthPicker);
    
        // Year selector
        var yearDiv = document.createElement('DIV');
        yearDiv.onmouseover = highlightSelect;
        yearDiv.onmouseout = highlightSelect;
        yearDiv.onclick = showYearDropDown;
        var span = document.createElement('SPAN');
        span.innerHTML = currentYear;
        span.id = 'calendar_year_txt';
        yearDiv.appendChild(span);
        topBar.appendChild(yearDiv);
    
        var img = document.createElement('IMG');
        img.src = pathToImages + 'down.gif';
        yearDiv.appendChild(img);
        yearDiv.className = 'selectBox';
    
        if(Opera){
            yearDiv.style.width = '50px';
            img.style.cssText = 'float:right';
            img.style.position = 'relative';
            img.style.styleFloat = 'right';
        }
    
        var yearPicker = createYearDiv();
        yearPicker.style.left = '113px';
        yearPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
        yearPicker.style.width = '35px';
        yearPicker.id = 'yearDropDown';
        calendarDiv.appendChild(yearPicker);
    
    
        var img = document.createElement('IMG');
        img.src = pathToImages + 'close_new.gif';
        img.style.styleFloat = 'right';
        img.onmouseover = highlightClose;
        img.onmouseout = highlightClose;
        img.onclick = closeCalendar;
        topBar.appendChild(img);
        if(!document.all){
            img.style.position = 'absolute';
            img.style.right = '2px';
        }
    
    
    
    }
    
    function writeCalendarContent()
    {
        var calendarContentDivExists = true;
        if(!calendarContentDiv){
            calendarContentDiv = document.createElement('DIV');
            calendarDiv.appendChild(calendarContentDiv);
            calendarContentDivExists = false;
        }
        currentMonth = currentMonth/1;
        var d = new Date();
    
        d.setFullYear(currentYear);
        d.setDate(1);
        d.setMonth(currentMonth);
    
        var dayStartOfMonth = d.getDay();
        if (! weekStartsOnSunday) {
          if(dayStartOfMonth==0)dayStartOfMonth=7;
          dayStartOfMonth--;
       }
    
        document.getElementById('calendar_year_txt').innerHTML = currentYear;
        document.getElementById('calendar_month_txt').innerHTML = monthArray[currentMonth];
        //alert (document.getElementById('calendar_month_txt').innerHTML )
        document.getElementById('calendar_hour_txt').innerHTML = currentHour;
        document.getElementById('calendar_minute_txt').innerHTML = currentMinute;
    
        var existingTable = calendarContentDiv.getElementsByTagName('TABLE');
        if(existingTable.length>0){
            calendarContentDiv.removeChild(existingTable[0]);
        }
    
        var calTable = document.createElement('TABLE');
        calTable.width = '100%';
        calTable.cellSpacing = '0';
        calendarContentDiv.appendChild(calTable);
    
    
    
    
        var calTBody = document.createElement('TBODY');
        calTable.appendChild(calTBody);
        var row = calTBody.insertRow(-1);
        row.className = 'calendar_week_row';
       if (showWeekNumber) {
          var cell = row.insertCell(-1);
    //	   cell.innerHTML = weekString;
    //	   cell.className = 'calendar_week_column';
           cell.style.backgroundColor = selectBoxRolloverBgColor;
        }
    
        for(var no=0;no<dayArray.length;no++){
            var cell = row.insertCell(-1);
            cell.innerHTML = dayArray[no];
        }
    
        var row = calTBody.insertRow(-1);
    
       if (showWeekNumber) {
           var cell = row.insertCell(-1);
           cell.className = 'calendar_week_column';
           cell.style.backgroundColor = selectBoxRolloverBgColor;
           var week = getWeek(currentYear,currentMonth,1);
    //	   cell.innerHTML = week;		// Week
        }
        for(var no=0;no<dayStartOfMonth;no++){
            var cell = row.insertCell(-1);
            cell.innerHTML = '&nbsp;';
        }
    
        var colCounter = dayStartOfMonth;
        var daysInMonth = daysInMonthArray[currentMonth];
        if(daysInMonth==28){
            if(isLeapYear(currentYear))daysInMonth=29;
        }
    
        for(var no=1;no<=daysInMonth;no++){
            d.setDate(no-1);
            if(colCounter>0 && colCounter%7==0){
                var row = calTBody.insertRow(-1);
             if (showWeekNumber) {
                var cell = row.insertCell(-1);
                cell.className = 'calendar_week_column';
                var week = getWeek(currentYear,currentMonth,no);
    //            cell.innerHTML = week;		// Week
                cell.style.backgroundColor = selectBoxRolloverBgColor;
             }
            }
            var cell = row.insertCell(-1);
            if(currentYear==inputYear && currentMonth == inputMonth && no==inputDay){
                cell.className='activeDay';
            }
            cell.innerHTML = no;
            cell.onclick = pickDate;
            colCounter++;
        }
    
    
        if(!document.all){
            if(calendarContentDiv.offsetHeight)
                document.getElementById('topBar').style.top = calendarContentDiv.offsetHeight + document.getElementById('timeBar').offsetHeight + document.getElementById('topBar').offsetHeight -1 + 'px';
            else{
                document.getElementById('topBar').style.top = '';
                document.getElementById('topBar').style.bottom = '0px';
            }
    
        }
    
        if(iframeObj){
            if(!calendarContentDivExists)setTimeout('resizeIframe()',350);else setTimeout('resizeIframe()',10);
        }
    
    
    
    
    }
    
    function resizeIframe()
    {
        iframeObj.style.width = calendarDiv.offsetWidth + 'px';
        iframeObj.style.height = calendarDiv.offsetHeight + 'px' ;
    
    
    }
    
    function pickTodaysDate()
    {
        var d = new Date();
        currentMonth = d.getMonth();
        currentYear = d.getFullYear();
        pickDate(false,d.getDate());
    
    }
    
    
    
    function displayCalendar(inputField,format,buttonObj,displayTime,timeInput,fname)
    {
    
        formname = fname;
    
    
    if(displayTime)calendarDisplayTime=true; else calendarDisplayTime = false;
        
        if(inputField.value.length>6){ //dates must have at least 6 digits...
           if(!inputField.value.match(/^[0-9]*?$/gi)){
               
                var items = inputField.value.split(/[^0-9]/gi);
                var positionArray = new Object();
                positionArray.m = format.indexOf('mm');
                if(positionArray.m==-1)positionArray.m = format.indexOf('m');
                positionArray.d = format.indexOf('dd');
                if(positionArray.d==-1)positionArray.d = format.indexOf('d');
                positionArray.y = format.indexOf('yyyy');
                positionArray.h = format.indexOf('hh');
                positionArray.i = format.indexOf('ii');
    
                
                this.initialHour = '00';
                this.initialMinute = '00';				
                var elements = ['y','m','d','h','i'];
                var properties = ['currentYear','currentMonth','inputDay','currentHour','currentMinute'];
                var propertyLength = [4,2,2,2,2];
    
                var	mydate = inputField.value;	
                var arr = mydate.split('-');
    
                var mon = 0;
                var monthArrayShort = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
                for (i =0; i<= 11; i++ )
            
                {
                    if (monthArrayShort[i] == arr[1])
                    {
                        mon = i;
                        break;	
                    }
                }	
                mon++;
                if(mon<10)mon = '0' + mon;
                arr[1] = mon;
                //alert(mon)
                mydate = arr[0]+'-'+arr[1]+'-'+arr[2];
            //alert (mydate);
            for(var i=0;i<elements.length;i++) {
                    if(positionArray[elements[i]]>=0) {
                        window[properties[i]] =  mydate.substr(positionArray[elements[i]],propertyLength[i])/1;
                    //alert(window[properties[i]])
                    }					
                }
                
                currentMonth--;
    
                //var monthArrayShort = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    //			monthArrayShort[currentMonth]
    
    
            //alert (this.innerHTML)
    //			alert(currentMonth +'--test'+ this.innerHTML);
            }else{
                
                            //alert("pradeep");
    
                var monthPos = format.indexOf('mm');
                currentMonth = inputField.value.substr(monthPos,2)/1 -1;
                var yearPos = format.indexOf('yyyy');
                currentYear = inputField.value.substr(yearPos,4);
                var dayPos = format.indexOf('dd');
                tmpDay = inputField.value.substr(dayPos,2);
                var hourPos = format.indexOf('hh');
                if(hourPos>=0){
                    tmpHour = inputField.value.substr(hourPos,2);
                    currentHour = tmpHour;
                }else{
                    currentHour = '00';
                }
    
                var minutePos = format.indexOf('ii');
                if(minutePos>=0){
                    tmpMinute = inputField.value.substr(minutePos,2);
                    currentMinute = tmpMinute;
                }else{
                    currentMinute = '00';
                }
            }
        }else{
            var d = new Date();
            currentMonth = d.getMonth();
            currentYear = d.getFullYear();
            currentHour = '08';
            currentMinute = '00';
            inputDay = d.getDate()/1;
        }
    
        inputYear = currentYear;
        inputMonth = currentMonth;
    
    
        if(!calendarDiv){
            initCalendar();
        }else{
            if(calendarDiv.style.display=='block'){
                return false;
            }
            writeCalendarContent();
        }
    
    
    
        returnFormat = format;
        returnDateTo = inputField;
        positionCalendar(buttonObj);
        calendarDiv.style.visibility = 'visible';
        calendarDiv.style.display = 'block';
        if(iframeObj){
            iframeObj.style.display = '';
            iframeObj.style.height = '140px';
            iframeObj.style.width = '195px';
                    iframeObj2.style.display = '';
            iframeObj2.style.height = '140px';
            iframeObj2.style.width = '195px';
        }
    
        setTimeProperties();
        updateYearDiv();
        updateMonthDiv();
        updateMinuteDiv();
        updateHourDiv();
    
    }
    
    
    
    function pickDate(e,inputDay)
    {
        var month = currentMonth/1 +1;
        var monthArrayShort = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
    
        if(month<10)month = '0' + month;
        var day;
        if(!inputDay && this)day = this.innerHTML; else day = inputDay;
    
        if(day/1<10)day = '0' + day;
        if(returnFormat){
            returnFormat = returnFormat.replace('dd',day);
            var t = month -1;
            var a = monthArrayShort[t];
    
    
    var mydate = new Date();
    var m1 = mydate.getMonth();
    var  y1= mydate.getFullYear();
    var  d1= mydate.getDate();
    
    m1++;
    
    //var c_date = d1+''+m1+''+y1;
    
    if (formname == 'valid_till') {
        if ( currentYear < y1){
            alert ('You can\'t select the date before Current Date');
            closeCalendar();
            document.getElementById(formname).focus();
            return;
        }
        else {
            if (currentYear == y1 ) {
                if (month < m1) {
                    alert ('You can\'t select the date before Current Date');
                    closeCalendar();
                    document.getElementById(formname).focus();
                    return;
                }
                else {
                    if (month == m1) {
                        if (day < d1) {
                            alert ('You can\'t select the date before Current Date');
                            closeCalendar();
                            document.getElementById(formname).focus();
                            return;
                        }
                    }
                }
            }
        }
    }
    
    if (formname != 'exp_date' && formname != 'valid_till')
    if ( currentYear > y1)
    {
    
    
    
    
        alert ('You can\'t select the date after Current Date');
        closeCalendar();
        document.getElementById(formname).focus();
        return;
    
    }
    else
    {
        if (currentYear == y1 )
        {
            if (month > m1)
            {
                alert ('You can\'t select the date after Current Date');
                closeCalendar();
                document.getElementById(formname).focus();
                return;
    
                }
            else
            {
                if (month == m1)
                {
                    if (day > d1)
                    {
                        alert ('You can\'t select the date after Current Date');
                        closeCalendar();
                        document.getElementById(formname).focus();
                        return;
                    }
    
                }
    
            }
    
        }
    
    }	
    
    //if(month<10)month = '0' + month;
    //var selected_date = day+''+month+''+currentYear;
    //alert ('selected date '+selected_date);
    
    //if (c_date < selected_date)
    //{
    //alert ('You can\'t select the date after Current Date' );
    //	return;
    //}
    
            returnFormat = returnFormat.replace('mm',a);
            //alert (returnFormat +"==="+ a +"==="+ t);
            returnFormat = returnFormat.replace('yyyy',currentYear);
            returnFormat = returnFormat.replace('hh',currentHour);
            returnFormat = returnFormat.replace('ii',currentMinute);
            returnFormat = returnFormat.replace('d',day/1);
            returnFormat = returnFormat.replace('m',month/1);
            returnDateTo.value = returnFormat;
            try{
                returnDateTo.onchange();
            }catch(e){
    
            }
        }else{
            for(var no=0;no<returnDateToYear.options.length;no++){
                if(returnDateToYear.options[no].value==currentYear){
                    returnDateToYear.selectedIndex=no;
                    break;
                }
            }
            for(var no=0;no<returnDateToMonth.options.length;no++){
                if(returnDateToMonth.options[no].value==parseInt(month)){
                    returnDateToMonth.selectedIndex=no;
                    break;
                }
            }
            for(var no=0;no<returnDateToDay.options.length;no++){
                if(returnDateToDay.options[no].value==parseInt(day)){
                    returnDateToDay.selectedIndex=no;
                    break;
                }
            }
            if(calendarDisplayTime){
                for(var no=0;no<returnDateToHour.options.length;no++){
                    if(returnDateToHour.options[no].value==parseInt(currentHour)){
                        returnDateToHour.selectedIndex=no;
                        break;
                    }
                }
                for(var no=0;no<returnDateToMinute.options.length;no++){
                    if(returnDateToMinute.options[no].value==parseInt(currentMinute)){
                        returnDateToMinute.selectedIndex=no;
                        break;
                    }
                }
            }
        }
        closeCalendar();
    
    }
    
    // This function is from http://www.codeproject.com/csharp/gregorianwknum.asp
    // Only changed the month add
    function getWeek(year,month,day){
       if (! weekStartsOnSunday) {
           day = (day/1);
        } else {
           day = (day/1)+1;
        }
        year = year /1;
        month = month/1 + 1; //use 1-12
        var a = Math.floor((14-(month))/12);
        var y = year+4800-a;
        var m = (month)+(12*a)-3;
        var jd = day + Math.floor(((153*m)+2)/5) +
                     (365*y) + Math.floor(y/4) - Math.floor(y/100) +
                     Math.floor(y/400) - 32045;      // (gregorian calendar)
        var d4 = (jd+31741-(jd%7))%146097%36524%1461;
        var L = Math.floor(d4/1460);
        var d1 = ((d4-L)%365)+L;
        NumberOfWeek = Math.floor(d1/7) + 1;
        return NumberOfWeek;
    }
    
    function writeTimeBar()
    {
        var timeBar = document.createElement('DIV');
        timeBar.id = 'timeBar';
        timeBar.className = 'timeBar';
    
        var subDiv = document.createElement('DIV');
        subDiv.innerHTML = 'Time:';
        //timeBar.appendChild(subDiv);
    
        // Year selector
        var hourDiv = document.createElement('DIV');
        hourDiv.onmouseover = highlightSelect;
        hourDiv.onmouseout = highlightSelect;
        hourDiv.onclick = showHourDropDown;
        hourDiv.style.width = '30px';
        var span = document.createElement('SPAN');
        span.innerHTML = currentHour;
        span.id = 'calendar_hour_txt';
        hourDiv.appendChild(span);
        timeBar.appendChild(hourDiv);
    
        var img = document.createElement('IMG');
        img.src = pathToImages + 'down_time.gif';
        hourDiv.appendChild(img);
        hourDiv.className = 'selectBoxTime';
    
        if(Opera){
            hourDiv.style.width = '30px';
            img.style.cssText = 'float:right';
            img.style.position = 'relative';
            img.style.styleFloat = 'right';
        }
    
        var hourPicker = createHourDiv();
        hourPicker.style.left = '130px';
        //hourPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
        hourPicker.style.width = '35px';
        hourPicker.id = 'hourDropDown';
        calendarDiv.appendChild(hourPicker);
    
        // Add Minute picker
    
        // Year selector
        var minuteDiv = document.createElement('DIV');
        minuteDiv.onmouseover = highlightSelect;
        minuteDiv.onmouseout = highlightSelect;
        minuteDiv.onclick = showMinuteDropDown;
        minuteDiv.style.width = '30px';
        var span = document.createElement('SPAN');
        span.innerHTML = currentMinute;
    
        span.id = 'calendar_minute_txt';
        minuteDiv.appendChild(span);
        timeBar.appendChild(minuteDiv);
    
        var img = document.createElement('IMG');
        img.src = pathToImages + 'down_time.gif';
        minuteDiv.appendChild(img);
        minuteDiv.className = 'selectBoxTime';
    
        if(Opera){
            minuteDiv.style.width = '30px';
            img.style.cssText = 'float:right';
            img.style.position = 'relative';
            img.style.styleFloat = 'right';
        }
    
        var minutePicker = createMinuteDiv();
        minutePicker.style.left = '167px';
        //minutePicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
        minutePicker.style.width = '35px';
        minutePicker.id = 'minuteDropDown';
        calendarDiv.appendChild(minutePicker);
    
    
        return timeBar;
    
    }
    
    function writeBottomBar()
    {
        var d = new Date();
        var bottomBar = document.createElement('DIV');
    
        bottomBar.id = 'bottomBar';
    
        bottomBar.style.cursor = 'pointer';
        bottomBar.className = 'todaysDate';
        // var todayStringFormat = '[todayString] [dayString] [day] [monthString] [year]';	;;
    
        var subDiv = document.createElement('DIV');
        subDiv.onclick = pickTodaysDate;
        subDiv.id = 'todaysDateString';
        subDiv.style.width = (calendarDiv.offsetWidth - 95) + 'px';
        var day = d.getDay();
        if (! weekStartsOnSunday) {
          if(day==0)day = 7;
          day--;
       }
    
        var bottomString = todayStringFormat;
        bottomString = bottomString.replace('[monthString]',monthArrayShort[d.getMonth()]);
        bottomString = bottomString.replace('[day]',d.getDate());
        bottomString = bottomString.replace('[year]',d.getFullYear());
        bottomString = bottomString.replace('[dayString]',dayArray[day].toLowerCase());
        bottomString = bottomString.replace('[UCFdayString]',dayArray[day]);
        bottomString = bottomString.replace('[todayString]',todayString);
    
    
        subDiv.innerHTML = todayString + ': ' + d.getDate() + '. ' + monthArrayShort[d.getMonth()] + ', ' +  d.getFullYear() ;
        subDiv.innerHTML = bottomString ;
        bottomBar.appendChild(subDiv);
    
        var timeDiv = writeTimeBar();
        bottomBar.appendChild(timeDiv);
    
        calendarDiv.appendChild(bottomBar);
    
    
    
    }
    function getTopPos(inputObj)
    {
    
      var returnValue = inputObj.offsetTop + inputObj.offsetHeight;
      while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetTop;
      return returnValue + calendar_offsetTop;
    }
    
    function getleftPos(inputObj)
    {
      var returnValue = inputObj.offsetLeft;
      while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
      return returnValue + calendar_offsetLeft;
    }
    
    function positionCalendar(inputObj)
    {
        calendarDiv.style.left = getleftPos(inputObj) + 'px';
        calendarDiv.style.top = getTopPos(inputObj) + 'px';
        if(iframeObj){
            iframeObj.style.left = calendarDiv.style.left;
            iframeObj.style.top =  calendarDiv.style.top;
            //// fix for EI frame problem on time dropdowns 09/30/2006
            iframeObj2.style.left = calendarDiv.style.left;
            iframeObj2.style.top =  calendarDiv.style.top;
        }
    
    }
    
    function initCalendar()
    {
        if(MSIE){
            iframeObj = document.createElement('IFRAME');
            iframeObj.style.filter = 'alpha(opacity=0)';
            iframeObj.style.position = 'absolute';
            iframeObj.border='0px';
            iframeObj.style.border = '0px';
            iframeObj.style.backgroundColor = '#FF0000';
            //// fix for EI frame problem on time dropdowns 09/30/2006
            iframeObj2 = document.createElement('IFRAME');
            iframeObj2.style.position = 'absolute';
            iframeObj2.border='0px';
            iframeObj2.style.border = '0px';
            iframeObj2.style.height = '1px';
            iframeObj2.style.width = '1px';
            //// fix for EI frame problem on time dropdowns 09/30/2006
            // Added fixed for HTTPS
            iframeObj2.src = 'calendar.html';
            iframeObj.src = 'calendar.html';
            document.body.appendChild(iframeObj2);  // gfb move this down AFTER the .src is set
            document.body.appendChild(iframeObj);
        }
    
        calendarDiv = document.createElement('DIV');
        calendarDiv.id = 'calendarDiv';
        calendarDiv.style.zIndex = 1000;
        slideCalendarSelectBox();
    
        document.body.appendChild(calendarDiv);
        writeBottomBar();
        writeTopBar();
    
    
    
        if(!currentYear){
            var d = new Date();
            currentMonth = d.getMonth();
            currentYear = d.getFullYear();
        }
        writeCalendarContent();
    
    
    
    }
    
    function setTimeProperties()
    {
        if(!calendarDisplayTime){
            document.getElementById('timeBar').style.display='none';
            document.getElementById('timeBar').style.visibility='hidden';
            document.getElementById('todaysDateString').style.width = '100%';
    
    
        }else{
            document.getElementById('timeBar').style.display='block';
            document.getElementById('timeBar').style.visibility='visible';
            document.getElementById('hourDropDown').style.top = document.getElementById('calendar_minute_txt').parentNode.offsetHeight + calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight + 'px';
            document.getElementById('minuteDropDown').style.top = document.getElementById('calendar_minute_txt').parentNode.offsetHeight + calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight + 'px';
            document.getElementById('minuteDropDown').style.right = '50px';
            document.getElementById('hourDropDown').style.right = '50px';
            document.getElementById('todaysDateString').style.width = '115px';
        }
    }
    
    function calendarSortItems(a,b)
    {
        return a/1 - b/1;
    }
    