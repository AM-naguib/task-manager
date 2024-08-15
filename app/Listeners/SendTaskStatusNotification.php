<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\StatusUpdate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatusUpdate $event): void
    {
        if($event){
            $users = User::where("type", "admin")->get();
            $task = $event->task;
            foreach ($users as $user) {
                $response = Http::post('https://wsup.app/api/create-message', [
                    'appkey' => '6e610f34-5be9-4ae0-8de8-c3dd9ce94002',
                    'authkey' => 'a87qlsWsnAD2HJevGZcCiClL3s0w4oInZ5UA9PuI4rjfQ5mcjc',
                    'to' => '2' . $user->phone,
                    'message' => "🤩 *ابشر* 🤩\n\n*{$task->name}*\n\nالتاسك ديه دلوقتي جاهزة للاختبار يا ريص.\n\nممكن تشوفها من هنا:\n\nhttps://tasks.echopus.com/tasks?taskId={$task->id}\n\nولو تمام ومفيهاش تعديلات، متنساش تعمل *Done* عشان نكمل باقي الشغل 💪\n\n",
                    'sandbox' => 'false'
                ]);
            }

        }


    }
}
