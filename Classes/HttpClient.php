<?php
namespace Classes;

class HttpClient
{
    /** @var string */
    private $adress;

    /** @var string */
    private $parameters;

    /** @var string */
    private $content;

    private $ch;

    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->ch = curl_init();
    }

    /**
     * init client params
     */
    private function _initClient()
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->adress);
        //return the transfer as a string
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    }

    /**
     * @return mixed
     */
    public function getAdress(): ?string
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     * @return HttpClient
     */
    public function setAdress($adress): httpClient
    {
        $this->adress = $adress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     * @return HttpClient
     */
    public function setParameters(?array $parameters): httpClient
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getContent()
    {
        $this->_initClient();

        // $output contains the output string
        $this->content = curl_exec($this->ch);

        // close curl resource to free up system resources
        curl_close($this->ch);

        return $this->content;
    }
}