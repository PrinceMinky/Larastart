<?php

namespace App\Enums;

enum KanbanTemplates: string
{
    case Basic = 'Basic';
    case Scrum = 'Scrum';
    case Bug_Tracking = 'Bug Tracking';
    case Feature_Development = 'Feature Development';
    case Custom_Workflow = 'Custom Workflow';
    case Mink_Workflow = 'Mink Workflow';

    public function columns(): array
    {
        return match($this) {
            self::Basic => ['To Do', 'In Progress', 'Done'],
            self::Scrum => ['Backlog', 'Sprint', 'In Progress', 'Review', 'Done'],
            self::Bug_Tracking => ['Reported', 'Acknowledged', 'In Progress', 'Testing', 'Closed'],
            self::Feature_Development => ['Ideas', 'Design', 'Development', 'QA', 'Release'],
            self::Custom_Workflow => ['Stage 1', 'Stage 2', 'Stage 3'],
            self::Mink_Workflow => ['Recieve a Task', 'Delegate', 'Enusre Complete','Take Credit'],
        };
    }

    public function label()
    {
        return (string) str($this->name)->replace('_',' ');
    }
}
