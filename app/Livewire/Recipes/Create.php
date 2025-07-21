<?php

namespace App\Livewire\Recipes;

use App\Models\Category;
use App\Models\Recipe;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $name;
    public $category_id;
    public $ingredients;
    public $instructions;
    public $image_path = '';
    public function render()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('livewire.recipes.create', compact('categories'));
    }
    public function store()
    {
        $this->validate(
            [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'ingredients' => 'required',
                'instructions' => 'required',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'category_id.required' => 'La categoría es requerida',
                'ingredients.required' => 'Los ingredientes son requeridos',
                'instructions.required' => 'Las instrucciones son requeridas',
                'image_path.image' => 'La imagen debe ser un archivo de imagen',
                'image_path.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg',
                'image_path.max' => 'La imagen debe pesar menos de 2MB',
            ]
        );
        // dd($this->validate());
        Recipe::create([
            'user_id' => Auth::user()->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'image_path' => $this->image_path,
        ]);
        $this->redirect(route('dashboard'), navigate: true);
    }
}
