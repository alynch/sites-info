<?php

namespace App;

use Exception;

class Cert
{
    protected $site;
    protected $cert;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($site)
    {
        if (!filter_var($site, FILTER_VALIDATE_URL)) {
            throw new \Exception;
        }
        $this->site = $site;
        
        $this->setUp();
    }

    private function setUp()
    {
        try {
            $original = parse_url($this->site, PHP_URL_HOST);
            $get = stream_context_create(array("ssl" => array("capture_peer_cert" => true)));
            $read = stream_socket_client("ssl://".$original.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
            $cert = stream_context_get_params($read);
            $this->cert = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        } catch (Exception $e) {
            return;
        }
    }

    public function getExpirationDate()
    {
        return gmdate("Y-m-d", $this->cert['validTo_time_t']);
    }
}
