<?php 
$current = str_replace("\n", ' ', $current);
$table = explode('||', $current);
if ($table && is_array($table)) {
    $ct = 1;
    foreach ($table as $row) {
        $tr = explode(' | ', $row);
        if ($tr && is_array($tr)) { ?>
        <tr>
            <td><?= $ct ?></td>
            <td><?= (isset($tr['0']) ? $tr['0'] : "") ?></td>
            <td><?= (isset($tr['1']) ? $tr['1'] : "") ?></td>
            <td><?= (isset($tr['2']) ? $tr['2'] : "") ?></td>
            <td><?= (isset($tr['3']) ? $tr['3'] : "") ?></td>
        </tr>
        <?php
        }
        $ct++;
    }
}