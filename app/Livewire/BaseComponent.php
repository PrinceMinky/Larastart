<?php

namespace App\Livewire;

use App\Helpers\Notify;
use Livewire\Component;

class BaseComponent extends Component
{
    protected array $cachedLists = [];

    public function toast(array $parameters = [])
    {
        $notify = new Notify;

        foreach (['heading', 'text', 'variant', 'position', 'duration'] as $key) {
            if (isset($parameters[$key])) {
                $notify->$key($parameters[$key]);
            }
        }

        $notify->toast();
    }

    /**
     * Get cached list by key or generate it using the provided callback.
     *
     * @param string $key
     * @param callable $generator Function that returns array or Collection
     * @return \Illuminate\Support\Collection
     */
    public function getCachedList(string $key, callable $generator): \Illuminate\Support\Collection
    {
        if (!isset($this->cachedLists[$key])) {
            $list = $generator();
            if (!($list instanceof \Illuminate\Support\Collection)) {
                $list = collect($list);
            }
            $this->cachedLists[$key] = $list;
        }

        return $this->cachedLists[$key];
    }
}
