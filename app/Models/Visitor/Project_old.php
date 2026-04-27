<?php

namespace App\Models\Visitor;

use App\Models\Visitor\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function staff()
{
    return $this->hasMany(Staff::class, 'emp_project_id', 'project_id');
}

}
