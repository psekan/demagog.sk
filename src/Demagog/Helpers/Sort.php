<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/23/2018
 * Time: 2:03 PM
 */

namespace Demagog\Helpers;


use Demagog\Database\Entities\AssertionsEntity;

class Sort
{
    const ORDER_ASC = 1;
    const ORDER_DESC = -1;

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byName(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getName');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byCorrect(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getCorrect');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byLie(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getLie');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byJuggle(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getJuggle');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byUnverifiable(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getUnverifiable');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @return AssertionsEntity[]
     */
    public static function byNumOfAssertions(array &$array, $order = self::ORDER_ASC) {
        self::sortByFunction($array, $order, 'getAssertionsCount');
        return $array;
    }

    /**
     * @param AssertionsEntity[] $array
     * @param int $order ORDER_ASC|ORDER_DESC
     * @param string $functionName
     */
    private static function sortByFunction(array &$array, $order = self::ORDER_ASC, $functionName) {
        usort($array, function (AssertionsEntity $a, AssertionsEntity $b) use ($order, $functionName) {
            $ap = $a->getPercentageFrom(call_user_func([$a, $functionName]));
            $bp = $b->getPercentageFrom(call_user_func([$b, $functionName]));
            if ($ap == $bp) return 0;
            return $order * (($ap > $bp) ? -1 : 1);
        });
    }
}