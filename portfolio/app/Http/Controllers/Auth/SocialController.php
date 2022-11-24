<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
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

        // если почта уже существует в базе данных, то добавляем запись в базу и возвращаем пользователя
        if ($user = $this->findUserByEmail($social_user->getEmail())) {
            $this->addSocialAccount($user, $social_user);

            return $user;
        }

        //создаем пользователя
        $user = User::create([
            'nickname' => $social_user->getNickname(),
            'email' => $social_user->getEmail(),
        ]);

        $this->addSocialAccount($user, $social_user);

        return $user;
    }

    public function findUserBySocialId($id)
    {
        $socialAccount = SocialAccount::where('id_provider', $id)->first();
        return $socialAccount ? $socialAccount->user : false;
    }

    public function findUserByEmail($email){return !$email ? null : User::where('email', $email)->first();}

    public function addSocialAccount($user, $socialiteUser)
    {
        SocialAccount::create([
            'id_user' => $user->id,
            'id_provider' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }
}
