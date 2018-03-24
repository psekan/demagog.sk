<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 11:20 AM
 */

namespace Demagog\Parser;


use Demagog\Database\Database;
use Demagog\Database\Entities\Politician;

class PoliticianParser
{
    const BASE_URL = 'http://www.demagog.sk/politici';

    public static function updateDatabase(Database $database) {
        $pageContent = file_get_contents(self::BASE_URL);
        if ($pageContent === false) return false;
        preg_match_all("|/politici/(\d{1,5})/|", $pageContent, $matches);
        $ids = $matches[1];
        if (count($ids) == 0) return false;
        $database->clearDatabase();
        echo "Updating database. Downloading " . count($ids) . " politicians:" . PHP_EOL;
        $i = 1;
        foreach ($ids as $id) {
            $politician = self::parsePoliticianPage($id);
            echo $i. " / " . count($ids) . " downloaded" . PHP_EOL;
            if ($politician !== null) {
                $database->addPolitician($politician);
            }
            $i++;
        }
        return true;
    }

    /**
     * @param $id
     * @return Politician|null
     */
    public static function parsePoliticianPage($id) {
        $pageContent = file_get_contents(self::BASE_URL. "/" . $id . "/");
        if ($pageContent === false) return null;
        preg_match("|<h1>\s*(.*) \((.*)\)\s*</h1>|",$pageContent, $matches);
        $name = $matches[1];
        $politicalParty = $matches[2];
        preg_match_all("|<span class=\"veracityNumber\">(\d{1,6}) </span>|", $pageContent, $matches);
        if (count($matches[1]) != 4) {
            var_dump($id);
            var_dump($matches);
            exit(1);
        }
        return new Politician($name, $politicalParty, $matches[1][0], $matches[1][1], $matches[1][2], $matches[1][3]);
    }
}