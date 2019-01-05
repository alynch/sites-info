<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Exception;

class SiteInfo
{

    protected $site;
    protected $headers = ['Server', 'X-Powered-By'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($site, $client)
    {
        if (!filter_var($site, FILTER_VALIDATE_URL)) {
            throw new \Exception;
        }
        $this->site = $site;

        // FIXME: should not have to use verify false
        $this->client = new $client(['base_url' => $this->site, 'verify' => false]);
    }

    public function getUrl()
    {
        return $this->site;
    }

    public function checkSite()
    {
        $info = $this->verifySite();
        $info['headers'][] = ['name'=> 'SSL cert. expires on', 'value' => $this->verifyCert()];

        return $info;
    }

    public function verifySite()
    {
        $info = [];

        try {
            $request = new Request('GET', $this->site . '/');
            $response = $this->client->get($this->site);

            if ($response) {
                $info['running'] = true;
                $host = $request->getUri()->getHost();
                $info['ip'] = gethostbyname($host);

                $info['headers'] = $this->getHeaders($response);
            }
        } catch (ConnectException $e) {
            $info = $this->noResponse();
        } catch (ClientException $e) {
            if ($e->getResponse()) {
                $host = $e->getRequest()->getUri()->getHost();
                $info['ip'] = gethostbyname($host);
                $info['running'] = true;
            } else {
                $info = $this->noResponse();
            }
        } catch (Exception $e) {
            $info = $this->noResponse();
        }

        return $info;
    }


    public function verifyCert()
    {
        try {
            $original = parse_url($this->site, PHP_URL_HOST);
            $get = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
            $read = stream_socket_client("ssl://".$original.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
            $cert = stream_context_get_params($read);
            $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        } catch (Exception $e) {
            return;
        }
        return gmdate("Y-m-d", $certinfo['validTo_time_t']);
    }

    private function noResponse()
    {
        return [
            'ip' => '',
            'running' => false
        ];
    }

    private function getHeaders($response)
    {
        $headers = [];
        foreach ($this->headers as $header) {
            if ($value = $response->getHeader($header)) {
                $headers[] = ['name' => $header, 'value' => implode($value)];
            }
        }
        return $headers;
    }

    private function getDetails($client)
    {
        $details = '';
        try {
            $response = $client->get($this->site . '/version');
            if ($response->getStatusCode() == '200') {
                $details = json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            //
        }
        return $details;
    }
}
