<div class="max-w-4xl mx-auto sm:px-4 py-3">
    {{-- BreadCrumb --}}
    <div class="mb-6 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('categories.index') }}" wire:navigate>{{ __('Home') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Create') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <form class="mt-6" wire:submit="store">
        <x-label for="name">{{ __('Name') }}</x-label>
        <x-input type="text" class="mt-2" wire:model="name" placeholder="{{ __('Name') }}" />
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        <div class="flex justify-end mt-4">
            <flux:button variant="primary" wire:click="store">{{ __('Create') }}</flux:button>
        </div>
    </form>
</div>
