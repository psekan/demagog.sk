<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 8:54 PM
 */

namespace Demagog\Cli\Command;


use Demagog\Database\Database;
use Demagog\Database\JSON\JSONDatabase;
use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{
    protected static $db = null;

    /**
     * @return Database
     */
    protected function getDatabase() {
        if (BaseCommand::$db === null){
            BaseCommand::$db = new JSONDatabase();
        }
        return BaseCommand::$db;
    }
}