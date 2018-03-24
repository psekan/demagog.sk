<?php
namespace Demagog\Cli\Command;

use Demagog\Database\Entities\PoliticalParty;
use Demagog\Helpers\Filter;
use Demagog\Helpers\Sort;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PoliticiansCommand extends BaseCommand {
  /**
   * Configuration
   * @return void
   */
  protected function configure() {
    $this->setName("politicians")
        ->setDescription("Print politicians")
        ->addOption('relevant', 'r', InputOption::VALUE_NONE, 'Show only relevant politicians.')
        ->addOption('relevant-limit', 't', InputOption::VALUE_OPTIONAL, 'Limit for relevant parties.', 10)
        ->addOption('party', 'p', InputOption::VALUE_REQUIRED, 'Show politician only from a party.')
        ->addOption('sort-correct', 'c', InputOption::VALUE_NONE, 'Sort politicians by correct answers.')
        ->addOption('sort-lie', 'l', InputOption::VALUE_NONE, 'Sort politicians by lies answers.')
        ->addArgument('name', InputArgument::OPTIONAL, 'Show only politicians with a name.');

  }

  /**
   * Executes the command
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
      $partyName = $input->getOption('party');
      if ($partyName) {
          $parties = $this->getDatabase()->findPoliticalParty($partyName);
          $politicians = call_user_func_array('array_merge', array_map(function (PoliticalParty $politicalParty) {
              return $politicalParty->getPoliticians();
          }, $parties)+[[]]);
      }
      else {
          $politicians = $this->getDatabase()->getPoliticians();
      }
      $politicianName = $input->getArgument('name');
      if ($politicianName) {
          $politicians = Filter::byName($politicians, $politicianName);
      }
      if ($input->getOption('relevant')) {
          $politicians = Filter::byAssertions($politicians, $input->getOption('relevant-limit'));
      }
      if ($input->getOption('sort-lie')) {
          Sort::byLie($politicians);
      }
      if ($input->getOption('sort-correct')) {
          Sort::byCorrect($politicians);
      }

      echo "Politician (party) [assertions]: correct / lies / juggle / non-verifiable" . PHP_EOL;
      $i = 1;
      foreach ($politicians as $politician) {
          echo sprintf('#%03d ',$i) . $politician . PHP_EOL;
          $i++;
      }
  }
}
