<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\AutomationWebhook;

class WebhookController extends Controller
{
    public function handle(Request $request, string $type)
    {
        AutomationWebhook::dispatch($type, $request->all());
        return response()->json(['status' => 'ok']);
    }
}
