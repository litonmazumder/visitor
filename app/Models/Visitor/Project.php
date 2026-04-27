<?php

namespace App\Models\Visitor;

use App\Models\Visitor\Staff;
use App\Models\Portal\TeamLeader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_id';
    protected $connection = 'mysql_secondary';
    protected $table = 'projects';

    public function staff()
    {
        return $this->hasMany(Staff::class, 'emp_project_id', 'project_id');
    }

    public function teamLeader()
    {
        return $this->hasOne(TeamLeader::class, 'project_id', 'project_id');
    }


}
