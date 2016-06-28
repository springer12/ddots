<?php
namespace App;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivationRepository
{

    protected $table = 'user_activations';


    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function createActivation($user)
    {

        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);

    }

    private function regenerateToken($user)
    {

        $token = $this->getToken();
        DB::table($this->table)->where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    private function createToken($user)
    {
        $token = $this->getToken();
        DB::table($this->table)->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    public function getActivation($user)
    {
        return DB::table($this->table)->where('user_id', $user->id)->first();
    }


    public function getActivationByToken($token)
    {
        return DB::table($this->table)->where('token', $token)->first();
    }

    public function deleteActivation($token)
    {
        DB::table($this->table)->where('token', $token)->delete();
    }

}