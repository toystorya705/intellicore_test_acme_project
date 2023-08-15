<?php

namespace RandomPasswordGenerator;

use App\Models\AccessCode;

class RandomPasswordGenerator
{
    /**
     * Generates a random password of the specified length.
     *
     * @param int $length
     * @return string
     */
    public static function generate($length = 6)
    {
        $characters = '0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $password;
    }

    /**
     * Generates a random password that meets specified conditions.
     *
     * @param int $length
     * @param int $userId
     * @return string
     */
    public static function generateWithCondition($length = 6, $userId = 1)
    {
        do {
            $code = self::generate($length);
        } while (self::isPalindrome($code) && self::hasRepeatedCharacters($code, 3) && self::hasSequentialCharacters($code, 4) && self::countUniqueCharacters($code) < 3);

        return $code;
    }

    /**
     * Generates a random password and checks if it already exists in the database.
     *
     * @return string
     */
    public static function generateRandomPasswordWithCheckInDatabase()
    {
        do {
            $password = RandomPasswordGenerator::generateWithCondition();
            $existingCode = AccessCode::where('access_code', $password)->first();
        } while ($existingCode);

        return $password;
    }

    /**
     * Checks if a string is a palindrome.
     *
     * @param string $string
     * @return bool
     */
    public static function isPalindrome($string)
    {
        $string = str_replace(' ', '', strtolower($string));
        $reverse = strrev($string);

        return $string === $reverse;
    }

    /**
     * Checks if a string has repeated characters more than a specified limit.
     *
     * @param string $string
     * @param int $maxRepeats
     * @return bool
     */
    public static function hasRepeatedCharacters($string, $maxRepeats)
    {
        $characterCounts = [];
        foreach (str_split($string) as $char) {
            if (!isset($characterCounts[$char])) {
                $characterCounts[$char] = 1;
            } else {
                $characterCounts[$char]++;
            }
            if ($characterCounts[$char] > $maxRepeats) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if a string has sequential characters.
     *
     * @param string $code
     * @param int $maxSequenceLength
     * @return bool
     */
    public static function hasSequentialCharacters($code, $maxSequenceLength)
    {
        $codeStr = strval($code);
        $sequenceLength = 1;

        for ($i = 1; $i < strlen($codeStr); $i++) {
            $currentDigit = intval($codeStr[$i]);
            $previousDigit = intval($codeStr[$i - 1]);

            if ($currentDigit === $previousDigit + 1) {
                $sequenceLength++;
                if ($sequenceLength > $maxSequenceLength) {
                    return true;
                }
            } else {
                $sequenceLength = 1;
            }
        }

        return false;
    }

    /**
     * Counts the number of unique characters in a string.
     *
     * @param string $string
     * @return int
     */
    public static function countUniqueCharacters($string)
    {
        return count(array_count_values(str_split($string)));
    }
}