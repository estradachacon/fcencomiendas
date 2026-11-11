<?php

namespace App\Libraries;

class Base62Converter
{
    private const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public static function encode(int $num): string
    {
        if ($num === 0) return '0';

        $result = '';
        while ($num > 0) {
            $result = self::CHARS[$num % 62] . $result;
            $num = intdiv($num, 62);
        }
        return $result;
    }

    public static function decode(string $str): int
    {
        $num = 0;
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $num = $num * 62 + strpos(self::CHARS, $str[$i]);
        }
        return $num;
    }
}
