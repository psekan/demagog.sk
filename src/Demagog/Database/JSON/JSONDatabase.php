<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 7:11 PM
 */

namespace Demagog\Database\JSON;


use Demagog\Database\Database;
use Demagog\Database\Entities\PoliticalParty;
use Demagog\Database\Entities\Politician;
use Demagog\Helpers\Filter;

class JSONDatabase extends Database
{
    const FILE_EXTENSION = '.json';

    /**
     * @var PoliticalParty[]
     */
    private $politicalParties;

    /**
     * @var string
     */
    private $dir;

    /**
     * JSONDatabase constructor.
     * @param string $dir
     */
    public function __construct($dir = TMP_DIR)
    {
        $this->politicalParties = [];
        $this->dir = $dir;
        $this->load();
    }

    private function load() {
        if (!file_exists($this->dir)) {
            mkdir($this->dir);
        }
        $files = $this->listOfFiles();
        foreach ($files as $file) {
            $politician = $this->createPoliticianFromJson(file_get_contents($this->dir.'/'.$file));
            if (!array_key_exists($politician->getPoliticalParty(), $this->politicalParties)) {
                $this->politicalParties[$politician->getPoliticalParty()] = new PoliticalParty($politician->getPoliticalParty());
            }
            $this->politicalParties[$politician->getPoliticalParty()]->addPolitician($politician);
        }
        ksort($this->politicalParties);
    }

    private function createPoliticianFromJson($json) {
        $obj = json_decode($json);
        return new Politician($obj->name, $obj->politicalParty, $obj->correct, $obj->lie, $obj->juggle, $obj->unverifiable);
    }

    public function findPolitician($name)
    {
        return Filter::byName(call_user_func_array('array_merge',array_map(function (PoliticalParty $politicalParty) {
            return $politicalParty->getPoliticians();
            }, $this->politicalParties)+[[]]), $name);
    }

    public function getPoliticians()
    {
        $politicians = [];
        foreach ($this->politicalParties as $party) {
            $politicians = array_merge($politicians, $party->getPoliticians());
        }
        return $politicians;
    }

    public function findPoliticalParty($name)
    {
        return Filter::byName($this->politicalParties, $name);
    }

    public function getPoliticalParties()
    {
        return array_values($this->politicalParties);
    }

    public function addPolitician($politician)
    {
        do {
            $fileName = tempnam($this->dir, 'p-');
        } while (file_exists($fileName. self::FILE_EXTENSION));
        unlink($fileName);
        file_put_contents($fileName. self::FILE_EXTENSION, $politician->jsonSerialize());
    }

    public function clearDatabase()
    {
        $this->politicalParties = [];
        $files = $this->listOfFiles();
        foreach ($files as $file) {
            unlink($this->dir . '/' . $file);
        }
    }

    /**
     * @return array
     */
    private function listOfFiles() {
        $allFiles = scandir($this->dir);
        $jsonFiles = [];
        foreach ($allFiles as $file) {
            if (substr($file,-strlen(self::FILE_EXTENSION)) == self::FILE_EXTENSION) {
                $jsonFiles[] = $file;
            }
        }
        return $jsonFiles;
    }
}