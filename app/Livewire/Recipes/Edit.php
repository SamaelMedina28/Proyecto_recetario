<?php

namespace App\Livewire\Recipes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use WithFileUploads;

    public Recipe $recipe;
    public $categories;
    public $name;
    public $category_id;
    public $ingredients;
    public $instructions;
    public $image_path;


    public function updatedImagePath()
    {
        $this->dispatch('preserve-quill-content');
    }

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
        $this->categories = Category::where('user_id', Auth::user()->id)->get();
        $this->name = $recipe->name;
        $this->category_id = $recipe->category_id;
        $this->ingredients = $recipe->ingredients;
        $this->instructions = $recipe->instructions;
        $this->image_path = $recipe->image_path;
    }

    public function update()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required',
            'instructions' => 'required',
        ];

        // Si la imagen no es un string (es decir, es un archivo nuevo)
        if (!is_string($this->image_path)) {
            $rules['image_path'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
        ];

        // Si se subió una nueva imagen
        if (!is_string($this->image_path) && $this->image_path) {
            // Eliminar imagen anterior si existe
            if ($this->recipe->image_path) {
                Storage::delete('public/' . $this->recipe->image_path);
            }

            // Guardar nueva imagen
            $data['image_path'] = $this->image_path->store('recipes');
        }

        $this->recipe->update($data);

        return redirect()->route('recipes.show', $this->recipe);
    }


    public function render()
    {
        return view('livewire.recipes.edit');
    }
}
