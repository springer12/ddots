<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdomain extends Model
{
    const DEFAULT_SUB_DOMAIN = 'labs';
    public static function currentSubdomainName() {
        $subdomain = self::where('name', explode('.', \Request::getHost())[0])
            ->get()
            ->first();
        if(empty($subdomain)) {
            return self::DEFAULT_SUB_DOMAIN;
        }
        return $subdomain->name;
    }
}
