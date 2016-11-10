<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetraReportada extends Model
{
    protected $table = 'letras_reportadas';

    protected $fillable = ['descripcion'];

}
