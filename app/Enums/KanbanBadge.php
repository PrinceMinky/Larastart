<?php

namespace App\Enums;

enum KanbanBadge: string
{
    case Bug = 'Bug';
    case Backend = 'Backend';
    case High_Priority = 'High Priority';
    case UI = 'UI';

    public static function options(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label()
    {
        return (string) str($this->name)->replace('_',' ');
    }

    public function color(): FluxColor
    {
        return match($this) {
            self::Bug => FluxColor::Red,
            self::Backend => FluxColor::Green,
            self::High_Priority => FluxColor::Yellow,
            self::UI => FluxColor::Blue,
        };
    }

    public static function withColors(): array
    {
        return array_map(fn($case) => [
            'badge' => $case->value,
            'color' => $case->color()->value
        ], self::cases());
    }
}