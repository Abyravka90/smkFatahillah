<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('setActive')) {
    function setActive($path)
    {
        return Request::is($path) ? 'active' : '';
    }
}

if (! function_exists('TanggalID')) {
    function TanggalID($tanggal)
    {
        $value = \Carbon\Carbon::parse($tanggal)->locale('id');

        return $value->translatedFormat('l, d F Y');
    }
}
