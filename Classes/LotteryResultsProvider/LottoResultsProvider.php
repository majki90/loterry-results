<?php

Namespace Classes\LotteryResultsProvider;

class LottoResultsProvider extends EurojackpotResultsProvider
{
    public function __construct()
    {
        $this->setUrl(self::LOTTO_URL);
    }

    /**
     * @return mixed
     */
    protected function getResultsDom($resultSetDom)
    {
        return $resultSetDom->find('[class*="sortkolejnosc"], [class*="lottoSzansa"]');
    }

    /**
     * @param $resultSetDom
     * @return mixed
     */
    protected function getGameName($resultSetDom)
    {
        return $resultSetDom->find('img')->getAttribute('alt');
    }

    /**
     * @param $resultSetDom
     * @return mixed
     */
    protected function getGameDate($resultSetDom)
    {
        return $this->formatDate($resultSetDom->find('td', 2)->text);
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
                    'gameName' => $this->getGameName($resultSetDom),
                    'gameDate' => $this->getGameDate($resultSetDom),
                    'numbers' => $results
                ];
            }
        }

        return $resultsSet;
    }
}