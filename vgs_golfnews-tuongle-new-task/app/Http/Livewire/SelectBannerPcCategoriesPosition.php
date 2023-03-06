<?php

namespace App\Http\Livewire;

use App\Models\BannersCategories;
use Livewire\Component;

class SelectBannerPcCategoriesPosition extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        $this->items = config('zvn.banner_categories_pc_position');
    }

    public function updatedSelected()
    {
        try {
            $item = BannersCategories::find($this->rowId);
            $data['position'] = $this->selected;
            $item->update($data);

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
        return view('livewire.select-banner-categories-position');
    }
}
