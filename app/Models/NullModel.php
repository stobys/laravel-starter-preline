<?php

namespace App\Models;

class NullModel {
    public function __construct() { return $this; }
    public function __get($_str_key) { return null; }
    public function __set($_str_key, $_mix_value) {}

    public function __call($_str_method, $_arr_attr) { return $this; }
    public function __isset($_str_key) { return FALSE; }
    public function __unset($_str_key) { return TRUE; }
    public function __toString() { return ''; }

    public function loaded() { return FALSE; }
}
