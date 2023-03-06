<?php

namespace App\Http\Livewire;

use App\Models\TournamentCategories;
use App\Models\BannersCategory;
use Livewire\Component;

class SelectBannerCategoryTournament extends Component
{
    public $items = [];
    public $selected;
    public $rowId;

    public function mount($selected, $rowId)
    {
        $this->selected = $selected;
        $this->rowId = $rowId;
        // $this->items = config('zvn.banner.page');
        $listBannerCategory =BannersCategory::all(['id','name']);
        $arrItems = [
            '0' => 'Không chọn'
        ];
        if($listBannerCategory){
            foreach ($listBannerCategory as $value){
                    $arrItems[$value['id']] = $value['name'];
            }
        }
        $this->items = $arrItems;
    }

    public function updatedSelected()
    {
        try {
            $item = TournamentCategories::find($this->rowId);
            $data['banner_category_id'] = $this->selected;
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
        return view('livewire.select-banner-category-tournament');
    }
}
