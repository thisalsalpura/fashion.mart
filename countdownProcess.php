<?php

$start_date = new DateTime("2023-12-15 19:00:00");

$tdate = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$tdate->setTimezone($tz);
$end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

$difference = $end_date->diff($start_date);

$data = array(
    'years'    => $difference->format('%Y'),
    'months'   => $difference->format('%m'),
    'days'     => $difference->format('%d'),
    'hours'    => $difference->format('%H'),
    'minutes'  => $difference->format('%i'),
    'seconds'  => $difference->format('%s')
);

header('Content-Type: application/json');
echo json_encode($data);
