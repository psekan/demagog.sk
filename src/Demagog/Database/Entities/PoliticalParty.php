<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 6:51 PM
 */

namespace Demagog\Database\Entities;


use Demagog\Helpers\Filter;
use Demagog\Helpers\Sort;

class PoliticalParty extends AssertionsEntity
{
    /**
     * @var Politician[]
     */
    private $politicians;

    /**
     * PoliticalParty constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return Politician[]
     */
    public function getPoliticians()
    {
        return $this->politicians;
    }

    /**
     * @param Politician $politician
     */
    public function addPolitician($politician) {
        $this->politicians[] = $politician;
    }

    /**
     * @return int
     */
    public function getCorrect()
    {
        return array_sum(array_map(function (Politician $politician) {
            return $politician->getCorrect();
            }, $this->politicians));
    }

    /**
     * @return int
     */
    public function getLie()
    {
        return array_sum(array_map(function (Politician $politician) {
            return $politician->getLie();
        }, $this->politicians));
    }

    /**
     * @return int
     */
    public function getJuggle()
    {
        return array_sum(array_map(function (Politician $politician) {
            return $politician->getJuggle();
        }, $this->politicians));
    }

    /**
     * @return int
     */
    public function getUnverifiable()
    {
        return array_sum(array_map(function (Politician $politician) {
            return $politician->getUnverifiable();
        }, $this->politicians));
    }

    public function __toString()
    {
        return sprintf("%s [%4d]: %7s / %7s / %7s / %7s",
            self::justify($this->name, 12),
            $this->getAssertionsCount(),
            $this->percentageValue($this->getCorrect()),
            $this->percentageValue($this->getLie()),
            $this->percentageValue($this->getJuggle()),
            $this->percentageValue($this->getUnverifiable()));
    }

    /**
     * @return Politician
     */
    public function medianPolitician() {
        $arr = Filter::byAssertions($this->politicians, 1);
        Sort::byCorrect($arr);
        if (count($arr) == 0) {
            return new Politician('Median' , $this->getName());
        }
        if (count($arr) % 2 == 1) {
            $medianPolitician = $arr[intval(floor(count($arr) / 2))];
            return new Politician('Median - ' . $medianPolitician->getName(), $this->getName(), $medianPolitician->getCorrect(), $medianPolitician->getLie(), $medianPolitician->getJuggle(), $medianPolitician->getUnverifiable());
        }
        else {
            $medianPolitician1 = $arr[intval(floor(count($arr) / 2))];
            $medianPolitician2 = $arr[intval(floor(count($arr) / 2)-1)];
            return new Politician('Median - ' . $medianPolitician1->getName() . '/' . $medianPolitician2->getName(), $this->getName(),
                floor(($medianPolitician1->getCorrect() + $medianPolitician2->getCorrect())/2),
                floor(($medianPolitician1->getLie() + $medianPolitician2->getLie())/2),
                floor(($medianPolitician1->getJuggle() + $medianPolitician2->getJuggle())/2),
                floor(($medianPolitician1->getUnverifiable() + $medianPolitician2->getUnverifiable())/2));
        }
    }
}