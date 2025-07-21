<div class="max-w-4xl mx-auto px-4">
    <!-- Encabezado y breadcrumbs -->
    <div class="flex flex-col space-y-4 mb-3">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Recipes') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('recipes.show', $recipe) }}" wire:navigate>{{ $recipe->name }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item active>{{ __('Edit') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex flex-col">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('Edit Recipe') }}</h1>
        </div>
    </div>

    <form wire:submit.prevent="update">
        <div class="space-y-3">
            <!-- Campo Nombre -->
            <div>
                <x-label for="name">{{ __('Recipe Name') }}</x-label>
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
                <x-label for="category">{{ __('Category') }}</x-label>
                <div class="mt-1 relative">
                    <flux:select wire:model="category_id">
                        @foreach ($categories as $category)
                            <flux:select.option wire:key="{{ $category->id }}" value="{{ $category->id }}"
                                :selected="$category->id == $recipe->category_id">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Ingredientes -->
            <div>
                <x-label for="ingredients">{{ __('Ingredients') }}</x-label>
                <div class="mt-1 relative">
                    <div id="quill-editor-ingredients" wire:ignore
                        class="dark:bg-zinc-700 dark:text-gray-100 dark:border-zinc-600 h-48">
                        {!! $ingredients !!}
                    </div>
                    <input type="hidden" id="quill-content-ingredients" wire:model="ingredients">
                </div>
                @error('ingredients')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Instrucciones -->
            <div>
                <x-label for="instructions">{{ __('Instructions') }}</x-label>
                <div class="mt-1 relative">
                    <div id="quill-editor-instructions" wire:ignore
                        class="dark:bg-zinc-700 dark:text-gray-100 dark:border-zinc-600 h-48">
                        {!! $instructions !!}
                    </div>
                    <input type="hidden" id="quill-content-instructions" wire:model="instructions">
                </div>
                @error('instructions')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Imagen -->
            <div>
                <x-label for="image">{{ __('Image') }}</x-label>
                <div class="mt-1 relative flex flex-row-reverse space-y-2">
                    @if ($image_path && !is_string($image_path))
                        <!-- Vista previa de imagen temporal -->
                        <img src="{{ $image_path->temporaryUrl() }}" alt="Preview"
                            class="h-32 w-32 rounded-lg object-cover">
                    @elseif($image_path)
                        <!-- Imagen existente -->
                        <img src="{{ asset('storage/' . $image_path) }}" alt="Current image"
                            class="h-32 w-32 rounded-lg object-cover">
                    @endif
                    <input wire:model="image_path" type="file" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/30 dark:file:text-blue-400
                               hover:file:bg-blue-100 dark:hover:file:bg-blue-900/40">
                </div>
                @error('image_path')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                <flux:button variant="outline" type="button" wire:navigate href="{{ route('recipes.show', $recipe) }}"
                    class="px-4 py-2">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button variant="primary" type="submit"
                    class="px-4 py-2 flex items-center justify-center min-w-[100px]" wire:loading.attr="disabled"
                    wire:target="update">
                    <span wire:loading.remove wire:target="update" class="flex items-center">
                        {{ __('Update') }}
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="ml-2">{{ __('Updating...') }}</span>
                    </span>
                </flux:button>
            </div>
        </div>
    </form>

    <!-- Estilos y scripts para Quill (igual que en create) -->
    

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                let quillIngredients, quillInstructions;

                function isContentEmpty(htmlContent) {
                    if (!htmlContent) return true;
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = htmlContent;
                    const textContent = tempDiv.textContent.trim().replace(/\n/g, '');
                    return textContent === '';
                }

                function removeEmptyTags(htmlContent) {
                    if (!htmlContent) return htmlContent;

                    let cleanedContent = htmlContent;
                    let previousContent;

                    // Repetir hasta que no haya más cambios (para etiquetas anidadas vacías)
                    do {
                        previousContent = cleanedContent;

                        // Remover etiquetas completamente vacías como <p></p>, <div></div>, <span></span>, etc.
                        cleanedContent = cleanedContent.replace(/<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>\s*<\/\1>/g, '');

                        // Remover etiquetas que solo contienen <br> como <p><br></p>, <div><br></div>, etc.
                        cleanedContent = cleanedContent.replace(
                            /<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>\s*<br\s*\/?>\s*<\/\1>/g, '');

                        // Remover etiquetas que solo contienen espacios en blanco y saltos de línea
                        cleanedContent = cleanedContent.replace(/<([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>\s*<\/\1>/g, '');

                        // Remover múltiples <br> consecutivos y reemplazar por uno solo
                        cleanedContent = cleanedContent.replace(/(<br\s*\/?>){3,}/g, '<br><br>');

                    } while (cleanedContent !== previousContent);

                    return cleanedContent.trim();
                }

                function cleanQuillContent() {
                    if (quillIngredients) {
                        const currentIngredientsContent = quillIngredients.root.innerHTML;
                        const cleanedIngredientsContent = removeEmptyTags(currentIngredientsContent);

                        if (currentIngredientsContent !== cleanedIngredientsContent) {
                            quillIngredients.root.innerHTML = cleanedIngredientsContent;
                            // Actualizar el campo oculto
                            document.getElementById('quill-content-ingredients').value = cleanedIngredientsContent;
                        }
                    }

                    if (quillInstructions) {
                        const currentInstructionsContent = quillInstructions.root.innerHTML;
                        const cleanedInstructionsContent = removeEmptyTags(currentInstructionsContent);

                        if (currentInstructionsContent !== cleanedInstructionsContent) {
                            quillInstructions.root.innerHTML = cleanedInstructionsContent;
                            // Actualizar el campo oculto
                            document.getElementById('quill-content-instructions').value = cleanedInstructionsContent;
                        }
                    }
                }

                function initQuillEditors() {
                    // Destruir editores existentes si los hay
                    if (quillIngredients) quillIngredients = null;
                    if (quillInstructions) quillInstructions = null;

                    // Inicializar editor de ingredientes
                    quillIngredients = new Quill('#quill-editor-ingredients', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, false]
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
                    quillInstructions = new Quill('#quill-editor-instructions', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, false]
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

                // Escuchar el evento personalizado de Livewire para limpiar contenido
                Livewire.on('preserve-quill-content', () => {
                    cleanQuillContent();
                });

            });
        </script>
    @endpush
</div>
