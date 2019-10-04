<?php

$e = shell_exec("sar -u 1 1");
$e = explode("\n", $e);
$e = explode(' ', $e[4]); //get average;
// $get_end = end($e);
$avg    = [];
$total  = 0;

$end = end($e);

foreach($e as $k => $v) {
    if($k > 10 && $v != $end) {
        if(!empty($v)) {
            $double = (double) str_replace(',', '.', $v);
            // print($double);
            // print("\n");
            $avg[]  = $double;
            $total += $double;
        }
    }
}

// print(count($avg));

// print('Total: '+ $total +"\n");
// print('Avg: '+ count($avg) +"\n");