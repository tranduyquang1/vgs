<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class SelectPostStatus extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        $this->items = config('zvn.post_status');
    }

    public function updatedSelected()
    {
        try {
            $item = Post::find($this->rowId);
            $data['status'] = $this->selected;

            if ($this->selected == 'published') $data['published_at'] = now();

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
        return view('livewire.select-post-status');
    }
}
