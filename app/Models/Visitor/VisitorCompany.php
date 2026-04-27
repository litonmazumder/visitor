<?php
namespace App\Models\Visitor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor\Visitor;

class VisitorCompany extends Model
{
    use HasFactory;

    protected $table = 'visitor_company';

    protected $fillable = ['name'];

    public function visitor()
    {
        return $this->hasMany(Visitor::class, 'id');
    }
}
