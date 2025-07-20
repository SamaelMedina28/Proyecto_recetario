<div>
    <h1 class="text-2xl font-bold mb-4">{{ __('Recipes') }}</h1>
    <div class="mb-4">
        <x-input type="text" placeholder="{{ __('Search recipes...') }}" />
    </div>
    <div class="flex flex-col justify-center gap-4">
        @foreach ($recipes as $recipe)
            <div class="bg-white dark:bg-zinc-700 rounded shadow-xl flex justify-between items-center ">
                <div class="flex items-center space-x-4">
                    <img src="https://img.hellofresh.com/w_3840,q_auto,f_auto,c_fill,fl_lossy/hellofresh_website/es/cms/SEO/recipes/albondigas-caseras-de-cerdo-con-salsa-barbacoa.jpeg"
                        alt="{{ $recipe->name }}" class="h-16 w-16 object-cover rounded">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $recipe->name }}</h2>
                        <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300">{{ $recipe->category->name }}
                        </h2>
                    </div>
                </div>
                <div class="h-16 flex items-center px-2 bg-blue-500 text-white rounded-r">
                    <a href="#"
                        class="">{{ __('View Recipe') }}</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-4">
        {{ $recipes->links() }}
    </div>
</div>
