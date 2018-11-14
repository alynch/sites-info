<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

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
            $request = new Request('GET', '/');
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
        }
        return $info;
    }
}
