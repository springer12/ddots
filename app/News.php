<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\News
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $stripped_content
 * @property integer $subdomain_id
 * @property boolean $show_on_main
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Subdomain $subdomain
 * @method static \Illuminate\Database\Query\Builder|\App\News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereStrippedContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereSubdomainId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereShowOnMain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News main()
 * @mixin \Eloquent
 */
class News extends Model
{
    use Sortable;
    use SoftDeletes;

    public static function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'content' => 'required|string|max:3000',
            'subdomain_id' => 'exists:subdomains,id',
        ];
    }

    protected static $sortable_columns = [
        'id', 'name', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $fillable = ['name', 'content', 'subdomain_id', 'show_on_main'];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = str_replace('<img', '<img class="article-image-size" ', $value);
        $this->attributes['stripped_content'] = trim(preg_replace('/\s{2,}/', ' ', html_entity_decode(strip_tags($value))));
    }

    public function scopeMain($query)
    {
        return $query->where('show_on_main', true);
    }

    public function subdomain()
    {
        return $this->belongsTo(Subdomain::class);
    }
}
