<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

class Sponsor extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'show_on_main', 'image'];

    public static function sortable($list = false)
    {
        $columns = [
            'id', 'name', 'show_on_main', 'created_at', 'updated_at', 'deleted_at'
        ];
        return ($list ? implode(',', $columns) : $columns);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
            'subdomains.*' => 'exists:subdomains,id',
            'image' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
        ];
    }

    public function setImage($name)
    {

        if (Input::file($name)->isValid()) {
            if ($this->image) {
                File::delete('sponsors/images/' . $this->image);
            }
            $this->image = uniqid() . '.' . Input::file($name)->getClientOriginalExtension();
            Input::file($name)->move('sponsors/images/', $this->image);
        }
    }

    public function getImageAttribute($image)
    {
        if ($image) {
            return url('sponsors/images/' . $image);
        }
        return null;
    }

    public function setShowOnMainAttribute($value)
    {

        if ($value) {
            $this->attributes['show_on_main'] = 1;
        } else {
            $this->attributes['show_on_main'] = 0;
        }
    }

    public function subdomains()
    {
        return $this->belongsToMany(Subdomain::class, 'sponsor_subdomain', 'sponsor_id', 'subdomain_id');
    }
}
