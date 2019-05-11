<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    protected $fillable = ["first_name","surname","applicant_email","phone","cover_letter","resume","passport"];
}
