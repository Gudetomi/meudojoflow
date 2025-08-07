<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
abstract class Controller
{
    public function removeMascara($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
    protected function formatarData(?string $data): ?string
    {
        if (is_null($data)) {
            return null;
        }
        return Carbon::parse($data)->format('d/m/Y');
    }
}
