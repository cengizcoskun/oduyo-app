<x-filament-panels::page>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button wire:click="save" icon="heroicon-s-cog-6-tooth">Save Settings</x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</x-filament-panels::page>
