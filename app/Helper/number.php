<?php

namespace app\Helper\Number;

if (! function_exists('romanic_number')) {
    function romanic_number($integer, $upcase = true){
        $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
        $return = '';
        while($integer > 0)
        {
            foreach($table as $rom=>$arb)
            {
                if($integer >= $arb)
                {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }

        return $return;
    }
}

if (! function_exists('simple_romanic_number')) {
    function simple_romanic_number($integer){
        $data = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
        ];

        return isset($data[$integer]) ? $data[$integer] : null;
    }
}