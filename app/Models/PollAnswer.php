<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model {
    use HasFactory;

    protected $table = 'poll_answer';
    protected $fillable = ['id', 'pollId', 'optionId', 'userId', 'created_at', 'updated_at'];


}
