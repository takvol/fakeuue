<?php

namespace takvol\FakeUUE;

/**
 * Simulate Richard Marks's MS-DOS uuencode utility but with additional converting of the incoming message to cp866
 */
class UAFakeUUE extends FakeUUE {
    /**
     * {@inheritdoc}
     */
    public static function encode($filename, $str) {
        $str = self::convertTo866($str);
        $filename = self::convertTo866($filename);

        return parent::encode($filename, $str);
    }

    private static function convertTo866($str) {
        return mb_convert_encoding(str_replace(['і','І','ґ','Ґ'], ['i','I','г','Г'], $str), 'cp866');
    }
}
