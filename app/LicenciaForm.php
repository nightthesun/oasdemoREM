<?php

namespace App;

use App\DataForm;
use Illuminate\Database\Eloquent\Model;

class LicenciaForm extends Model
{
    protected $fillable = [
        'respaldo', 'motivo', 'hora_ini', 'hora_fin',
        'fecha_ini', 'fecha_fin', 'dias', 'horas', 'user_id'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function firmas()
    {
        return $this->hasMany(FirmaLicencia::class, 'form_id');
    }
}
