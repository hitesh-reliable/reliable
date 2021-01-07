<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model {
    use HasFactory;

    protected $table = 'poll_option';
    protected $fillable = ['id', 'pollId', 'pollOption', 'created_at', 'updated_at'];


}
