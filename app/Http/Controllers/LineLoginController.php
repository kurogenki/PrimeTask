<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LineLoginController extends Controller
{
    // Lineログイン画面を表示
    public function lineLogin()
    {
        $state = Str::random(32);
        $nonce  = Str::random(32);

        $uri ="https://access.line.me/oauth2/v2.1/authorize?";
        $response_type = "response_type=code";
        $client_id = "&client_id=".config('services.line.client_id');
        $redirect_uri ="&redirect_uri=".config('services.line.redirect');
        $state_uri = "&state=".$state;
        $scope = "&scope=openid%20profile";
        $prompt = "&prompt=consent";
        $nonce_uri = "&nonce=";

        $uri = $uri . $response_type . $client_id . $redirect_uri . $state_uri . $scope . $prompt . $nonce_uri;

        return redirect($uri);
    }

    // アクセストークン取得
    public function getAccessToken($req)
    {
        $headers = [ 'Content-Type: application/x-www-form-urlencoded' ];
        $post_data = array(
          'grant_type'    => 'authorization_code',
          'code'          => $req['code'],
          'redirect_uri'  => config('services.line.redirect'),
          'client_id'     =>  config('services.line.client_id'),
          'client_secret' => config('services.line.client_secret'),
        );
        $url = 'https://api.line.me/oauth2/v2.1/token';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));

        $res = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($res);
        $accessToken = $json->access_token;

        return $accessToken;
    }

    // プロフィール取得
    public function getProfile($at)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $at));
        curl_setopt($curl, CURLOPT_URL, 'https://api.line.me/v2/profile');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($res, true);

        if(Auth::user()) {
            $id = Auth::user()->id;
            $json = array_merge($json,array('primeTaskUserId' => $id));
        }

        return $json;
    }

    // ログイン後のページ表示
    public function callback(Request $request)
    {
        $accessToken = $this->getAccessToken($request);
        $profile = $this->getProfile($accessToken);

        // LINEログイン用のアカウントを設定
        if(array_key_exists('primeTaskUserId', $profile)) {
            $user = User::where('id', $profile['primeTaskUserId'])->first();
            $user->provider = 'line';
            $user->line_id = $profile['userId'];
            $user->save();

            return redirect('mainTask');
        }
        // LINEを使ったログイン機能
        else {
            $user = User::where('line_id', $profile['userId'])->first();
            if($user) {
                Auth::login($user);
                return redirect('mainTask');
            }
            else{
                return redirect('/login');
            }
        }
    }
}
