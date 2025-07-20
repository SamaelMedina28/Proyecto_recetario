<div class="max-w-4xl mx-auto sm:px-4 py-3">
    <div class="mb-6 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item>{{ __('Home') }}</flux:breadcrumbs.item>
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
                <li class="group" wire:key="category-{{ $category->id }}">
                    <div
                        class="flex justify-between items-center bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300 border border-gray-100 dark:border-zinc-700 group-hover:border-gray-200 dark:group-hover:border-zinc-600">
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                        <div class="flex gap-3">
                            <button id="boton" wire:click="edit({{ $category->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-2 sm:px-4 rounded-full sm:rounded-lg transition-all duration-200 transform hover:scale-[1.03] shadow hover:shadow-md text-sm">
                                <span class="hidden sm:inline">{{ __('Edit') }}</span>
                                <span class="sm:hidden">
                                    <flux:icon.pencil />
                                </span>
                            </button>
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-2 sm:px-4 rounded-full sm:rounded-lg transition-all duration-200 transform hover:scale-[1.03] shadow hover:shadow-md text-sm"
                                wire:click="delete({{ $category->id }})"
                                wire:confirm="Are you sure you want to delete this category?"
                                wire:loading.attr="disabled">
                                <span class="hidden sm:inline">{{ __('Delete') }}</span>
                                <span class="sm:hidden">
                                    <flux:icon.trash />
                                </span>
                            </button>
                        </div>
                    </div>
                </li>
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
                <div class="flex justify-end mt-4">
                    <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </div>
    @endif
</div>
