<?php

class CatBeeExpressions
{
    public static function validateString($string)
    {
        RestLogger::log("---old string", $string);

        if (strpos($string, "{Rest_url}") !== false)
        {
            $newString = str_replace("{Rest_url}", $GLOBALS['catBeeParams']['Rest_url'], $string);
            RestLogger::log("---replaced", $newString);

            return $newString;
        }
        return $string;
    }

}
