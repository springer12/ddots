<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['name', 'content'];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = str_replace('<img', '<img class="article-image-size" ', $value);
        $this->attributes['stripped_content'] = trim(preg_replace('/\s{2,}/', ' ', html_entity_decode(strip_tags($value))));
    }

    public function scopeMain($query)
    {
        return $query->where('show_on_main', true);
    }
}
