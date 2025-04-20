<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Name -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <!-- Username -->
            <flux:input wire:model="username" :label="__('Username')" type="text" required autocomplete="username" />

            <!-- Email Address -->
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Date of Birth -->
            <flux:date-picker
                wire:model="date_of_birth"
                :label="__('Date of Birth')"
                selectable-header
            />

            <!-- Country -->
            <flux:select wire:model="country" placeholder="Choose Country" variant="listbox" searchable label="Country">
                @foreach (App\Enums\Country::cases() as $country)
                    <flux:select.option value="{{ $country->value }}">{{ $country->label() }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
