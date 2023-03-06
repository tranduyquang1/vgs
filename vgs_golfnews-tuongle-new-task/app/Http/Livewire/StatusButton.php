<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class StatusButton extends Component
{
    public $model;
    public $rowId;
    public $status;

    public function mount($model, $status, $rowId)
    {
        $this->model = $model;
        $this->status = $status;
        $this->rowId = $rowId;
    }

    public function changeStatus()
    {
        try {
            $this->status = !$this->status;
            DB::table($this->model)->where('id', $this->rowId)->update(['status' => $this->status, 'updated_at' => now()]);

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
        return view('livewire.status-button');
    }
}
