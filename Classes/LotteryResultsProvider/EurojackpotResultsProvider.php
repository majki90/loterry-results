<?php

Namespace Classes\LotteryResultsProvider;

use PHPHtmlParser\Dom;

class EurojackpotResultsProvider extends AbstractResultsProviderFactory
{
    /**
     * EurojackpotResultsProvider constructor.
     */
    public function __construct()
    {
        $this->setUrl(self::EUROJACKPORT_URL);
    }

    /**
     * @return array
     */
    protected function getResultsSetDom()
    {
        $dom = new Dom();
        return $dom->load($this->getContent())->find('[class="wynik"]');
    }

    /**
     * @return mixed
     */
    protected function getResultsDom($resultSetDom)
    {
        return $resultSetDom->find('[class*="sortkolejnosc"]');
    }

    /**
     * @return mixed
     */
    protected function getNumbersDom($resultSetDom)
    {
        return $resultSetDom->find('[class*="number"]')->find('span');
    }

    /**
     * @param $resultDom
     * @return mixed
     */
    protected function getGameDate($resultDom)
    {
        return $this->formatDate($resultDom->find('td', 1)->text);
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
        $resultsSet = [];
        foreach ($this->getResultsSetDom() as $resultSetDom) {
            foreach ($this->getResultsDom($resultSetDom) as $resultDom) {
                $results = [];
                foreach ($this->getNumbersDom($resultDom) as $numberDom) {
                    if (!is_numeric($numberDom->text)) {
                        continue;
                    }
                    $results[] = $numberDom->text;
                }

                $resultsSet[] = [
                    'gameName' => 'EuroJackpot',
                    'gameDate' => $this->getGameDate($resultSetDom),
                    'numbers' => $results
                ];
            }
        }

        return $resultsSet;
    }
}