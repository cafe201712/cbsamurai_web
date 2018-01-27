<?php
$class = $class ?? 'btn btn-default btn-sm';

echo $this->Form->create($like, ['novalidate' => true]);
echo $this->Form->button("+ チケット10枚", ['name' => 'add_tickets', 'value' => 'add_tickets', 'class' => $class]);
echo $this->Form->end();
