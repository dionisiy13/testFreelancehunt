<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 13.07.2018
 * Time: 15:23.
 */

namespace Core\Service;

class Geo
{
    public function getCountryCodeByIp(string $ip): string
    {
        sleep(1);
        $ip_data = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip));
        if ($ip_data && null != $ip_data->geoplugin_countryName) {
            $result['country'] = $ip_data->geoplugin_countryCode;
            $result['city'] = $ip_data->geoplugin_city;
        }

        return $result['country'] ?? '';
    }
}
