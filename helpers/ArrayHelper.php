<?php

namespace app\helpers;


class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function printTree($TreeArray, $deep=0)
    {
        $padding = str_repeat('  ', $deep*3);

        echo $padding . "<ul>\n";
        foreach($TreeArray as $arr)
        {
            echo $padding . "  <li>\n";
            if(is_array($arr))
            {
                self::printTree($arr, $deep+1);
            }
            else
            {
                echo $padding .'    '. $arr;
            }
            echo $padding . "  </li>\n";
        }
        echo $padding . "</ul>\n";
    }


}