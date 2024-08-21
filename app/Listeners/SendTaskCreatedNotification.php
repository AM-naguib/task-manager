<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskCreatedNotification
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

    public function handle(TaskCreated $event): void
    {
        if ($event) {
            $task = $event->task;
            $projectName = $task->project->name ?? "لسه متحددش";
            foreach ($task->users as $user) {
                $response = Http::post('https://wsup.app/api/create-message', [
                    'appkey' => '6e610f34-5be9-4ae0-8de8-c3dd9ce94002',
                    'authkey' => 'a87qlsWsnAD2HJevGZcCiClL3s0w4oInZ5UA9PuI4rjfQ5mcjc',
                    'to' => '2' . $user->phone,
                    'message' => "🤩 *بشر* 🤩\n\n" .
                        "*{$task->name}* \n في مشروع *{$projectName}*\n\n" .
                        "حالة التاسك: *{$task->priority}* 🚀\n\n" .
                        "تقدر تشوفها من هنا:\n\n" .
                        "https://tasks.echopus.com/tasks?taskId={$task->id}\n\n" .
                        "متنساش لما تخلص تعمل *Ready For Test* 💪\n\n" .
                        "_بالتوفيق يا ريييص، عارفين إنك هتبدع 💘_",

                    'sandbox' => 'false'
                ]);
            }
        }
    }
}
