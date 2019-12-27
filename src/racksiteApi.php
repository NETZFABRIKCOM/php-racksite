<?php
/**
 * This file is part of the NETZFABRIK/php-racksite library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Giuliano Schindler <giuliano.schindler@netzfabrik.com>
 * @link https://docs.racksite.net Website
 */
namespace NETZFABRIK\racksite;
/**
 * Class Api
 * @package NETZFABRIK\racksite
 */
class racksiteApi
{
    private static $_username;
    private static $_password;
    private static $_accessToken;
    private static $_client;
    private static $_endpoint;

    /**
     * Url to communicate with racksite API
     *
     * @var array
     */
    private $_endpoints = [
        'racksite-prod'     => 'https://api.racksite.net/v1',
        'racksite-sandbox'  => 'https://api.sandbox.racksite.net/v1',
    ];

    /**
     * Api constructor.
     *
     * @param string $_username     Username for Login
     * @param string $_password     Password for Login
     * @param string $_endpoint     The URI of the target web API
     *
     * @throws \GuzzleHttp\Exception\BadResponseException
     */
    public function __construct($_username, $_password, $_endpoint = 'https://api.racksite.net/v1')
    {
        self::$_username = $_username;
        self::$_password = $_password;
        self::$_endpoint = $_endpoint;
        self::$_client = new \GuzzleHttp\Client();
        $responseLogin = self::$_client->request(
            'POST', self::$_endpoint.'/auth/login', [
                'form_params' => [
                    'username' => self::$_username,
                    'password' => self::$_password,
                ]
            ]
        );
        self::$_accessToken = json_decode($responseLogin->getBody())->access_token;
    }

    public function getColobootPxeInstaller()
    {
        $responseJson = self::$_client->request(
            'GET', self::$_endpoint.'/coloboot/pxe-installer', [
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$_accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        return json_decode($responseJson->getBody());
    }

    public function setColobootPxeInstaller($_hostname, $_macAddress, $_os, $_ip, $_netmask, $_gateway, $_password)
    {
        $responseJson = self::$_client->request(
            'POST', self::$_endpoint.'/coloboot/pxe-installer', [
            'form_params' => [
                'hostname' => $_hostname,
                'mac_address' => $_macAddress,
                'os' => $_os,
                'ip' => $_ip,
                'netmask' => $_netmask,
                'gateway' => $_gateway,
                'password' => $_password
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$_accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        return json_decode($responseJson->getBody());
    }
}
