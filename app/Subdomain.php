<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdomain extends Model
{
    const DEFAULT_SUB_DOMAIN = 'labs';
    public static function currentSubdomainName() {
        if(\Schema::hasTable('subdomains')) {
            $subdomain = self::where('name', explode('.', \Request::getHost())[0])
                ->get()
                ->first();
        }
        if(empty($subdomain)) {
            return self::DEFAULT_SUB_DOMAIN;
        }
        return $subdomain->name;
    }

    public static function currentSubdomain() {
        return self::current()->firstOrFail();
    }

    public function scopeCurrent($query) {
        return $query->where('name', explode('.', \Request::getHost())[0]);
    }

    public function logo() {
        return ""; //@todo add logo
    }

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class, 'sponsor_subdomain', 'subdomain_id', 'sponsor_id');
    }
}
