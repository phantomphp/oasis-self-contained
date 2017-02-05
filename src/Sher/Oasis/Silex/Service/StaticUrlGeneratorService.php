<?php

namespace Sher\Oasis\Silex\Service;

class StaticUrlGeneratorService
{
    protected $baseUrl = '';

    protected $subBaseUrl = '';

    public function __construct($baseUrl = null, $subBaseUrl = null)
    {
        $this->baseUrl = $baseUrl;
        $this->subBaseUrl = $subBaseUrl;
    }

    public function getBase($url)
    {
        if (empty($url)) {
            return $this->baseUrl;
        }
        return sprintf('%s/%s', $this->baseUrl, $url);
    }

    public function getUrl($url)
    {
        if (empty($this->subBaseUrl)) {
            return $this->getBase($url);
        }

        return sprintf('%s/%s/%s', $this->baseUrl, $this->subBaseUrl, $url);
    }


}
