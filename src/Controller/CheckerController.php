<?php

namespace LinkChecker\Controller;

use GuzzleHttp\Client;

class CheckerController
{
    /**
     * @var array
     */
    private $linksArray = [];

    private $statusArray = [];

    public function __construct()
    {
        $this->setupData();
    }

    private function setupData()
    {
        if(!isset($_POST['links'])) {
            return;
        }

        $links = $_POST['links'];
        $linksArray = explode("\n", $links);
        $links = array_map('trim', $linksArray);
        $this->setLinksArray($links);

        $this->setupStatus();
    }

    private function setupStatus()
    {
        foreach ($this->getLinksArray() as $url) {
            $client = new Client();
            try {
                $res = $client->request('GET', $url, [
                    'allow_redirects' => false
                ]);
                $this->statusArray[$url]['statusCode'] = $res->getStatusCode();
                $this->statusArray[$url]['headers'] = $res->getHeaders();
            } catch (GuzzleHttp\Exception\RequestException $e) {

            }

        }
    }

    /**
     * @return array
     */
    public function getLinksArray(): array
    {
        return $this->linksArray;
    }

    /**
     * @param array $linksArray
     */
    public function setLinksArray(array $linksArray): void
    {
        $this->linksArray = $linksArray;
    }

    /**
     * @return array
     */
    public function getStatusArray(): array
    {
        return $this->statusArray;
    }
}