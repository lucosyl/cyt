/*
* @Author: Administrator
* @Date:   2018-04-14 14:59:32
* @Last Modified by:   Administrator
* @Last Modified time: 2018-04-16 09:52:23
*/
$(function(){
    $('.registering').click(function(e){
        e.preventDefault();
        if ( !check()) return false;
        formData = $('#register').serialize();
        registering(formData)
    })    

    $('.logining').click(function(e){
        e.preventDefault();
        if ( !checkLogin() ) return false;
        formData = $('#login').serialize();
        logining(formData);
        console.log(formData);
    })

    function checkLogin(){
        u = $('input[name="username"]').val();
        p = $('input[name="lpassword"]').val();

        if( u=='' || u.length <6 ){
            alerting('用户名长度不可少于六位');
            u = $('input[name="username"]').focus();
            $('input[name="username"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }

        if( p=='' || p.length <6 ){
            alerting('密码长度不可少于六位');
            p = $('input[name="lpassword"]').focus();
            $('input[name="lpassword"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }
        return true;
    }

    function logining(data){
        $.post('/admin/user/logining',data,function(data){
            if(data.code== 200){
                window.location.href="/homes";
            }else{
                alerting(data.message);
            }
        })
    }   

    function check(){
        u = $('input[name="name"]').val();
        e = $('input[name="email"]').val();
        pwd = $('input[name="rpassword"]').val();
        p = $('input[name="phone"]').val();
        if( u=='' || u.length <6 ){
            alerting('用户名长度不可少于六位');
            u = $('input[name="name"]').focus();
            $('input[name="name"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }

        if( e=='' || !isEmail(e) ){
            alerting('邮箱格式不正确');
            u = $('input[name="email"]').focus();
            $('input[name="email"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }

        if( pwd=='' || pwd.length<6 ){
            alerting('密码长度不可少于六位');
            u = $('input[name="rpassword"]').focus();
            $('input[name="rpassword"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }

        if( p=='' || !isPhone(p)){
            alerting('号码格式不正确');
            u = $('input[name="phone"]').focus();
            $('input[name="phone"]').css('border-color','maroon');
            return false;
        }else{
            $('input').css('border-color','#eeeeee69')
        }

        return true;

    }

    function registering(formData){
        $.post('/admin/user/registering',formData,function(data){
            if(data.code == 200){
                $('#register input').val('');
                alerting('注册成功,后台管理员审核通过后可以登录');
            }else{
                alerting(data.message);
            }
        })
    }

})
