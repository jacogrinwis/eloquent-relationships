<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\StockStatus;

class StockStatusComponent extends Component
{
    public StockStatus $status;

    public function mount(StockStatus $status)
    {
        $this->status = $status;
    }

    public function getStatusDataProperty()
    {
        return match ($this->status) {
            StockStatus::InStock => [
                'label' => $this->status->label(),
                'colors' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
            ],
            StockStatus::BackOrder => [
                'label' => $this->status->label(),
                'colors' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                'info' => 'Dit product wordt speciaal voor u gemaakt.'
            ],
            StockStatus::OutOfStock => [
                'label' => $this->status->label(),
                'colors' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
            ],
        };
    }

    public function render()
    {
        return view('livewire.stock-status-component', [
            'statusData' => $this->statusData
        ]);
    }
}
