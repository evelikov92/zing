<?php

namespace Engine\Security;

use Engine\Environment;

/**
 * That class is send request to google recaptcha and check do captcha send from client is correct
 * @package Engine\Security
 */
class Captcha
{
    /**
     * Check do captcha response value send from the client is correct
     * @param string $captcha The captcha response value
     * @param string $ip The User Ip
     * @return bool Do captcha is valid
     */
    public static function check($captcha, $ip)
    {
        $key = Environment::get('CAPTCHA_SECRET_KEY');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$key&response=$captcha&remoteip=$ip");
        $obj = json_decode($response);

        if ($obj->success == true) {
            return true;
        } else {
            return false;
        }
    }
}
