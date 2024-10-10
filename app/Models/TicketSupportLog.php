<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSupportLog extends Model
{
    use HasFactory;

    protected $table = 'ticket_support_logs';

    protected $fillable = [
        'ticket_id',
        'description',
    ];
}
