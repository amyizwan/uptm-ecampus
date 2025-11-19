<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'lecturer_id',
        'due_date',
        'max_marks',
        'file_path',
        'is_published'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_published' => 'boolean'
    ];
    
    // Relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function submissions()
{
    return $this->hasMany(AssignmentSubmission::class);
}

    // Check if assignment is overdue
    public function isOverdue()
    {
        return $this->due_date < now();
    }

    // Get submission count
    public function getSubmissionCount()
    {
        return $this->submissions()->count();
    }

    // Get student's submission
    public function studentSubmission($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }

    // ADD THIS: Relationship for user (alias for lecturer)
    public function user()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }
}