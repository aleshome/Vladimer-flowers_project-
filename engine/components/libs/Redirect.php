<?php
class Redirect
{
    public static function to($string)
    {
        echo '<meta http-equiv="refresh" content="0; url='.$string.'">';
    }
}
