<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $name;
    public $categories = [];

    public function store()
    {
        $this->categories = Category::where('user_id', Auth::user()->id)->get();
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->where('user_id', Auth::user()->id)],
        ]);

        Category::create([
            'user_id' => Auth::user()->id,
            'name' => $this->name,
        ]);

        // Redireccionar con navigate true
        return $this->redirect(route('categories.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
