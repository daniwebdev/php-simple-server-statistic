<?php
include "./class.php";


$stats = new Stats();

$stats  
        ->get_uptime()
        ->get_cpu()
        ->get_mem()
        ->get_disk();

// $json = json_encode($stats->output);
header("content-type: application/json");
echo json_encode($stats->output);
