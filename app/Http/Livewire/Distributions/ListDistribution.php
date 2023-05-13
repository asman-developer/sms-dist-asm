<?php

namespace App\Http\Livewire\Distributions;

use App\Models\Distribution;
use Livewire\Component;

class ListDistribution extends Component
{
    public $distributions;

    public $services;

    public $page;

    protected $queryString = [
        'page'
    ];

    public function render()
    {
        $take = 20;
        $skip = ($this->page == null || $this->page == 1) ? 0 : (($this->page - 1) * $take);

        $staff = currentStaff();

        $staff->load('services');

        $services = $staff->services()->orderBy('id','DESC')->get();

        $serviceIds = $services->pluck('id')->toArray();

        $distributions = Distribution::query()
            ->whereIn('service_id', $serviceIds)
            ->orderBy('id','DESC')
            ->skip($skip)
            ->take($take)
            ->get();

        $this->distributions = $distributions;
        $this->services = $services;

        return view('pages.distribution.livewire.list-distribution');
    }
}
