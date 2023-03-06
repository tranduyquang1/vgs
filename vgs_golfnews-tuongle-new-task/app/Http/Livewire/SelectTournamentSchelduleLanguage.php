<?php

namespace App\Http\Livewire;

use App\Models\TournamentLiveScheldule;
use Livewire\Component;

class SelectTournamentSchelduleLanguage extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        $this->items = config('zvn.tournament_scheldule_language');
    }

    public function updatedSelected()
    {
        try {
            $item = TournamentLiveScheldule::find($this->rowId);
            $data['language'] = $this->selected;
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
    return view('livewire.select-tournament-scheldule-language');
    }
}
