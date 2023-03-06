<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;

class SwitchBannerField extends Component
{
    public $rowId;
    public $value;
    public $field;

    public function mount($value, $rowId, $field)
    {
        $this->value = $value;
        $this->rowId = $rowId;
        $this->field = $field;
    }

    public function updating($name, $value)
    {
        try {
            $item = Banner::find($this->rowId);
            $item[$this->field] = $value;
            $item->save();

            // Set Flash Message
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
        return view('livewire.switch-banner-field');
    }
}
