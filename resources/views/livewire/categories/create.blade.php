<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- Encabezado y breadcrumbs -->
    <div class="flex flex-col space-y-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('categories.index') }}" wire:navigate>{{ __('Categories') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item active>{{ __('Create') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        
        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('Create Category') }}</h1>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 p-6">
        <form wire:submit.prevent="store">
            <div class="space-y-6">
                <!-- Campo Nombre -->
                <div>
                    <x-label for="name" value="{{ __('Category Name') }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <div class="mt-1 relative">
                        <x-input
                            wire:model="name"
                            id="name"
                            type="text"
                            class="block w-full"
                            placeholder="{{ __('e.g. Desserts, Main Courses, etc.') }}"
                            autofocus
                        />
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Acciones -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                    <flux:button 
                        variant="outline" 
                        type="button" 
                        wire:navigate 
                        href="{{ route('categories.index') }}"
                        class="px-4 py-2"
                    >
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button 
                        variant="primary" 
                        type="submit"
                        class="px-4 py-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>{{ __('Create Category') }}</span>
                        <span wire:loading>
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Creating...') }}
                        </span>
                    </flux:button>
                </div>
            </div>
        </form>
    </div>
</div>