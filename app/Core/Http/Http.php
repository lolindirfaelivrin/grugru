<?php

namespace Core;

class Http
{
    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
   
     */
    public static function get($url, array $params)
    {
        $query = http_build_query($params);
        $ch = curl_init($url . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    /**
     * @description Make HTTP-POST call
     * @param       $url
     * @param       array $params
   
     */
    public static function post($url, array $params)
    {
        $query = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    /**
     * @description Make HTTP-PUT call
     * @param       $url
     * @param       array $params
    
     */
    public static function put($url, array $params)
    {
        $query = \http_build_query($params);
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'PUT');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        $response = \curl_exec($ch);
        \curl_close($ch);
        return $response;
    }
    /**
     * @category Make HTTP-DELETE call
     * @param    $url
     * @param    array $params
     */
    public static function delete($url, array $params)
    {
        $query = \http_build_query($params);
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HEADER, false);
        \curl_setopt($ch, \CURLOPT_URL, $url);
        \curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'DELETE');
        \curl_setopt($ch, \CURLOPT_POSTFIELDS, $query);
        $response = \curl_exec($ch);
        \curl_close($ch);

        return $response;
    }
}