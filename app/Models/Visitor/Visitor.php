<?php
namespace App\Models\Visitor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor\VisitorCompany;

class Visitor extends Model
{
    use HasFactory;
    
    protected $table = 'visitor_details';

    protected $fillable = ['name', 'mobile', 'email', 'visitor_company_id'];

    public function visits()
    {
        return $this->hasMany(Visit::class, 'visitor_id', 'id')->orderBy('entry_time', 'desc');; // visitor_id should match the foreign key in Visit
    }

    public function company()
    {
        return $this->belongsTo(VisitorCompany::class, 'visitor_company_id');
    }

    public function staff()
    {
        return $this->belongsTo(Employee::class);
    }

}
