<?php

class AuthMiddlewareWeb
{
    public static function isLogin() 
    {
        if(isset($_SESSION['token'])) {
            return true;
        } 
        
        return false;
    }

    public static function isAdmin() 
    {
        if(isset($_SESSION['token']) && $_SESSION['token']['is_admin'] == 1) {
            return true;
        } 
        
        return false;
    }


} 
