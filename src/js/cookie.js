/* 
功能：保存cookies函数  
参数：name，cookie名字；value，值 
*/
import Vue from 'vue'
Vue.prototype.SetCookie= function(name,value){  
    var Days = 30*12;   //cookie 将被保存一年  
    var exp  = new Date();  //获得当前时间  
    exp.setTime(exp.getTime() + Days*24*60*60*1000);  //换成毫秒  
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+ "; path=/";  
}
/* 
功能：获取cookies函数  
参数：name，cookie名字 
*/  
Vue.prototype.getCookie=function(name){  
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));  
    if(arr != null){  
     return unescape(arr[2]);   
    }else{  
     return null;  
    }  
}   
/* 
功能：删除cookies函数  
参数：name，cookie名字 
*/  
  
Vue.prototype.delCookie=function(name){  
    var exp = new Date();  //当前时间  
    exp.setTime(exp.getTime() - 1);
    console.log(exp)
    var cval=this.getCookie(name);
    console.log(cval)  
    if(cval!=null){
        document.cookie= name + "="+cval+";expires="+exp.toGMTString()+ "; path=/";  
    }
} 
