<div class="max-w-4xl mx-auto sm:px-4">
    <div class="flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item>{{ __('Categories') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="md:text-3xl text-xl font-bold text-gray-800 dark:text-white">{{ __('Categories') }}</h1>
        {{-- Botón para añadir nueva categoría (opcional) --}}
        <flux:button variant="primary" wire:navigate href="{{ route('categories.create') }}">
            {{ __('Add') }}
        </flux:button>
    </div>

    <ul class="space-y-3">
        @if ($categories->isEmpty())
            <li class="group">
                <div
                    class="flex justify-center items-center bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 dark:border-zinc-700 group-hover:border-gray-200 dark:group-hover:border-zinc-600">
                    <span
                        class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ __('No categories found') }}</span>
                </div>
            </li>
        @else
            @foreach ($categories as $category)
                <div 
                    class="group bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-zinc-700 hover:border-gray-200 dark:hover:border-zinc-600 overflow-hidden"
                    wire:key="category-{{ $category->id }}"
                >
                    <div class="flex justify-between items-center p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-4">
                                <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $category->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $category->recipes->count() }} {{ __('Recipes') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button 
                                wire:click="edit({{ $category->id }})"
                                class="p-2 text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors"
                                title="{{ __('Edit') }}"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                            <button
                                wire:click="delete({{ $category->id }})"
                                wire:confirm="{{ __('Are you sure you want to delete this category?') }}"
                                wire:loading.attr="disabled"
                                class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors"
                                title="{{ __('Delete') }}"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </ul>

    {{-- ! Modal Alert --}}
    <div x-data="{
        showModal: false,
        modalType: '',
        modalMessage: '',
        timer: null,
        getDuration() {
            return this.modalType === 'error' ? 3000 : 1000;
        }
    }"
        x-on:alert.window="
        showModal = true;
        modalType = $event.detail.type;
        modalMessage = $event.detail.message;
        clearTimeout(timer);
        timer = setTimeout(() => { showModal = false }, getDuration());
    "
        class="fixed inset-0 z-50 flex items-center justify-center" style="pointer-events: none;">
        {{-- Fondo oscuro --}}
        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/20 transition-opacity" style="pointer-events: auto;"></div>

        {{-- Modal de alerta --}}
        <div x-show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6"
            style="pointer-events: auto;">
            <div class="sm:flex sm:items-start">
                <div x-bind:class="{
                    'bg-red-100 dark:bg-red-900/30': modalType === 'error',
                    'bg-emerald-100 dark:bg-emerald-900/30': modalType === 'success',
                    'bg-blue-100 dark:bg-blue-900/30': modalType === 'info'
                }"
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full">
                    <svg x-show="modalType === 'error'" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <svg x-show="modalType === 'success'" class="h-6 w-6 text-emerald-600 dark:text-emerald-400"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg x-show="!['error','success'].includes(modalType)"
                        class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100"
                        x-text="modalType === 'error' ? 'Error' : modalType === 'success' ? 'Éxito' : 'Información'">
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="modalMessage"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($showModal)
        <div class="fixed justify-center items-center flex z-50 inset-0 bg-black/20">
            <form wire:submit="update"
                class="w-[400px] bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 dark:border-zinc-700 group-hover:border-gray-200 dark:group-hover:border-zinc-600">
                <x-label for="name">{{ __('Name') }}</x-label>
                <x-input type="text" class="mt-2" placeholder="{{ __('Name') }}" wire:model="name"/>
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
                <div class="flex justify-end mt-4 gap-2">
                    <x-button wire:click="setModal(false)">{{ __('Cancel') }}</x-button>
                    <x-button variant="primary" type="submit">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    @endif
</div>
