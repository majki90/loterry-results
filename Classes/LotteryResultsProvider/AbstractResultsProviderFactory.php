<?php

Namespace Classes\LotteryResultsProvider;

use Curl\Curl;

abstract class AbstractResultsProviderFactory
{
    CONST EUROJACKPORT_URL = 'https://www.lotto.pl/eurojackpot/wyniki-i-wygrane';
    CONST LOTTO_URL = 'https://www.lotto.pl/lotto/wyniki-i-wygrane';
    CONST EL_GORDO_URL = 'https://www.elgordo.com/results/euromillonariaen.asp';

    protected $url;

    /**
     * Gets request content
     * @return string
     */
    protected function getContent()
    {
        $curl = new Curl();
        return $curl->get($this->url)->response;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return AbstractResultsProviderFactory
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array|null
     */
    abstract public function getResults(): ?array;
}