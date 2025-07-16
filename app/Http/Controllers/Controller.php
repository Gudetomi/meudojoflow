<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function removeMascara($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}
