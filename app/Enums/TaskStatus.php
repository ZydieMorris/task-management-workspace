<?php

namespace App\Enums;

enum TaskStatus: string
{
    case ToDo = 'To Do';
    case InProgress = 'In Progress';
    case ForChecking = 'For Checking';
    case OnHold = 'On Hold';
    case Completed = 'Completed';

     public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
