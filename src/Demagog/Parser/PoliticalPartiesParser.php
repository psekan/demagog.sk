<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 3/20/2018
 * Time: 11:20 AM
 */

namespace Demagog\Parser;


class PoliticalPartiesParser
{
    const STR_BEGIN = 'dataTableStrany.addRows(';
    const STR_END = ');';
    const RESULT_TRUE = 0;
    const RESULT_FALSE = 1;
    const RESULT_WARN = 2;
    const RESULT_UNKNOWN = 3;

    public static function parse() {
        $pageContent = file_get_contents('http://www.demagog.sk/statistiky');
        if ($pageContent === false) {
            return false;
        }
        $startPos = strpos($pageContent, self::STR_BEGIN);
        if ($startPos === false) return false;
        $endPos = strpos($pageContent, self::STR_END, $startPos);
        if ($endPos === false) return false;
        $startLen = strlen(self::STR_BEGIN);
        $substring = substr($pageContent, $startPos + $startLen, $endPos - ($startPos + $startLen));
        $substring = str_replace("'",'"', $substring);
        $substring = preg_replace('/],\s*]/i', ']]', $substring);
        $decoded = json_decode($substring);
        $result = [];
        foreach ($decoded as $item) {
            $result[$item[0]] = [
                self::RESULT_TRUE => $item[1],
                self::RESULT_FALSE => $item[2],
                self::RESULT_WARN => $item[3],
                self::RESULT_UNKNOWN => $item[4]
            ];
        }
        return $result;
    }
}