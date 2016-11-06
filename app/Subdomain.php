<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class Subdomain extends Model
{
    use SoftDeletes;
    use Sortable;

    protected static $sortable_columns = [
        'id', 'name', 'fullname', 'title', 'created_at', 'updated_at', 'deleted_at'
    ];

    const DEFAULT_SUB_DOMAIN = 'labs';

    protected $fillable = ['name', 'fullname', 'description', 'title'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subdomain_user', 'subdomain_id', 'user_id');
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|alpha_dash',
            'fullname' => 'required|max:255|alpha_dash_spaces',
            'title' => 'required|max:255|alpha_dash_spaces',
            'description' => 'required|max:255',
            'image' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
        ];
    }

    public static function currentSubdomainName()
    {
        if (\Schema::hasTable('subdomains')) {
            $subdomain = self::where('name', explode('.', \Request::getHost())[0])
                ->get()
                ->first();
        }
        if (empty($subdomain)) {
            return self::DEFAULT_SUB_DOMAIN;
        }
        return $subdomain->name;
    }

    public static function currentSubdomain()
    {
        return self::current()->firstOrFail();
    }

    public function scopeCurrent($query)
    {
        return $query->where('name', explode('.', \Request::getHost())[0]);
    }

    private function getImageFilePath()
    {
        return 'subdomains/images/';
    }

    public function setImage($name)
    {
        if (Input::file($name)->isValid()) {
            if ($this->image) {
                File::delete($this->getImageFilePath() . $this->image);
            }
            $this->image = uniqid() . '.' . Input::file($name)->getClientOriginalExtension();
            Input::file($name)->move($this->getImageFilePath(), $this->image);
        }
    }

    public function getImageAttribute($image)
    {
        if ($image) {
            return url($this->getImageFilePath() . $image);
        }
        return null;
    }

    public function getUrl($postpend = '')
    {
        return 'http://' . $this->name . '.' . config('app.domain') . '/' . $postpend;
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_subdomain', 'subdomain_id', 'sponsor_id');
    }
}
