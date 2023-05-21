<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Registration extends Model
{
    protected $table = 'registrations';
    protected $fillable = ['start_date', 'end_date', 'event','name', 'cpf', 'email'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

   public function scopeFilter($query, $column, $filter)
{
    return $query->where($column, 'LIKE', '%' . $filter . '%');
}
}