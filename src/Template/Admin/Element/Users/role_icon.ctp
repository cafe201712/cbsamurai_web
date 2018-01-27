<?php
use App\Model\Entity\User;
?>
<span class="glyphicon <?= User::ROLE_ICONS[$role] ?> role-<?= $role ?>"></span>
