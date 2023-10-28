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
            // 送信してきたユーザーのアカウントをreplyTokenとして取得
            $reply_token=$inputs['events'][0]['replyToken'];

            $client = new Client();
            $config = new Configuration();
            $config->setAccessToken(config('services.line.channel_token'));
            $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
            );

            //送信されたメッセージをタスクとして登録する
            // ユーザーの送信してきたメッセージの内容を、$text_messageに代入
            $text_message = $inputs['events'][0]['message']['text'];

            // LINEのユーザーIDをuserIdに代入
            $userId=$request['events'][0]['source']['userId'];
            // userIdがあるユーザーを検索
            $user=User::where('line_id', $userId)->first();

            // LINEとの連携をしていないユーザーのメッセージに対してはエラーメッセージを送信。
            if($user==NULL) {
                $message = new TextMessage(['type' => 'text','text' => 'LINEと連携しているアカウントが見つかりませんでした。PrimeTaskにログインして、LINEアカウントとの連携を行うことでLINEからのタスク登録が行えるようになります。']);
                $request = new ReplyMessageRequest([
                    'replyToken' => $reply_token,
                    'messages' => [$message],
                ]);
                $response = $messagingApi->replyMessage($request);

                return 'ok';
            }

            $mainTask = new MainTask;
            $mainTask->user_id = $user->id;
            $mainTask->title = $text_message;
            $mainTask->save();

            $message = new TextMessage(['type' => 'text','text' => '「'.$text_message.'」'.'をタスクとして新しく作成しました。']);
            $request = new ReplyMessageRequest([
                'replyToken' => $reply_token,
                'messages' => [$message],
            ]);
            $response = $messagingApi->replyMessage($request);
        }
    }
}

// 旧Messaging API
// class LineMessengerController extends Controller
// {
//     public function webhook(Request $request) {
//         // LINEから送られた内容を$inputsに代入
//         $inputs=$request->all();

//         // そこからtypeをとりだし、$message_typeに代入
//         $message_type=$inputs['events'][0]['type'];

//         // メッセージが送られた場合、$message_typeは'message'となる。その場合処理実行。
//         if($message_type=='message') {

//             // replyTokenを取得
//             $reply_token=$inputs['events'][0]['replyToken'];

//             file_put_contents('services.line.channel_token.txt', config('services.line.channel_token'));
//             // LINEBOTSDKの設定
//             $http_client = new CurlHTTPClient(config('services.line.channel_token'));
//             $bot = new LINEBot($http_client, ['channelSecret' => config('services.line.messenger_secret')]);

//             // 送信するメッセージの設定
//             $reply_message='メッセージありがとうございます';

//             // ユーザーにメッセージを返す
//             $reply=$bot->replyText($reply_token, $reply_message);

//             return 'ok';
//         }
//     }
// }
