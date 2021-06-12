<?php

namespace App\Http\Filters;

use App\Models\Symbol;
use Illuminate\Database\Eloquent\Builder;

class ClientsFilter extends Filter
{
    /**
     * @var string[]
     */
    protected $filters = [
      'id', 'name', 'email'
    ];

    protected function id($id)
    {
        if ($id != "") $this->builder->where('id',  $id);
    }


    protected function name($name)
    {
        if ($name != "") $this->builder->where('name',  $name);
    }


    protected function email($email)
    {
        if ($email != "") $this->builder->where('email',  $email);
    }


}
