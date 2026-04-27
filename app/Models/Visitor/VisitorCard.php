<?php
namespace App\Models\Visitor;

use App\Models\Visitor\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorCard extends Model
{
    use HasFactory;

    protected $table = 'visitor_card';

}
