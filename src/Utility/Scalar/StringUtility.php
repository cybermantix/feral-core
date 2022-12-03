<?php


namespace Nodez\Core\Utility\Scalar;

use InvalidArgumentException;
use Nodez\Core\Utility\Set\ArrayUtility;

/**
 * Class StringUtility
 * Functions used to help with strings.
 *
 * @package Nodez\Core\Utility\Scalar
 */
class StringUtility
{
    const DELETED_VALUE = '-DELETED-';

    /**
     * Generate a random string with a character set and a length.
     *
     * @param  array $characterSet
     * @param  int   $length
     * @return string
     * @throws \Exception
     */
    public function randomGenerator(array $characterSet, int $length): string
    {
        $length = abs($length);
        $pieces = [];
        $max = count($characterSet) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $characterSet[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * Replace template variables in a template string.
     *
     * @param  string $templateString
     * @param  array  $values
     * @param  string $wrapper
     * @return string
     */
    public function replace(string $templateString, array $values, string $wrapper = '%'): string
    {
        foreach ($values as $key => $value) {
            $templateString = str_replace($wrapper . $key . $wrapper, $value, $templateString);
        }
        return $templateString;
    }

    /**
     * Merge an array of JSON strings
     *
     * @param  array  $jsonStrings
     * @param  string $deletedValue
     * @return string
     */
    public function mergeJsonStrings(array $jsonStrings, string $deletedValue = self::DELETED_VALUE): string
    {
        $arrayUtility = new ArrayUtility();
        $finalData = [];
        $isFirst = true;
        foreach ($jsonStrings as $jsonString) {
            $error = $this->checkJsonError($jsonString);
            if ($error) {
                throw new InvalidArgumentException(sprintf('Invalid JSON string "%s"', $error));
            }
            if ($isFirst) {
                $finalData = json_decode($jsonString, true);
                $isFirst = false;
            } else {
                $data = json_decode($jsonString, true);
                $deletedKeyMap = $arrayUtility->deepSearch(self::DELETED_VALUE, $data);
                $data = $arrayUtility->deepRemoval($deletedKeyMap, $data, true);
                $finalData = $arrayUtility->deepRemoval($deletedKeyMap, $finalData, true);
                $finalData = array_replace_recursive($finalData, $data);
            }
        }
        return json_encode($finalData);
    }

    /**
     * Null is valid JSON!
     *
     * @param  string $jsonString
     * @return string|null
     */
    public function checkJsonError(string $jsonString): ?string
    {
        $jsonString = trim($jsonString);
        if (!in_array(substr($jsonString, 0, 1), ['{', '['])) {
            return 'Invalid JSON, the first character must be a "{" or "[".';
        } elseif (!in_array(substr($jsonString, -1), ['}', ']'])) {
            return 'Invalid JSON, the last character must be a "{" or "[".';
        }
        json_decode($jsonString);
        switch (json_last_error()) {
        case JSON_ERROR_NONE:
            return null;
        case JSON_ERROR_DEPTH:
            return 'The maximum stack depth has been exceeded.';
        case JSON_ERROR_STATE_MISMATCH:
            return 'Invalid or malformed JSON.';
        case JSON_ERROR_CTRL_CHAR:
            return 'Control character error, possibly incorrectly encoded.';
        case JSON_ERROR_SYNTAX:
            return 'Syntax error, malformed JSON.';
        case JSON_ERROR_UTF8:
            return 'Malformed UTF-8 characters, possibly incorrectly encoded.';
        case JSON_ERROR_RECURSION:
            return 'One or more recursive references in the value to be encoded.';
        case JSON_ERROR_INF_OR_NAN:
            return 'One or more NAN or INF values in the value to be encoded.';
        case JSON_ERROR_UNSUPPORTED_TYPE:
            return 'A value of a type that cannot be encoded was given.';
        default:
            return 'Unknown JSON error occurred.';
        }
    }

    public function getUuidV3($namespace, $name)
    {
        if(!self::is_valid($namespace)) { return false;
        }

        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-','{','}'), '', $namespace);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }

        // Calculate hash value
        $hash = md5($nstr . $name);

        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),
            // 16 bits for "time_mid"
            substr($hash, 8, 4),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 3
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    public function getUuidV4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function getUuidV5($namespace, $name)
    {
        if(!self::is_valid($namespace)) { return false;
        }

        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-','{','}'), '', $namespace);

        // Binary Value
        $nstr = '';

        // Convert Namespace UUID to bits
        for($i = 0; $i < strlen($nhex); $i+=2) {
            $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }

        // Calculate hash value
        $hash = sha1($nstr . $name);

        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            // 32 bits for "time_low"
            substr($hash, 0, 8),
            // 16 bits for "time_mid"
            substr($hash, 8, 4),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 5
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits for "node"
            substr($hash, 20, 12)
        );
    }

    public function isValidUuid($uuid)
    {
        return preg_match(
            '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
            '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid
        ) === 1;
    }

}
