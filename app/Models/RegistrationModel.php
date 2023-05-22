<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    protected $table = 'registrations';
    protected $fillable = [
        'event', 'start_date', 'end_date', 'name', 'cpf', 'email'
    ];

    public function index($columnFilter, $filter, $eventId)
    {
        return $this;
    }

    public function getByEvent($columnFilter, $filter, $eventId)
    {
        return $this->where($columnFilter, 'LIKE', '%' . $filter . '%');
    }

    public function createRegistration($data)
    {
        return $this->create($data);
    }
}
