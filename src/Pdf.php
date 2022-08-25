<?php


namespace Advans\Api\Pdf;

use Exception;
use stdClass;

class Pdf {

    protected Config $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    public function version(): string {
        return $this->call('version');
    }

    public function getRawMetrics(): stdClass {
        return json_decode($this->call('metrics'));
    }

    public function getMetricsSummary(): MetricsSummary {
        return new MetricsSummary($this->call('metrics/summary'));
    }

    public function fromFormatObject($fo): string {
        return $this->call('v1/from-fo', 'POST', $fo);
    }

    protected function call($method, $verb = 'GET', $params = null): string {
        $verb = strtoupper($verb);
        $url = $this->config->base_url . $method;
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
            CURLOPT_XOAUTH2_BEARER => $this->config->key,
        ]);
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code != 200 || $result === false) {
            if ($this->config->use_exceptions) {
                throw new Exception('Error de conexión con API-PDF');
            } else {
                return false;
            }
        }
        return $result;
    }
}