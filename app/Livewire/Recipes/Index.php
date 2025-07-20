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
            ->where('user_id', Auth::id())
            ->when($this->search, function ($consulta) {
                $consulta->where(function ($query) {
                    $query->where('recipes.name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('category', function ($categoryQuery) {
                            $categoryQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(7);
        return view('livewire.recipes.index', [
            'recipes' => $recipes,
        ]);
    }
}
