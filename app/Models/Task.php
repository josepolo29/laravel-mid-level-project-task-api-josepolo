<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['title', 'description', 'status', 'priority', 'due_date', 'project_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
