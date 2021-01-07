<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollDetail extends Model {
    use HasFactory;

    /**
     * Set Pagination Size for this Model
     */
    const Pagination = 10;

    /**
     * Poll Status if ongoing or completed
     */
    const StatusOngoing = 1;
    const StatusCompleted = 2;

    protected $table = 'poll_detail';
    protected $fillable = ['id', 'pollName', 'pollDescription', 'pollTiming', 'status', 'created_at', 'updated_at'];

    public static function pollStatus() {
        return [
            self::StatusOngoing => 'Ongoing',
            self::StatusCompleted => 'Completed'
        ];
    }

    public function getPollOption() {
        return $this->hasMany('App\Models\PollOption', 'pollId', 'id');
    }

}
