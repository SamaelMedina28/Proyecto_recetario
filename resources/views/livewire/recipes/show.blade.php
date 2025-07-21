<div class="max-w-4xl mx-auto px-4">
    <!-- Encabezado y breadcrumbs -->
    <div class="flex flex-col space-y-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Recipes') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item active>{{ __('Show') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <!-- Encabezado -->
    <div class="text-center">
        <div
            class="inline-block bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-sm font-medium px-3 py-1 rounded-full mb-4">
            {{ $recipe->category->name }}
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-2">{{ $recipe->name }}</h1>
        <div class="flex justify-center items-center text-gray-500 dark:text-gray-400 space-x-4">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $recipe->created_at->diffForHumans() }}
            </span>
        </div>
    </div>

    <!-- Imagen principal -->
    <div class="rounded-xl overflow-hidden shadow-lg mb-6">
        <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : asset('img/recipe-placeholder.jpg') }}"
            alt="{{ $recipe->name }}" class="w-full h-64 md:h-96 object-cover" loading="lazy">
    </div>

    <!-- Contenido en dos columnas (md en adelante) -->
    <div class="md:flex md:space-x-8">
        <!-- Ingredientes -->
        <div class="md:w-1/3 ingredients">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-6 sticky top-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    {{ __('Ingredients') }}
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    {!! $recipe->ingredients !!}
                </div>
            </div>
        </div>

        <!-- Instrucciones -->
        <div class="md:w-2/3 instructions">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Instructions') }}
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    {!! $recipe->instructions !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones (opcional) -->
    <div class="flex justify-end space-x-2 my-4">
        <flux:button variant="danger" wire:confirm="{{ __('Are you sure you want to delete this recipe?') }}"
            wire:click="delete({{ $recipe->id }})">
            {{ __('Delete') }}
        </flux:button>
        <flux:button variant="primary" href="{{ route('recipes.edit', $recipe->id) }}">
            {{ __('Edit') }}
        </flux:button>
    </div>

    <style>
        /* Títulos */
        .ingredients h1,
        .instructions h1 {
            font-size: 1.5rem;
        }

        .ingredients h2,
        .instructions h2 {
            font-size: 1.25rem;
        }

        .ingredients h3,
        .instructions h3 {
            font-size: 1rem;
        }

        .ingredients h4,
        .instructions h4 {
            font-size: 0.875rem;
        }

        .ingredients h5,
        .instructions h5 {
            font-size: 0.75rem;
        }

        .ingredients h6,
        .instructions h6 {
            font-size: 0.625rem;
        }

        /* Listas */
        .ingredients ul,
        .instructions ul {
            list-style-type: disc;
        }

        .ingredients ol,
        .instructions ol {
            list-style-type: decimal;
            padding-left: 1rem;
        }

        /* Elementos comunes */
        .ingredients li,
        .instructions li,
        .ingredients p,
        .instructions p {
            margin-bottom: 0.5rem;
        }

        /* Enlaces */
        .ingredients a,
        .instructions a {
            text-decoration: underline;
            color: #007bff;
        }
    </style>
</div>
