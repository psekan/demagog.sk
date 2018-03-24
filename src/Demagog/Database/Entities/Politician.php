<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 6:52 PM
 */

namespace Demagog\Database\Entities;


class Politician extends AssertionsEntity implements \JsonSerializable
{
    /**
     * @var int
     */
    private $correct;

    /**
     * @var int
     */
    private $lie;

    /**
     * @var int
     */
    private $juggle;

    /**
     * @var int
     */
    private $unverifiable;

    /**
     * @var string
     */
    private $politicalParty;

    /**
     * Politician constructor.
     * @param string $name
     * @param string $politicalParty
     * @param int $correct
     * @param int $lie
     * @param int $juggle
     * @param int $unverifiable
     */
    public function __construct($name, $politicalParty = 'unknown', $correct = 0, $lie = 0, $juggle = 0, $unverifiable = 0)
    {
        $this->correct = $correct;
        $this->lie = $lie;
        $this->juggle = $juggle;
        $this->unverifiable = $unverifiable;
        $this->name = $name;
        $this->politicalParty = $politicalParty;
    }

    /**
     * @return int
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * @return int
     */
    public function getLie()
    {
        return $this->lie;
    }

    /**
     * @return int
     */
    public function getJuggle()
    {
        return $this->juggle;
    }

    /**
     * @return int
     */
    public function getUnverifiable()
    {
        return $this->unverifiable;
    }

    /**
     * @return string
     */
    public function getPoliticalParty()
    {
        return $this->politicalParty;
    }

    public function __toString()
    {

        return sprintf("%s %s [%4d]: %7s / %7s / %7s / %7s",
            self::justify($this->name, 24),
            self::justify("(" . $this->politicalParty . ")", 16, false),
            $this->getAssertionsCount(),
            $this->percentageValue($this->getCorrect()),
            $this->percentageValue($this->getLie()),
            $this->percentageValue($this->getJuggle()),
            $this->percentageValue($this->getUnverifiable()));
    }

    public function jsonSerialize()
    {
        return json_encode([
            "name" => $this->name,
            "politicalParty" => $this->politicalParty,
            "correct" => $this->correct,
            "lie" => $this->lie,
            "juggle" => $this->juggle,
            "unverifiable" => $this->unverifiable
        ]);
    }


}