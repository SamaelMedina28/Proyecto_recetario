<?php

namespace App\Livewire\Recipes;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public function render()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('livewire.recipes.create', compact('categories'));
    }
}
