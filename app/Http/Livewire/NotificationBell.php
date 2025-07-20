<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->loadCount();
    }

    public function loadCount()
    {
        $this->count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        $this->loadCount();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
