<?php
class Captcha
{
    private static $secret = '6LcZvrIZAAAAAK0gSvmhaqH9xuaxje8mqDJtS89t';
    private static $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @param string $code
     * @return array|null
     */
    public static function captchaRequest(string $code): ?array
    {
        $post_data = 'secret=' . self::$secret . '&response=' . $code . '&remoteip=' . $_SERVER['REMOTE_ADDR'] ;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8', 'Content-Length: ' . strlen($post_data)));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}