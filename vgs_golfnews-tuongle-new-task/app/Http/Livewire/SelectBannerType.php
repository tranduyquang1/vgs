<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;

class SelectBannerType extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        $this->items = config('zvn.banner_type');
    }

    public function updatedSelected()
    {
        try {
            $item = Banner::find($this->rowId);
            $data['type'] = $this->selected;
            $data['is_mobile'] = $this->selected == '' ? 0 : 1;
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
        return view('livewire.select-banner-type');
    }
}
