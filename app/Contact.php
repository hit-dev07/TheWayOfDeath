<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'userId','contactUserId', 'roomId', 'new_msg_count', 'last_message', 'last_time'
    ];
    public function user(){
        return $this->belongsTo(User::class,'contactUserId');
    }
    public function roomId(){
        return $this->belongsTo(ChatRoom::class,'roomId');
    }
}
