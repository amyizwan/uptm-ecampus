<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'comments',
        'marks',
        'feedback',
        'submitted_at',
        'graded_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime'
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Check if submission is graded
    public function isGraded()
    {
        return !is_null($this->marks);
    }

    // Get grade status
    public function getGradeStatus()
    {
        return $this->isGraded() ? 'Graded' : 'Pending';
    }

    // Get grade badge color
    public function getGradeBadgeColor()
    {
        return $this->isGraded() ? 'success' : 'warning';
    }
}