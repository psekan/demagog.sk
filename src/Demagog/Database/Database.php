<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 7:04 PM
 */

namespace Demagog\Database;


use Demagog\Database\Entities\PoliticalParty;
use Demagog\Database\Entities\Politician;

abstract class Database
{
    /**
     * @param string $name
     * @return Politician[]
     */
    abstract public function findPolitician($name);

    /**
     * @return Politician[]
     */
    abstract public function getPoliticians();

    /**
     * @param string $name
     * @return PoliticalParty[]|null
     */
    abstract public function findPoliticalParty($name);

    /**
     * @return PoliticalParty[]
     */
    abstract public function getPoliticalParties();

    /**
     * Create or update politician by its name
     * @param Politician $politician
     */
    abstract public function addPolitician($politician);

    abstract public function clearDatabase();
}