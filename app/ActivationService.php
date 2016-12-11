<?php

namespace App;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ActivationService
{
    protected $activationRepo;

    protected $resendAfter = 24;
    protected $mailSender = 'Dots@dots.org.ua';

    public function __construct(ActivationRepository $activationRepo)
    {
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail(User $user)
    {
        if (!$user->hasRole(User::ROLE_LOW_USER) || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = action('UserController@verify', $token);

        Mail::send('user.emails.verify_email', ['link' => $link], function (Message $m) use ($user) {
            $m->from($this->mailSender, 'Dots');
            $m->to($user->email)->subject('Activation mail');
        });


    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->upgrade();

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}