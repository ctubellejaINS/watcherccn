<?php

namespace Tools;

class helper
{

    public function number_format_dec_comma($number)
    {

        return number_format($number, 2, '.', ',');

    }

    public function whitespace($field)
    {
        return preg_replace('/[\x00-\x1F\x7F]/', '', $field);
    }

    public function parseToXML1($htmlStr)
    {
        $xmlStr = str_replace('<', '&lt;', $htmlStr);
        $xmlStr = str_replace('>', '&gt;', $xmlStr);
        $xmlStr = str_replace('"', '&quot;', $xmlStr);
        $xmlStr = str_replace("'", '&#39;', $xmlStr);
        $xmlStr = str_replace("&", '&amp;', $xmlStr);
        return $xmlStr;
    }

    public function parseToXML($htmlStr)
    {
        $xmlStr = str_replace('<', '', $htmlStr);
        $xmlStr = str_replace('>', '', $xmlStr);
        $xmlStr = str_replace('"', '', $xmlStr);
        $xmlStr = str_replace("'", '', $xmlStr);
        return $xmlStr;
    }

    public function specialChar($xmlStr)
    {
        $xmlStr = str_replace('¥', 'N', $xmlStr);
        $xmlStr = str_replace("#", 'No.', $xmlStr);
        $xmlStr = str_replace('?', 'N', $xmlStr);
        return $xmlStr;
    }

    public function removeAccents($str)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó',
                   'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é',
                   'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā',
                   'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ',
                   'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ',
                   'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ',
                   'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ',
                   'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ',
                   'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż',
                   'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ',
                   'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί',
                   'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O',
                   'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e',
                   'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A',
                   'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E',
                   'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I',
                   'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L',
                   'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe',
                   'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't',
                   'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z',
                   'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U',
                   'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι',
                   'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }

    public function get_string_between($string, $start, $end)
    {
        $string = " " . $string;
        $ini    = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = abs(strpos($string, $end, $ini) - $ini);
        return substr($string, $ini, $len);
    }

    public function cleanStr($field)
    {
        $cleanStr = $this->whitespace($field);
        $cleanStr = $this->parseToXML($cleanStr);
        $cleanStr = utf8_decode($cleanStr);
        $cleanStr = $this->specialChar($cleanStr);
        $cleanStr = $this->removeAccents($cleanStr);

        return $cleanStr;
    }

    public function checkNull($str)
    {
        if (strlen($this->cleanStr($str)) == 0 || empty($str) || $str == '' || $str == null) {
            return true;
        }
        return false;
    }

    public function IsNull($str)
    {
        if ($str == '' || $str == null) {
            return true;
        }
        return false;
    }

    public function SetIfNull($str)
    {
        //** if null
        if ($str == '' || $str == null || empty($str)) {
            $str = null;
        }
        return $str;
    }

    public function CheckNumeric($str)
    {
        if (is_numeric($str)) {
            return true;
        }
        return false;
    }

    public function check_file_exists($dir)
    {
        if (file_exists($dir)) {
            return true;
        } else {
            return false;
        }
    }

    public function check_dir($curdir)
    {
        /**_DIR_+FILE***/
        if (is_dir($curdir)) {
            return true;
        } else {
            return false;
        }
    }

    public function scan_dir($dir)
    {
        $scanned_dir = scandir($dir);
        if (!$scanned_dir) {
            return array();
        } else {
            return $scanned_dir;
        }
    }

    public function scan_glob($dir, $filetype)
    {
        $scanned_dir = glob($dir . $filetype);
        if (!$scanned_dir) {
            return array();
        } else {
            return $scanned_dir;
        }
    }

    public function move_file($old, $new)
    {
        $moved = rename($old, $new);
        if ($moved) {
            return true;
        } else {
            return false;
        }
    }

    public function file_open($file)
    {
        /**_DIR_+FILE***/
        $myfile   = fopen($file, "r");
        $fileRead = fread($myfile, filesize($file));

        fclose($myfile);

        return $fileRead;
    }

    public function file_write($file, $str)
    {

        $TxtFile = fopen($file, "w") or die("Unable to create file!");
        fwrite($TxtFile, $str);
        fclose($TxtFile);

        return true;

    }

    public function create_dir($curdir)
    {
        // Desired folder structure
        $new_dir = $curdir;

        // To create the nested structure, the $recursive parameter
        // to mkdir() must be specified.
        if (!mkdir($new_dir, 0777, true)) {
            //die('Failed to create folders...');
            return false;

        }
        return true;
    }

    public function CheckIfNumeric($str)
    {
        if (!is_numeric($str)) {
            return false;
        }

        return true;
    }

    public function InsertZeroFirst($num, $str)
    {
        $n = '%0' . $num . 'd';
        return sprintf($n, $str);
    }

    public function IsArray($str)
    {

        if (is_array($str)) {
            return true;
        }

        return false;

    }

