<?php

echo $form->control($field_name, [
    'label' => $label,
    'type' => 'select',
    'options' => $shops,
    'empty' => '未選択',
    'class' => 'select2',
]);

