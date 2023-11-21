<?php

namespace App\Enum;

enum Status: string
{
    case STANDBY = "STANDBY";
    case VISIBLE = "VISIBLE";
    case TERMINATED = "TERMINATED";
    case ARCHIVED = "ARCHIVED";
}