<?php
use Cake\Core\Configure;

$level = 'success';
$thresholds = Configure::read('AppLocal.ticket_threshold_class') ?: [];

foreach ($thresholds as $level => $value) {
    if ($num_of_tickets <= $value) break;
}
?>

<span class="label label-<?= $level ?> <?= $class ?? '' ?>"><?= sprintf($format, $num_of_tickets) ?></span>