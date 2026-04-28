<?php

namespace App\Models\HR;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable
{

    protected $fillable = [
                'name',
                'email',
                'designation',
                'department',
                'status',
            ];
    
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';

    public $incrementing = true; // if it's auto-increment
    protected $keyType = 'int';  // or 'string' if needed

    public function visit()
    {
        return $this->hasMany(Visit::class, 'staff_id', 'employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'emp_project_id', 'project_id');
    }
    
}
