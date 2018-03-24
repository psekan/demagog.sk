<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/23/2018
 * Time: 2:32 PM
 */

namespace Demagog\Helpers;


use Demagog\Database\Entities\AssertionsEntity;

class Filter
{
    /**
     * @param AssertionsEntity[] $array
     * @param int $minNumOfAssertions
     * @return AssertionsEntity[]
     */
    public static function byAssertions(array &$array, $minNumOfAssertions) {
        return array_filter($array, function (AssertionsEntity $entity) use ($minNumOfAssertions) {
            return $entity->getAssertionsCount() >= $minNumOfAssertions;
        });
    }

    /**
     * @param AssertionsEntity[] $array
     * @param string $name
     * @return AssertionsEntity[]
     */
    public static function byName(array &$array, $name) {
        $name = self::removeAccents($name);
        return array_filter($array, function (AssertionsEntity $entity) use ($name) {
            return stristr(self::removeAccents($entity->getName()),$name) !== FALSE;
        });
    }

    /**
     * @param string $string
     * @return string
     */
    private static function removeAccents($string) {
        return iconv('utf-8', 'ASCII//TRANSLIT', $string);
    }

}