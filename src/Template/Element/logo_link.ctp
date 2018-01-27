<?php
    $path = isset($login_user) ? '/home' : '/';
    $logo_file = $logo_file ?? 'logo.png';
    $class = $class ?? '';
?>
<a class="<?= $class ?>" href="<?= $this->Url->build($path); ?>">
    <img src="<?= $this->Url->image($logo_file); ?>" alt="きゃばサムライ" />
</a>
