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
                {{-- * --}}
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
                    <flux:select wire:model="category_id">
                        <flux:select.option selected>{{ __('Select a category') }}</flux:select.option>
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
                <div>
                    <x-label for="ingredients">
                        {{ __('Ingredients') }}
                    </x-label>
                    <div class="mt-1 relative">
                        <!-- Contenedor del editor Quill -->
                        <div id="quill-editor-ingredients" wire:ignore
                            class="dark:bg-zinc-700 dark:text-gray-100 dark:border-zinc-600">
                        </div>
                        <!-- Input oculto para Livewire -->
                        <input type="text" id="quill-content-ingredients" wire:model="ingredients" class="hidden">
                    </div>
                    @error('ingredients')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Campo Instrucciones -->
            <div>
                <div>
                    <x-label for="instructions">
                        {{ __('Instructions') }}
                    </x-label>
                    <div class="mt-1 relative">
                        <!-- Contenedor del editor Quill -->
                        <div id="quill-editor-instructions" wire:ignore
                            class="dark:bg-zinc-700 dark:text-gray-100 dark:border-zinc-600">
                        </div>
                        <!-- Input oculto para Livewire -->
                        <input type="text" id="quill-content-instructions" wire:model="instructions" class="hidden">
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
                <div class="mt-1 relative flex items-center">
                    <input wire:model="image_path" type="file" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400
                               hover:file:bg-blue-100 dark:hover:file:bg-blue-900/40">
                    @if ($image_path)
                        <img src="{{ $image_path->temporaryUrl() }}" alt="Image Preview" class="mt-2 h-32">
                    @endif
                </div>
                @error('image_path')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                <flux:button variant="outline" type="button" wire:navigate href="{{ route('dashboard') }}"
                    class="px-4 py-2">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button variant="primary" type="submit"
                    class="px-4 py-2 flex items-center justify-center min-w-[100px]" wire:loading.attr="disabled"
                    wire:target="store">
                    <span wire:loading.remove wire:target="store" class="flex items-center">
                        {{ __('Save') }}
                    </span>
                    <span wire:loading wire:target="store" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="ml-2">{{ __('Saving...') }}</span>
                    </span>
                </flux:button>
            </div>
        </div>
    </form>
    <style>
        /* Override Quill styles for dark mode */
        .dark .ql-toolbar {
            background-color: #2d2d2f !important;
            /* zinc-700 */
            border-color: #52525b !important;
            /* zinc-600 */
        }

        .dark .ql-container {
            border-color: #52525b !important;
            /* zinc-600 */
        }

        .dark .ql-editor {
            color: #f4f4f5 !important;
            /* zinc-100 */
        }

        .dark .ql-snow .ql-stroke {
            stroke: #f4f4f5 !important;
            /* zinc-100 */
        }

        .dark .ql-snow .ql-fill {
            fill: #f4f4f5 !important;
            /* zinc-100 */
        }

        .dark .ql-snow .ql-picker {
            color: #f4f4f5 !important;
            /* zinc-100 */
        }
        .dark .ql-picker-options {
            background-color: #2d2d2f !important;
            /* zinc-700 */
        }
    </style>
    <script>
        document.addEventListener('livewire:init', () => {
            let quillIngredients, quillInstructions;

            // Función para verificar si el contenido es "vacío" (solo tags HTML sin texto)
            function isContentEmpty(htmlContent) {
                if (!htmlContent) return true;

                // Crear elemento temporal para analizar el HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = htmlContent;

                // Eliminar espacios en blanco y saltos de línea
                const textContent = tempDiv.textContent.trim().replace(/\n/g, '');

                // Verificar si queda algún texto real
                return textContent === '';
            }

            function initQuillEditors() {
                // Obtener contenido actual antes de reinicializar
                const currentIngredients = quillIngredients ? quillIngredients.root.innerHTML : '';
                const currentInstructions = quillInstructions ? quillInstructions.root.innerHTML : '';

                // Inicializar editor de ingredientes
                const ingredientsContainer = document.getElementById('quill-editor-ingredients');
                ingredientsContainer.innerHTML = ''; // Limpiar antes de inicializar

                quillIngredients = new Quill('#quill-editor-ingredients', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }],
                            [{
                                'size': []
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'color': []
                            }],
                            ['link']
                        ]
                    }
                });

                // Inicializar editor de instrucciones
                const instructionsContainer = document.getElementById('quill-editor-instructions');
                instructionsContainer.innerHTML = ''; // Limpiar antes de inicializar

                quillInstructions = new Quill('#quill-editor-instructions', {
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
                                'color': []
                            }],
                            ['link']
                        ]
                    }
                });

                // Restaurar contenido solo si no está vacío
                if (!isContentEmpty(currentIngredients)) {
                    quillIngredients.root.innerHTML = currentIngredients;
                } else {
                    quillIngredients.root.innerHTML = '';
                }

                if (!isContentEmpty(currentInstructions)) {
                    quillInstructions.root.innerHTML = currentInstructions;
                } else {
                    quillInstructions.root.innerHTML = '';
                }

                // Configurar eventos para sincronización con Livewire
                quillIngredients.on('text-change', function() {
                    const content = isContentEmpty(quillIngredients.root.innerHTML) ? '' : quillIngredients
                        .root.innerHTML;
                    document.getElementById('quill-content-ingredients').value = content;
                    document.getElementById('quill-content-ingredients').dispatchEvent(new Event('input'));
                });

                quillInstructions.on('text-change', function() {
                    const content = isContentEmpty(quillInstructions.root.innerHTML) ? '' :
                        quillInstructions.root.innerHTML;
                    document.getElementById('quill-content-instructions').value = content;
                    document.getElementById('quill-content-instructions').dispatchEvent(new Event('input'));
                });
            }

            // Inicializar editores al cargar
            initQuillEditors();

            // Reinicializar editores cuando Livewire actualice el DOM
            Livewire.hook('commit', ({
                component,
                succeed
            }) => {
                succeed(() => {
                    setTimeout(initQuillEditors, 50);
                });
            });
        });
    </script>
</div>
