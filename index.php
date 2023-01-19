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

echo '<pre>';
$Ical->debugViewIcal();
echo '</pre>';
?>