<?php

namespace App\Livewire;

use App\Helpers\Notify;
use Livewire\Component;

class BaseComponent extends Component
{
    public function toast(array $parameters = [])
    {
        $notify = new Notify;

        if (isset($parameters['heading'])) {
            $notify->heading($parameters['heading']);
        }

        if (isset($parameters['text'])) {
            $notify->text($parameters['text']);
        }

        if (isset($parameters['variant'])) {
            $notify->variant($parameters['variant']);
        }

        if (isset($parameters['position'])) {
            $notify->position($parameters['position']);
        }

        if (isset($parameters['duration'])) {
            $notify->duration($parameters['duration']);
        }

        $notify->toast();
    }
}
