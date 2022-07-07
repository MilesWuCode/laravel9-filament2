<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Filament\Facades\Filament;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Sort extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public array $list;

    public function render(): View
    {
        return view('livewire.sort');
    }

    public function mount(): void
    {
        $this->list = Banner::ordered()->get()->toArray();

        $this->form->fill([
            'list' => $this->list,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Repeater::make('list')
                ->schema([
                    Forms\Components\TextInput::make('name')->disabled(),
                ])
                ->disableItemCreation()
                ->disableItemDeletion(),
        ];
    }

    public function submit(): void
    {
        $ids = collect($this->list)->pluck('id')->toArray();

        Banner::setNewOrder($ids);

        Filament::notify('success', 'Saved');

        $this->redirect('/banners');
    }
}
