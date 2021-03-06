<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

/**
 * App\Sponsor
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $link
 * @property string $image
 * @property boolean $show_on_main
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subdomain[] $subdomains
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereShowOnMain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sponsor main()
 * @mixin \Eloquent
 */
class Sponsor extends Model
{
    use SoftDeletes;
    use Sortable;
    
    protected static $sortable_columns = [
        'id', 'name', 'show_on_main', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $fillable = ['name', 'description', 'show_on_main', 'image', 'link'];



    public static function getValidationRules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:3000',
            'link' => 'url|required|max:255',
            'subdomains.*' => 'exists:subdomains,id',
            'image' => 'mimetypes:image/jpeg,image/bmp,image/png|max:1000',
        ];
    }

    public function setImage($name)
    {

        if (Input::file($name)->isValid()) {
            if ($this->image) {
                File::delete('sponsordata/images/' . $this->image);
            }
            $this->image = uniqid() . '.' . Input::file($name)->getClientOriginalExtension();
            Input::file($name)->move('sponsordata/images/', $this->image);
        }
    }

    public function getImageAttribute($image)
    {
        if ($image) {
            return url('sponsordata/images/' . $image);
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

    public function scopeMain($query)
    {
        return $query->where('show_on_main', true);
    }
}
