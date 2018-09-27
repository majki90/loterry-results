<?php
error_reporting(1);
require __DIR__ . '/vendor/autoload.php';

$elGordoProvider = new Classes\LotteryResultsProvider\elGordoResultsProvider();
$euroJackpotProvider = new Classes\LotteryResultsProvider\EurojackpotResultsProvider();
$lottoProvider = new Classes\LotteryResultsProvider\LottoResultsProvider();

echo (json_encode(
    [
        'lotteryResults' => [
            'elGordo' => $elGordoProvider->getResults(),
            'EuroJackpot' => $euroJackpotProvider->getResults(),
            'Lotto' => $lottoProvider->getResults()
        ]
    ]
));

