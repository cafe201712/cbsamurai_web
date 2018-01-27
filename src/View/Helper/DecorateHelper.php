<?php

namespace App\View\Helper;

use Cake\View\Helper;

class DecorateHelper extends Helper
{
    public function notInput($str)
    {
        return $str ?: '<span class="notInput">未入力</span>';
    }
}
