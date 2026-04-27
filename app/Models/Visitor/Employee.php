<?php
namespace App\Models\Visitor;

use App\Models\Visitor\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';

    public function visit()
    {
        return $this->hasMany(Visit::class, 'staff_id', 'employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'emp_project_id', 'project_id');
    }

    
}
