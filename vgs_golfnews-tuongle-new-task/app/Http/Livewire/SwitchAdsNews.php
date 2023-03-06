<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class SwitchAdsNews extends Component
{
    public $rowId;
    public $value;

    public function mount($value, $rowId)
    {
        $this->value = $value;
        $this->rowId = $rowId;
    }

    public function updating($name, $value)
    {
        try {
            $item = Post::find($this->rowId);
            $item->is_ads_news = $value;
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
        return view('livewire.switch-ads-news');
    }
}
