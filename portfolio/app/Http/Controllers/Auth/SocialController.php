<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function __invoke()
    {
        $social_user = Socialite::driver("github")->user();
        $user = $this->findOrCreateUser($social_user);
        Auth::login($user);
        return redirect()->route('main');

    }


    private function findOrCreateUser($social_user)
    {

        //если аккаунт был уже зареган на пользователя, возвращаем его
        if ($user = $this->findUserBySocialId($social_user->getId())) {return $user;}

        //создаем пользователя
        $user = User::create([
            'nickname' => $social_user->getNickname(),
            'email' => $social_user->getEmail(),
            'id_provider' => $social_user->getId(),
            'token' => $social_user->token,
        ]);

        return $user;
    }

    public function findUserBySocialId($id)
    {
        return User::where('id_provider', $id)->first();
    }

}
