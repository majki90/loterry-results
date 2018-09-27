<?php

Namespace Classes\LotteryResultsProvider;

use PHPHtmlParser\Dom;

class elGordoResultsProvider extends AbstractResultsProviderFactory
{
    public function __construct()
    {
        $this->setUrl(self::EL_GORDO_URL);
    }

    /**
     * @return mixed
     */
    private function getDom()
    {
        $dom = new Dom();
        return $dom->load($this->getContent());
    }

    /**
     * @return mixed
     */
    private function getNumbersDom()
    {
        $dom = $this->getDom();
        return $dom->find('[class="combi balls"]', 0)->find('[class="int-num"]');
    }

    /**
     * @param $resultSetDom
     * @return mixed
     */
    protected function getGameDate($resultSetDom)
    {
        return $this->formatDate($resultSetDom->find('div[class="c"]', 1)->text);
    }

    /**
     * @param $date
     * @return string
     */
    protected function formatDate($date)
    {
        $date = new \DateTime(explode($date,' ')[0]);
        return $date->format('Y-m-d'); //@todo needs refactorisation
    }

    /**
     *
     * @return array
     */
    public function getResults(): ?array
    {
        $results = [];
        foreach ($this->getNumbersDom() as $numberDom) {
            $results[] = $numberDom->text;
        }

        return [
            'gameName' => 'elGordo',
            'gameDate' => $this->getGameDate($this->getDom()),
            'numbers' => $results
        ];
    }
}