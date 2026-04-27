<?php
namespace App\Models\Visitor;

use App\Models\HR\Employee;
use App\Models\Visitor\VisitorCard;
use App\Models\Visitor\Visitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        // Add other fields to cast as necessary
    ];
    
    protected $table = 'visit_details';
    
    protected $fillable = ['visitor_id', 'staff_id', 'purpose', 'cardno', 'accompanied', 'exit_time'];

    public function employee(){
        return $this->belongsTo(Employee::class, 'staff_id', 'employee_id');
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }

    public function card()
    {
        return $this->belongsTo(VisitorCard::class, 'cardno', 'card_no');
    }
    
}
