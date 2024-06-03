<?php

use App\Models\Config;

//ESTILOS DE MODAL
function getBgPayrollModalHeaderColor()
{
    $config = Config::first();
    return $config->bgPayrollModalHeaderColor;
}
function getTextPayrollModalHeaderTextColor()
{
    $config = Config::first();
    return $config->textPayrollModalHeaderTextColor;
}
function getBgPayrollModalBodyColor()
{
    $config = Config::first();
    return $config->bgPayrollModalBodyColor;
}
function getBgPayrollModalContainerColor()
{
    $config = Config::first();
    return $config->bgPayrollModalContainerColor;
}
function getBgPayrollModalInfoContainerColor()
{
    $config = Config::first();
    return $config->bgPayrollModalInfoContainerColor;
}
function getPayrollModalInfoContainerTextColor()
{
    $config = Config::first();
    return $config->payrollModalInfoContainerTextColor;
}
function getPayrollModalInfoContainerTextTableColor()
{
    $config = Config::first();
    return $config->payrollModalInfoContainerTextTableColor;
}
function getPayrollModalInfoContainerbodyColor()
{
    $config = Config::first();
    return $config->payrollModalInfoContainerbodyColor;
}

//ESTILOS DE TABLA
function getTableBodyColor()
{
    $config = Config::first();
    return $config->tableBodyColor;
}
function getTableHeadTextColor()
{
    $config = Config::first();
    return $config->tableHeadTextColor;
}
function getTableHeadColor()
{
    $config = Config::first();
    return $config->tableHeadColor;
}
function getTableTextColor()
{
    $config = Config::first();
    return $config->tableTextColor;
}
function getLogo()
{
    $config = Config::first();
    return $config->logo;
}
function getNavbarBackground()
{
    $config = Config::first();
    return $config->navbar_background;
}

function getNavbarColor()
{
    $config = Config::first();
    return $config->navbar_color;
}

function getSidebarBackground()
{
    $config = Config::first();
    return $config->sidebar_background;
}

function getBodyBackground()
{
    $config = Config::first();
    return $config->bodyBackground;
}

function getContentConfig()
{
    $config = Config::first();
    return $config->contentConfig;
}

function getSidebarIconsColor()
{
    $config = Config::first();
    return $config->sidebar_icos_colors;
}

function getSidebarColor()
{
    $config = Config::first();
    return $config->sidebar_color;
}

function use_beepers()
{
    return false;
}

function use_deliveries()
{
    return env('USE_DELIVERIES', true);
}

function use_tables()
{
    return env('USE_TABLE', true);
}

function use_units()
{
    return env('USE_UNITS', true);
}

function background_color()
{
    return "black";
}

function use_debts()
{
    return env('USE_DEBTS', true);
}

function use_pay_cards()
{
    return env('USE_PAY_CARDS', true);
}

function use_discount()
{
    return env('USE_DISCOUNT', true);
}

function use_order_id_daily()
{
    return env('USE_ORDER_ID_DAILY', true);
}

function use_quickpos()
{
    return env('USE_QUICKPOS', true);
}