    public function HasContain($str, $ref)
    {
        if (strpos($str, $ref) !== false) {
            return true;
        }
        return false;
    }

    public function splitAddress($address)
    {
        // Trim the entire address to remove leading and trailing white spaces
        $trimmedAddress = trim($address);

        // Initialize an empty array to store the chunks
        $chunks = array();

        // Process the address in chunks
        while (strlen($trimmedAddress) > 0) {
            // Get the next chunk of up to 35 characters
            $chunk = substr($trimmedAddress, 0, 35);

            // Trim the chunk to remove leading and trailing white spaces
            $chunk = trim($chunk);

            // Add the chunk to the chunks array
            $chunks[] = $chunk;

            // Remove the chunk from the address and trim leading white spaces
            $trimmedAddress = ltrim(substr($trimmedAddress, 35));
        }

        // Ensure each chunk is exactly 35 characters by padding with spaces
        $exactChunks = array_map(function ($chunk) {
            return str_pad($chunk, 35, ' ');
        }, $chunks);

        return $exactChunks;
    }

    public function split_address_strict($address_raw, $line_length = 35)
    {
        $address      = array();
        $total_length = strlen($address_raw);
        $address_raw  = trim($address_raw); // Trim leading and trailing whitespaces initially

        $i = 0;
        while ($i < $total_length) {
            $current_length = $line_length;
            $current_line   = substr($address_raw, $i, $current_length);

            // If the current line has leading or trailing whitespace, trim it
            if (strlen(trim($current_line)) == $line_length) {
                $current_line = trim($current_line);
            } else {
                // Extend the substring length if it's less than 35 characters after trimming
                while (strlen(ltrim($current_line)) < $line_length && ($i + $current_length) < $total_length) {
                    $current_length++;
                    $current_line = substr($address_raw, $i, $current_length);
                }
            }

            // Ensure the current line is exactly 35 characters by padding if necessary
            $current_line = str_pad($current_line, $line_length, " ");
            $address[]    = $current_line;

            // Update the start position for the next iteration
            $i += $current_length;
        }

        return $address;
    }

    public function backupSFTPFileLocallymoveFile($sftp, $dir, $file, $filename = NULL, $is_error = false)
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Asia/Manila'));
        $year  = $now->format('Y');
        $month = $now->format('m');
        $day   = $now->format('d');

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $dir = $is_error ? $dir . "\\error" : $dir . "\\success";

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $dir = $dir . "\\" . $year;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $dir = $dir . "\\" . $month;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $dir = $dir . "\\" . $day;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        if (!$filename) {
            $filename = basename($file);
        }

        if (file_exists($dir . '\\' . $filename)) {
            echo "deleted duplicate file: $filename \r\n";
            unlink($dir . '\\' . $filename);
        }

        $copy = file_put_contents($dir . "\\" . $filename, $sftp->get($file));

        if ($copy) {
            $sftp->delete($file);
            return true;
        }

        return false;
    }

    public function scanSharedFolders($folderPath, $excludeFolders = array())
    {
        $result = array();

        // Check if the folder exists
        if (!is_dir($folderPath)) {
            die("Error: Folder not found - $folderPath");
        }

        // Get the list of items in the folder
        $contents = scandir($folderPath);

        foreach ($contents as $item) {
            // Skip "." and ".."
            if ($item == '.' || $item == '..') {
                continue;
            }

            $fullPath = $folderPath . DIRECTORY_SEPARATOR . $item;

            // Check if the item is a directory (shared folder)
            if (file_exists($fullPath) && !in_array($item, $excludeFolders)) {
                $result[] = $fullPath; // Only add directories to the result
            }
        }

        return $result;
    }

    public function moveFileLocally($directory, $file, $is_error = false)
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Asia/Manila'));

        $year  = $now->format('Y');
        $month = $now->format('m');
        $day   = $now->format('d');

        // Use consistent directory separators
        $base_dir = '\\\\192.168.1.108\\E2M_Res_Backup';
        $dir      = $base_dir . DIRECTORY_SEPARATOR . $directory;

        // Create base folder if it doesn't exist
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // Append success or error folder
        $dir .= $is_error ? DIRECTORY_SEPARATOR . "error" : DIRECTORY_SEPARATOR . "success";

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // Create year, month, and day subfolders
        $dir .= DIRECTORY_SEPARATOR . $year;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $dir .= DIRECTORY_SEPARATOR . $month;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $dir .= DIRECTORY_SEPARATOR . $day;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // Prepare file paths
        $filename = basename($file);
        $destFile = $dir . DIRECTORY_SEPARATOR . $filename;

        // Check for duplicates and delete if necessary
        if (file_exists($destFile)) {
            echo "Deleted duplicate file: $filename \r\n";
            unlink($destFile);
        }

        // Copy the file to the shared folder
        if (copy($file, $destFile)) {
            unlink($file);  // Delete the original after successful backup
            return true;
        }

        return false;
    }

}


?>