<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('livewire.categories.index', compact('categories'));
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->recipes()->count() > 0) {
            $this->dispatch('alert', type: 'error', message: "This category belongs to {$category->recipes()->count()} recipes");
            return;
        }
        $category->delete();
        $this->dispatch('alert', type: 'success', message: 'Category deleted successfully');
    }
}
