<?php

namespace takvol\FakeUUE;

/**
 * Simulate Richard Marks's MS-DOS uuencode utility
 */
class FakeUUE {
    /**
     * Calculate 16 bit BSD checksum
     * @param string $str content
     * @return int checksum
     */
    public static function crc16($str) {
        $checksum = 0;
        $hexStr = unpack('H*', $str)[1];

        for ($i = 0; $i < strlen($hexStr); $i += 2) {
            $ch = hexdec($hexStr[$i] . $hexStr[$i + 1]);
            $checksum = ($checksum >> 1) + (($checksum & 1) << 15);
            $checksum += $ch;
            $checksum &= 0xffff;
        }

        return $checksum;
    }

    /**
     * Encode message like windows uuencode
     * @param string $filename Message filename
     * @param string $str Message content
     * @return string uuencoded message text with checksums
     */
    public static function encode($filename, $str) {
        $encoded_str = "begin 644 $filename\r\n" . str_replace("\n", "\r\n", convert_uuencode($str)) . "end\r\n";
        $control_summ = self::crc16(str_replace("\r\n", "\n", $encoded_str));
        $str_length = strlen(str_replace("\r\n", "\n", $encoded_str));
        $output =
          "section 1 of uuencode 5.21 of file " . $filename . "    by R.E.M.\r\n\r\n" .
          $encoded_str .
          "sum -r/size " . $control_summ . "/" . $str_length . " section (from \"begin\" to \"end\")\r\n" .
          "sum -r/size " . self::crc16($str)."/". strlen($str) ." entire input file";

        return $output;
    }
}
