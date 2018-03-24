<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/23/2018
 * Time: 1:50 PM
 */

namespace Demagog\Database\Entities;


abstract class AssertionsEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public abstract function getCorrect();

    /**
     * @return int
     */
    public abstract function getLie();

    /**
     * @return int
     */
    public abstract function getJuggle();

    /**
     * @return int
     */
    public abstract function getUnverifiable();

    /**
     * @return int
     */
    public function getAssertionsCount() {
        return $this->getCorrect() + $this->getLie() + $this->getJuggle() + $this->getUnverifiable();
    }

    /**
     * @param int $value
     * @return float
     */
    public function getPercentageFrom($value) {
        $all = $this->getAssertionsCount();
        return ($all == 0 ? 0 : $value/$all)*100;
    }

    /**
     * @param int $value
     * @return string
     */
    protected function percentageValue($value) {
        return number_format($this->getPercentageFrom($value), 2) . '%';
    }

    public static function justify($str, $width, $toLeft = true, $char = ' ') {
        while (mb_strlen($str) < $width) {
            $str = (!$toLeft ? $char : '') . $str . ($toLeft ? $char : '');
        }
        return $str;
    }
}