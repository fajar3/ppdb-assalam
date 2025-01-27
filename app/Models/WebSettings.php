<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSettings extends Model
{
    protected $fillable = [
        'name',
        'title_home',
        'title_dashboard',
        'title_exam',
        'footer',
        'contact_telp',
        'contact_email',
        'contact_fax',
        'contact_address',
        'contact_maps',
        'contact_facebook',
        'contact_whatsapp',
        'contact_instagram',
        'contact_twitter',
        'contact_youtube',
        'link_univ',
    ];
}

