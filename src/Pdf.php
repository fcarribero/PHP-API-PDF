<?php


namespace Advans\Api\Pdf;

use Exception;

class Pdf {

    protected $config = [];

    public function __construct($config) {
        $this->config = array_merge(['use_exceptions' => true], $config);

        if (!isset($this->config['base_url'])) {
            throw new Exception('No se ha definido el endpoint de la API');
        }

        if (!isset($this->config['key'])) {
            throw new Exception('No se ha definido la clave de la API');
        }

        if (substr($this->config['base_url'], -1, 1) != '/') {
            $this->config['base_url'] .= '/';
        }
    }

    public function status() {
        return json_decode($this->call('status'));
    }

    public function metrics() {
        return json_decode($this->call('metrics'));
    }

    public function fromFormatObject($fo) {
        return $this->call('v1/from-fo', 'POST', $fo);
    }

    protected function call($method, $verb = 'GET', $params = null) {
        $verb = strtoupper($verb);
        $url = $this->config['base_url'] . $method;
        $curl = curl_init();
        $postfields = null;
        if ($verb == 'POST') {
            if (gettype($params) == 'array') {
                $postfields = json_encode($params);
            } else {
                $postfields = $params;
            }
        }
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . ($verb == 'GET' && $params ? '?' . http_build_query($params) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $verb,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_XOAUTH2_BEARER => $this->config['key'],
        ]);
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code != 200 || $result === false) {
            if ($this->config['use_exceptions']) {
                throw new Exception('Error de conexión con API-PDF');
            } else {
                return false;
            }
        }
        return $result;
    }
}