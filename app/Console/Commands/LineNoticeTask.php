<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\MainTask;
use App\Models\User;
use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineNoticeTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LineNoticeTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PrimeTaskから、ユーザーのLINEに「未着手」「着手中」のタスクをメッセージで送信する';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // LINEBOTSDKの設定
        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken(config('services.line.channel_token'));
        $messagingApi = new MessagingApiApi(
        client: $client,
        config: $config,
        );

        $users = User::whereNotNull('line_id')->get();
        foreach($users as $user) {
            $mainTasks = MainTask::where('user_id', $user->id)
            ->whereIn('status', ['未着手', '着手中'])
            ->get();

            $messages = '';
            foreach ($mainTasks as $mainTask) {
                $messages .= 'タスク名' . "\n" .
                            '「' . $mainTask->title . '」' .  "\n" .
                             "\n";
            }

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer'.config('services.line.channel_token'),
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/push');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // 送信先のLINEアカウントを取得
            $userId = $user->line_id;

            // メッセージ送信
            $textMessage = new TextMessage(['type' => 'text','text' => $messages .
            '以上が「未着手」及び、「着手中」のタスクとして登録されています。'
            ]);

            $data = [
                "to" => $userId,
                "messages" => [
                    [
                        "type" => "text",
                        "text" => $textMessage->getText()
                    ]
                ]
            ];

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            curl_exec($ch);
            curl_close($ch);
        }
        return 'ok';
    }
}
