<?php


namespace Azuriom\Plugin\PlayerFlash\Helpers;


use DateTime;

class OtherTools
{

    /**
     * @param $ms
     * @return string
     */
    public static function ageMs($ms) {
        $second = $ms / 1000;
        $minute = $second / 60;
        $hours = $minute / 60;
        $day = $hours / 24;
        return floor($day) . " j, " . floor($hours - (24 * floor($day))) . " h, " . floor($minute - (60 * floor($hours))) . " m, " . floor($second - (60 * floor($minute))) . " s";
    }

    public static function ageSecond($second) {
        $minute = $second / 60;
        $hours = $minute / 60;
        return floor($hours) . " h, " . floor($minute - (60 * floor($hours))) . " m, " . floor($second - (60 * floor($minute))) . " s";
    }
    
    public static function parseMinecraftColors($string) {
        $string = utf8_decode(htmlspecialchars($string, ENT_QUOTES, "UTF-8"));
        $string = preg_replace('/\xA7([0-9a-f])/i', '<span class="mc-color mc-$1">', $string, -1, $count) . str_repeat("</span>", $count);
        return utf8_encode(preg_replace('/\xA7([k-or])/i', '<span class="mc-$1">', $string, -1, $count) . str_repeat("</span>", $count));
    }

}
