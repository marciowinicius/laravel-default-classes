<?php


namespace MarcioWinicius\LaravelDefaultClasses\Request;

use MarcioWinicius\LaravelDefaultClasses\Exceptions\GeneralException;

class CurlRequest
{
    function cUrlGetData($url, $post_fields = null, $headers = null, $method = null, $json = true)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($method){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        } elseif ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new GeneralException("Erro CURL na URL $url ... Erro : " . curl_error($ch));
        }
        curl_close($ch);

        if ($json){
            $data = json_decode($data);
        }
        return $data;
    }
}
