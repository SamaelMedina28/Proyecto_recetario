<?php

namespace App\Livewire\Recipes;

use App\Models\Recipe;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    public function render()
    {
        $recipes = Recipe::with('category')
            ->when($this->search, function ($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%'); 
            })
            ->whereBelongsTo(Auth::user()) 
            ->latest()
            ->paginate(7);
        return view('livewire.recipes.index', [
            'recipes' => $recipes,
        ]);
    }
}
