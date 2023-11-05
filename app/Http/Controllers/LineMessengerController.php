<?php

namespace App\Http\Controllers;

use App\Models\MainTask;
use App\Models\User;
use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api\MessagingApiApi;
use Illuminate\Http\Request;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineMessengerController extends Controller
{
    public function webhook(Request $request) {
        // LINEから送られた内容を$inputsに代入
        $inputs=$request->all();

        // そこからtypeをとりだし、$message_typeに代入
        $message_type=$inputs['events'][0]['type'];

        // メッセージが送られた場合、$message_typeは'message'となる。その場合処理実行。
        if($message_type=='message') {
            // LINE-BOT-SDKの設定
            $client = new Client();
            $config = new Configuration();
            $config->setAccessToken(config('services.line.channel_token'));
            $messagingApi = new MessagingApiApi(
                client: $client,
                config: $config,
            );

            // 送信してきたユーザーのアカウントをreplyTokenとして取得
            $reply_token=$inputs['events'][0]['replyToken'];

            // メッセージを送信してきたユーザーのLINEIDをuserIdに代入
            $userId=$request['events'][0]['source']['userId'];

            // userIdがあるユーザーを検索
            $user=User::where('line_id', $userId)->first();

            // LINEとの連携をしていないユーザーのメッセージに対してはエラーメッセージを送信。
            if($user==NULL) {
                $message = new TextMessage(['type' => 'text','text' => 'LINEと連携しているアカウントが見つかりませんでした。PrimeTaskにログインして、LINEアカウントとの連携を行うことでLINEからのタスク登録が行えるようになります。'.
                "\n".
                "\n".
                '▼PrimeTask'.
                "\n".
                'https://primetask-a3cf57557e78.herokuapp.com/'
            ]);
                $request = new ReplyMessageRequest([
                    'replyToken' => $reply_token,
                    'messages' => [$message],
                ]);
                $response = $messagingApi->replyMessage($request);

                return 'ok';
            }

            // ユーザーの送信してきたメッセージの内容を、$text_messageに代入
            $text_message = $inputs['events'][0]['message']['text'];

            // メッセージで"確認"と受信した場合に、ユーザーのタスクの一覧をメッセージとして送信
            if($text_message === "確認" || $text_message === "かくにん") {
                $replyUserId = $user->id;
                $mainTasks = MainTask::where('user_id', $user->id)
                            ->whereIn('status', ['未着手', '着手中'])
                            ->get();

                $messages = '';
                foreach ($mainTasks as $mainTask) {
                    $messages .= 'タスク名' . "\n" .
                                '「' . $mainTask->title . '」' .  "\n" .
                                 "\n";
                }

                // ユーザーのタスク一覧をメッセージ送信として送信。
                $textMessage = new TextMessage(['type' => 'text','text' => $messages .
                '以上が「未着手」及び、「着手中」のタスクとして登録されています。'.
                "\n".
                "\n".
                '▼PrimeTask'.
                "\n".
                'https://primetask-a3cf57557e78.herokuapp.com/'
                ]);

                $request = new ReplyMessageRequest([
                    'replyToken' => $reply_token,
                    'messages' => [$textMessage],
                ]);
                $response = $messagingApi->replyMessage($request);

                return 'ok';
            }

            //送信されたメッセージをタスクとして登録する
            $mainTask = new MainTask;
            $mainTask->user_id = $user->id;
            $mainTask->title = $text_message;
            $mainTask->status = '未着手';
            $mainTask->save();

            $message = new TextMessage(['type' => 'text','text' => '「'.$text_message.'」'.'をタスクとして新しく作成しました。' . "\n" .
            "\n".
            'タスクを確認する場合は「かくにん」または「確認」と送信することで、現在「未着手」及び「着手中」のステータスのタスクを確認することができます。'.
            "\n".
            "\n".
            '▼PrimeTask'.
            "\n".
            'https://primetask-a3cf57557e78.herokuapp.com/'
            ]);
            $request = new ReplyMessageRequest([
                'replyToken' => $reply_token,
                'messages' => [$message],
            ]);

            $response = $messagingApi->replyMessage($request);
        }
    }
}
