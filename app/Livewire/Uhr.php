<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;

use Livewire\Component;
//#[Layout('layouts.app')]
class Uhr extends Component
{
    public $serverTime;
    public $interval;

    public function mount()
    {
        $this->updateServerTime();
        $this->interval = 10000; // 1000ms = 1s
    }

    public function updateServerTime()
    {
        $dateTime = new \DateTime();
        $isDst = $dateTime->format('I') == '1';
        $this->serverTime = $isDst ? $dateTime->format('H:i') : $dateTime->setTimezone(new \DateTimeZone('Europe/Berlin'))->format('H:i');
    }

    public function refresh()
    {
        $this->updateServerTime();
    }

    public function render()
    {
        return view('livewire.uhr');
}


}