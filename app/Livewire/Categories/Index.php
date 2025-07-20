<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Index extends Component
{
    public $showModal = false;
    public $name;
    public $id;

    public function render()
    {
        $categories = Category::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        return view('livewire.categories.index', compact('categories'));
    }

    public function setModal($value)
    {
        $this->showModal = $value;
    }
    public function edit($id)
    {
        $this->setModal(true);
        $this->name = Category::find($id)->name;
        $this->id = $id;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->where('user_id', Auth::user()->id)->ignore($this->id)],
        ]);
        $category = Category::find($this->id);
        $category->update([
            'name' => $this->name,
        ]);
        $this->dispatch('alert', type: 'success', message: 'Category updated successfully');
        $this->setModal(false);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->recipes->count() > 0) {
            $this->dispatch('alert', type: 'error', message: "This category belongs to {$category->recipes->count()} recipes");
            return;
        }
        $category->delete();
        $this->dispatch('alert', type: 'success', message: 'Category deleted successfully');
    }
}
