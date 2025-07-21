<?php

namespace App\Livewire\Recipes;

use App\Models\Recipe;
use Livewire\Component;

class Show extends Component
{
    public $recipe = [];

    public function mount($recipe)
    {
        $this->recipe = Recipe::findOrFail($recipe);
    }
    public function render()
    {
        return view('livewire.recipes.show');
    }
    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return redirect()->route('dashboard');
    }
}
