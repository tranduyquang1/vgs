<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class SelectCategoryHomepagePosition extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        $this->items = ['default' => 'Không xuất hiện'] + config('zvn.category_home_position');
    }

    public function updatedSelected()
    {
        try {
            $node = Category::find($this->rowId);
            $value = $this->selected;

            $node->update(['homepage_position' => $value]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Cập nhật thành công!"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Cố lỗi xảy ra, vui lòng thử lại!"
            ]);
        }
    }

    public function render()
    {
        return view('livewire.select-category-homepage-position');
    }
}
