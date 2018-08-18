<?php

namespace App;

use App\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'content', 'category_id', 'user_id','private'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function getHtmlAttribute() {
        return Markdown::parse($this->content);
    }

    public function getExcerpt($max_words = 100, $ending = "...") {
        $text = strip_tags($this->html);
        $words = explode(' ', $text);
        if (count($words) > $max_words) {
            return implode(' ', array_slice($words, 0, $max_words)) . $ending;
        }
        return $text;
    }

    public function getDates(){
        return ['created_at','updated_at','published_at'];
    }

    public function scopeVisibleForUser($query){
        if(Auth::guest())return $query->where('private',false);
        //if(Auth::id()){
            if(Auth::user()->isAdmin()) return $query;
            else return $query->where('private',false)->orWhere('user_id', Auth::id());//
        //}else return $query->where('private',false);
    }

    public function scopeOfUser($query){
        if(Auth::guest())return;
        if(Auth::user()->isAdmin()) return $query;
        else return $query->Where('user_id', Auth::id());//
        
    }
}


                
