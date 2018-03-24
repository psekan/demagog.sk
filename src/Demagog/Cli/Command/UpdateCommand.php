<?php
namespace Demagog\Cli\Command;

use Demagog\Parser\PoliticianParser;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends BaseCommand {
  /**
   * Configuration
   * @return void
   */
  protected function configure() {
    $this->setName("update")
          ->setDescription("Update database with actual data from website");
  }

  /**
   * Executes the command
   *
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
      PoliticianParser::updateDatabase($this->getDatabase());
  }
}
