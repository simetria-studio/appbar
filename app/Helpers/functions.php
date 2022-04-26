<?php

if(!function_exists('getTimeDiff')){
    // Função para calcular diferença entre as horas.
    function getTimeDiff($dtime,$atime){
        // $since_start->days.' days total<br>';
        // $since_start->y.' years<br>';
        // $since_start->m.' months<br>';
        // $since_start->d.' days<br>';
        // $since_start->h.' hours<br>';
        // $since_start->i.' minutes<br>';
        // $since_start->s.' seconds<br>';

        $start_date = new DateTime(date('Y-m-d H:i:s', strtotime($dtime)));
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s', strtotime($atime))));

        return $since_start;
    }
}

if(!function_exists('conDate')){
    function conDate($date, $format, $str = null){
        $date = strtotime(str_replace('/','-', $date));
        switch($format){
            case 'DMY':
                $date = date('d-m-Y', $date);
            break;
            case 'YMD':
                $date = date('Y-m-d', $date);
            break;
            case 'DMYHIS':
                $date = date('d-m-Y H:i:s', $date);
            break;
            case 'YMDHIS':
                $date = date('Y-m-d H:i:s', $date);
            break;
        }

        if($str){
            return str_replace(($str == '/' ? '-' : '/'), $str, $date);
        }else{
            return $date;
        }
    }
}