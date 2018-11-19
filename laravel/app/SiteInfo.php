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
    public function __construct($site)
    {
        $this->site = $site;
    }


    public function checkSite()
    {

        $info = [];

        try {
            $client = new Client(['base_url' => $this->site]);
            $request = new Request('GET', $this->site . '/');
            $response = $client->get($this->site);

            if ($response) {
                $info['running'] = true;
                $host = $request->getUri()->getHost();
                $info['ip'] = gethostbyname($host);


                foreach ($this->headers as $header) {
                    if ($value = $response->getHeader($header)) {
                        $info['headers'][$header] = $value;
                    }
                }
                try {
                    $response = $client->get($this->site . '/version');
                    if ($response->getStatusCode() == '200') {
                        $info['details'] = json_decode($response->getBody(), true);
                    }
                } catch (ClientException $e) {
                    //
                }
            }
        } catch (ConnectException $e) {
            $info['ip'] = '';
            $info['running'] = false;
        } catch (ClientException $e) {
            if ($e->getResponse()) {
                $host = $e->getRequest()->getUri()->getHost();
                $info['ip'] = gethostbyname($host);
                $info['running'] = true;
            } else {
                $info['ip'] = '';
                $info['running'] = false;
            }
        } catch (Exception $e) {
            $info['ip'] = '';
            $info['running'] = false;
        }

        try {
            $cert = $this->verifyCert($this->site);
            $info['headers']['SSL cert. expires on '] = gmdate("Y-m-d", $cert['validTo_time_t']);
        } catch (Exception $e) {
            //
        }
        return $info;
    }

    private function verifyCert($url)
    {
        $orignal_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
        $read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

        return $certinfo;
    }
}
