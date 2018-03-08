<?php
/**
 * Description of helper
 *
 * @author juanantonio
 */
class ttgHelper {
    static function objToArray($ob){
        $arr = array();
        foreach ($ob as $key => $value){
            $arr[$key] = $value;
        }
        return $arr;
    }
    static function orderAsc($a,$b){
        if($a>$b){
            return 1;
        }
        if($a<$b){
            return -1;
        }
        return 0;
    }
}
