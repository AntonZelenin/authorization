<?php

class CookieParser
{
    public function getUserId($userCookie)
    {
        if (preg_match('/sel(.+)token/', $userCookie, $temp)) {
            return $temp[1];
        } else {
            return false;
        }
    }

    public function getUserToken($userCookie)
    {
        if (preg_match('/token(.+)/', $userCookie, $temp)) {
            return $temp[1];
        } else {
            return false;
        }
    }

}
