<?php
include 'Ical.php';

$Ical = new Ical(array(
    'patchIcal' => 'ics/',
    'proID' => array(
        0 => 'RezanCorp',
        1 => 'ReyzanProduct'
    ),
    'Version' => '1.0.0',
    'Method' => 'PUBLISH',
    'Name' => 'ReyzanCorp'
));

$Event = array(
    'Begin' =>  '2023-01-19',
    'End' => '2023-01-20',
    'Summary' => '01 | Event 1',
    'UID' => 'Event_1@reyhome.com'
);

$Ical->addEvent($Event);

$Ical->writeEvent();

echo '<pre>';
$Ical->debugViewIcal();
echo '</pre>';
?>