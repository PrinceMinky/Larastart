<section class="flex flex-col gap-2">
    <!-- Page Heading -->
    <x-page-heading>
        <x-slot name="heading">Config</x-slot>
        <x-slot name="subheading">A place to view all of your config files.</x-slot>
    </x-page-heading>

    <div class="flex gap-2">
        <flux:card class="w-1/4">
            <flux:heading>Config Files</flux:heading>

            <flux:navlist>
                @foreach($this->getConfigFiles as $file)
                    @php
                        $fileName = Str::replace('.php', '', $file);
                    @endphp
                    <flux:navlist.item 
                        :href="route('admin.misc.config.show', ['config_file' => $fileName])"
                        :current="$this->file === $fileName"
                    >
                        {{ $file }}
                    </flux:navlist.item>
                @endforeach
            </flux:navlist>
        </flux:card>

        <div class="flex flex-col gap-2 w-3/4">
            @if($this->file && $this->getFileContent)
            <flux:callout variant="warning" icon="exclamation-triangle" text="For safety reasons, you cannot edit these files." />
            @endif
            
            <flux:card class="w-full h-auto">
            @if($this->file && $this->getFileContent)
            <flux:heading>{{ $this->file }}.php</flux:heading>
            
            <div class="mt-4">
                <flux:code lang="php">{{ $this->getFileContent }}</flux:code>
            </div>
            @else
            <flux:text>Select a file to get started.</flux:text>
            @endif
        </flux:card>
    </div>
    </div>
</section>