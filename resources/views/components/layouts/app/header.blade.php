<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:brand href="{{ route('home') }}" name="{{ config('app.name') }}">
            <x-slot name="logo">
                <div class="size-6 rounded shrink-0 bg-accent text-accent-foreground flex items-center justify-center"><i class="font-serif font-bold">{{ first_letter(config('app.name')) }}</i></div>
            </x-slot>
        </flux:brand>

        <flux:navbar class="-mb-px max-lg:hidden">
            @auth
            <flux:navlist.item icon="users" :href="route('users.list')" :current="request()->routeIs('users.list')" wire:navigate>
                {{ __('Users') }}
            </flux:navlist.item>
            @endauth
        </flux:navbar>

        <flux:spacer />

        <flux:spacer />

        @guest
        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item :href="route('register')" :current="request()->routeIs('register')" wire:navigate>
                {{ __('Register') }}
            </flux:navbar.item>

            <flux:navbar.item :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                {{ __('Login') }}
            </flux:navbar.item>
        </flux:navbar>
        @endguest

        @auth
        <flux:navbar class="-mb-px max-lg:hidden">
            @if($followRequestCount > 0)
            <flux:navbar.item badge="{{ $followRequestCount }}" :href="route('follow.requests')" :current="request()->routeIs('follow.requests')" wire:navigate>
                {{ __('Follow Requests') }}
            </flux:navbar.item>
            
            <flux:separator vertical />
            @endif
        </flux:navbar>
        @endauth

        <!-- Desktop User Menu -->
        @auth
        <flux:dropdown position="top" align="end">
            <flux:profile
                :name="auth()->user()->name"
                avatar:color="auto"
                icon:trailing="chevron-down"
            />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="flex items-center gap-2">
                        <flux:avatar :name="auth()->user()->name" color="auto" />
            
                        <div class="flex flex-col gap-0">
                            <flux:heading>{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="text-xs">{{ auth()->user()->username }}</flux:text>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('dashboard')" icon="home" wire:navigate>{{ __('Dashboard') }}</flux:menu.item>
                    
                    @can('view admin dashboard')
                    <flux:menu.item :href="route('admin.dashboard')" icon="home-modern" wire:navigate>{{ __('Admin Dashboard') }}</flux:menu.item>
                    @endcan
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
        @endauth
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                @auth
                <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.item icon="users" :href="route('users.list')" :current="request()->routeIs('users.list')" wire:navigate>
                    {{ __('Users') }}
                </flux:navlist.item>
                @endauth
            </flux:navlist.group>
        </flux:navlist>
    </flux:sidebar>

    <flux:container>
        {{ $slot }}
    </flux:container>
    @fluxScripts
</body>
</html>
