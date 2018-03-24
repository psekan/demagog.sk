<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

const TMP_DIR = __DIR__.'/tmp';

$app = new Application('Demagog.sk parser');
$app->addCommands([
    new Demagog\Cli\Command\PoliticalPartiesCommand(),
    new Demagog\Cli\Command\PoliticiansCommand(),
    new Demagog\Cli\Command\UpdateCommand()
]);
$app->run();
