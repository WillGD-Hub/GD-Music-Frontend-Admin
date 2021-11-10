<?php

    use Illuminate\Support\Facades\Auth;

    function isLogin()
    {
        return Auth::guard("web")->check();
    }

    function getUser()
    {
        if (isLogin() == false) {
            return false;
        } else {
            if (Auth::guard('web')->check()) {
                return Auth::guard('web')->user();
            }
        }
    }

?>
