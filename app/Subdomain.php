<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class Subdomain extends Model
{
    use SoftDeletes;
    const DEFAULT_SUB_DOMAIN = 'labs';

    protected $fillable = ['name', 'fullname', 'description', 'title'];

    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'fullname', 'title', 'created_at', 'updated_at', 'deleted_at'
        ];

        return ($list ? implode(',', $columns) : $columns);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255|alpha_dash',
            'fullname' => 'required|max:255|alpha_dash_spaces',
            'title' => 'required|max:255|alpha_dash_spaces',
            'description' => 'required|max:255|alpha_dash_spaces',
            'image' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
        ];
    }

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

    private function getImageFilePath(){
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

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class, 'sponsor_subdomain', 'subdomain_id', 'sponsor_id');
    }
}
