<?php

use App\Models\Config;

function use_beepers()
{
    return true;
}

function use_tables()
{
    return false;
}

function use_discount()
{
    return true;
}

function getNavbarColor()
{
    $config = Config::first();
}
