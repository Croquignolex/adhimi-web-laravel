<?php

if(!function_exists('nullable_params_value'))
{
    /**
     * @param string $key
     * @param array $validated
     * @return string
     */
    function nullable_params_value(string $key, array $validated): string
    {
        $value = array_key_exists($key, $validated) ? $validated[$key] : '';
        return $value ?? '';
    }
}

if(!function_exists('enums_equals'))
{
    /**
     * @param mixed $itemOne
     * @param mixed $itemTwo
     * @param bool $compareKeys
     * @return bool
     */
    function enums_equals(mixed $itemOne, mixed $itemTwo, bool $compareKeys = false): bool
    {
        if($compareKeys) {
            return $itemOne?->name === $itemTwo?->name;
        }

        return $itemOne?->value === $itemTwo?->value;
    }
}

if(!function_exists('client_ip_address'))
{
    /**
     * @return string
     */
    function client_ip_address(): string
    {
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (!empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }
}