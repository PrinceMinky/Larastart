<?php

namespace App\Enums;

enum KanbanBadgeNames: string
{
    case Bug = 'Bug';
    case UI = 'UI';
    case Backend = 'Backend';
    case Frontend = 'Frontend';
    case HighPriority = 'High Priority';
    case LowPriority = 'Low Priority';
    case Feature = 'Feature';
    case Improvement = 'Improvement';
    case Research = 'Research';
    case Testing = 'Testing';
    case Documentation = 'Documentation';
    case Refactor = 'Refactor';
    case Design = 'Design';
    case Security = 'Security';
    case Performance = 'Performance';
    case CustomerRequest = 'Customer Request';
    case Deployment = 'Deployment';
    case Maintenance = 'Maintenance';
    case Blocker = 'Blocker';

    public static function options(): array
    {
        return array_column(self::cases(), 'value');
    }
}
