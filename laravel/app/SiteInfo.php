<?php

namespace App;

use App\Cert;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Exception;

class SiteInfo
{

    protected $site;
    protected $client;
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
        return (new Cert($this->site))->getExpirationDate();
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
