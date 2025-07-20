<div class="max-w-4xl mx-auto px-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item>{{ __('Recipes') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="flex flex-col space-y-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('Recipes') }}</h1>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <x-input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="{{ __('Search recipes...') }}" 
                    class="w-full sm:w-64"
                />
                <flux:button 
                    variant="primary" 
                    wire:navigate 
                    href="{{ route('recipes.create') }}"
                >
                    {{ __('Create') }}
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Lista de recetas -->
    <div class="space-y-4">
        @if ($recipes->isEmpty())
            <div class="flex flex-col items-center justify-center p-8 text-center bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700">
                <svg class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ __('No recipes found') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-1">{{ __('Try adjusting your search or create a new recipe') }}</p>
            </div>
        @else
            @foreach ($recipes as $recipe)
                <div 
                    class="group bg-white dark:bg-zinc-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-zinc-700 hover:border-gray-200 dark:hover:border-zinc-600 overflow-hidden"
                    wire:key="recipe-{{ $recipe->id }}"
                >
                    <div class="flex flex-col sm:flex-row">
                        <!-- Imagen -->
                        <div class="w-full sm:w-32 h-32 sm:h-auto flex-shrink-0">
                            <img 
                                src="{{ $recipe->image_url ?? 'https://img.hellofresh.com/w_3840,q_auto,f_auto,c_fill,fl_lossy/hellofresh_website/es/cms/SEO/recipes/albondigas-caseras-de-cerdo-con-salsa-barbacoa.jpeg' }}" 
                                alt="{{ $recipe->name }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        
                        <!-- Contenido -->
                        <div class="flex-1 p-4 sm:p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $recipe->name }}</h2>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $recipe->category->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $recipe->created_at->diffForHumans() }}
                                </div>
                                <flux:button variant="primary" wire:navigate href="">
                                    {{ __('View Recipe') }}
                                </flux:button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>
</div>