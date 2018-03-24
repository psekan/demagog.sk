<?php
namespace Demagog\Cli\Command;

use Demagog\Database\Entities\PoliticalParty;
use Demagog\Helpers\Filter;
use Demagog\Helpers\Sort;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PoliticalPartiesCommand extends BaseCommand {
  /**
   * Configuration
   * @return void
   */
  protected function configure() {
    $this->setName("parties")
        ->setDescription("Print political parties")
        ->addOption('relevant', 'r', InputOption::VALUE_NONE, 'Show only relevant parties.')
        ->addOption('median', 'm', InputOption::VALUE_NONE, 'Show median of each party.')
        ->addOption('relevant-limit', 't', InputOption::VALUE_OPTIONAL, 'Limit for relevant parties.', 50)
        ->addOption('sort-correct', 'c', InputOption::VALUE_NONE, 'Sort parties by correct answers.')
        ->addOption('sort-lie', 'l', InputOption::VALUE_NONE, 'Sort parties by lies answers.');
  }

  /**
   * Executes the command
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
      $parties = $this->getDatabase()->getPoliticalParties();
      if ($input->getOption('relevant')) {
          $parties = Filter::byAssertions($parties, $input->getOption('relevant-limit'));
      }
      if ($input->getOption('median')) {
          $parties = array_map(function (PoliticalParty $politicalParty) {
              return $politicalParty->medianPolitician();
          },$parties);
      }
      if ($input->getOption('sort-lie')) {
          Sort::byLie($parties);
      }
      if ($input->getOption('sort-correct')) {
          Sort::byCorrect($parties);
      }

      $i = 1;
      echo "Party name [assertions]: correct / lies / juggle / non-verifiable" . PHP_EOL;
      foreach ($parties as $politicalParty) {
          echo sprintf('#%02d ',$i) . $politicalParty. PHP_EOL;
          $i++;
      }
  }
}
