<?php

namespace App;

class SiteInfo
{

    protected $site;
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
            $client = new \GuzzleHttp\Client(['base_url' => $this->site]);
            $response = $client->get($this->site);

            if ($response) {
                $info['running'] = true;
                $info['ip'] = gethostbyname(preg_replace('#^https?://#', '', rtrim($this->site, '/')));
                $headers = ['Server', 'X-Powered-By'];
                foreach ($headers as $header) {
                    if ($value = $response->getHeader($header)) {
                        $info['headers'][$header] = $value;
                    }
                }
                try {
                    $response = $client->get($this->site . '/version');
                    if ($response->getStatusCode() == '200') {
                        $info['details'] = json_decode($response->getBody(), true);
                    }
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //
                }
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $info['ip'] = '';
            $info['running'] = false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
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
