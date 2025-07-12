<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand href="{{ route('home') }}" name="{{ config('app.name') }}">
                <x-slot name="logo">
                    <div class="size-6 rounded shrink-0 bg-accent text-accent-foreground flex items-center justify-center"><i class="font-serif font-bold">{{ first_letter(config('app.name')) }}</i></div>
                </x-slot>
            </flux:brand>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                    <flux:navlist.item icon="home" :href="route('admin.activity')" :current="request()->routeIs('admin.activity')" wire:navigate>{{ __('Activities') }}</flux:navlist.item>
    
                    @can(['view kanban boards'])
                        <flux:navlist.item icon="clipboard-document-list" :href="route('admin.kanban_list')" :current="request()->routeIs(['admin.kanban_list', 'admin.kanban_board', 'admin.kanban_card'])" wire:navigate>{{ __('Kanban Boards') }}</flux:navlist.item>
                    @endcan
                </flux:navlist.group>

                @canany(['view users', 'view roles', 'view permissions'])
                <flux:navlist.group :heading="__('User Management')" :expandable="true" :expanded="request()->routeIs('admin.user.*')">
                    <flux:navlist.item icon="users" :href="route('admin.user.index')" :current="request()->routeIs('admin.user.index')" wire:navigate>{{ __('All Users') }}</flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('admin.user.role')" :current="request()->routeIs('admin.user.role')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                    <flux:navlist.item icon="shield-exclamation" :href="route('admin.user.permission')" :current="request()->routeIs('admin.user.permission')" wire:navigate>{{ __('Permissions') }}</flux:navlist.item>
                </flux:navlist.group>
                @endcanany
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    avatar:color="auto"
                    icon:trailing="chevron-up-down"
                />

                <flux:menu class="w-[220px]">
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
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :name="auth()->user()->name"
                    avatar:color="auto"
                    icon:trailing="chevron-up-down"
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
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
