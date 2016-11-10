<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
{

    const ALL_AUTHORS = 'all';

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('date', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAuthor($query, $user)
    {
        if($user && $user != self::ALL_AUTHORS){
            return $query->where('user_id', $user);
        }
        return $query->latest('date');
    }

    public function scopeFrom($query, $from = null)
    {
        if($from){
            return $query->where('date', '>', $from);
        }
    }

    public function scopeTo($query, $to = null)
    {
        if($to){
            return $query->where('date', '<', $to);
        }
    }
}
