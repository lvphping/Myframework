/**
 * Created by Administrator on 2016/11/8.
 */
/*
* 实现秒数的倒计时
* url:跳转的链接
* <span class="daojishi">3</span>
* className : 对应的span标签下的daojishi
* */
function redirect(url,className){
        var url = url;
        var loginTime = parseInt($('.'+className).text());
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('.'+className).text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }},1000);
}
