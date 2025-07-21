<div class="max-w-4xl mx-auto px-4">
    <!-- Encabezado y breadcrumbs -->
    <div class="flex flex-col space-y-4 mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Recipes') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item active>{{ __('Create') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('Create Recipe') }}</h1>
        </div>
    </div>

    <form wire:submit.prevent="store">
        <div class="space-y-3">
            <!-- Campo Nombre -->
            <div>
                <x-label for="name">
                    {{ __('Recipe Name') }}
                </x-label>
                <div class="mt-1 relative">
                    <x-input wire:model="name" id="name" type="text" class="block w-full"
                        placeholder="{{ __('e.g. Chocolate Cake, Spaghetti Carbonara') }}" />
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <!-- Campo Categoría -->
            <div>
                <x-label for="category">
                    {{ __('Category') }}
                </x-label>
                <div class="mt-1 relative">
                    <flux:select placeholder="Choose industry...">
                        @foreach ($categories as $category)
                            <flux:select.option wire:key="{{ $category->id }}" value="{{ $category->id }}">
                                {{ $category->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>


            <!-- Campo Ingredientes -->
            <div>
                <x-label for="ingredients">
                    {{ __('Ingredients') }}
                </x-label>
                <div class="mt-1 relative">
                    <textarea wire:model="ingredients" id="ingredients" rows="4"
                        class="block w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white"
                        placeholder="{{ __('List each ingredient on a new line') }}"></textarea>
                </div>
                @error('ingredients')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Instrucciones -->
            <div>
                <div>
                    <x-label for="instructions">
                        {{ __('Instructions') }}
                    </x-label>
                    <div class="mt-1 relative">
                        <!-- Contenedor del editor Quill -->
                        <div id="quill-editor" wire:ignore style="height: 100px;">
                        </div>
                        <!-- Input oculto para Livewire -->
                        <input type="text" id="quill-content" wire:model="instructions">
                    </div>
                    @error('instructions')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Campo Imagen -->
            <div>
                <x-label for="image">
                    {{ __('Image') }}
                </x-label>
                <div class="mt-1 relative">
                    <input wire:model="image" type="file" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400
                               hover:file:bg-blue-100 dark:hover:file:bg-blue-900/40">
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                <flux:button variant="outline" type="button" wire:navigate href="{{ route('dashboard') }}"
                    class="px-4 py-2">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button variant="primary" type="submit" class="px-4 py-2" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Save') }}</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('Saving...') }}
                    </span>
                </flux:button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Inicializar Quill cuando Livewire esté listo

                            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'color': []
                        }],
                        [{
                            'align': []
                        }],
                        ['link']
                    ]
                }
            });

            // Actualizar el campo hidden cuando el contenido cambie
            quill.on('text-change', function() {
                const content = document.getElementById('quill-content');
                content.value = quill.root.innerHTML;
                content.dispatchEvent(new Event('input'));
            });
        });
    </script>
</div>
