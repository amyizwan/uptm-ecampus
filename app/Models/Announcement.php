<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'subject_id',
        'priority',
        'is_published',
        'publish_at',
        'expire_at'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'expire_at' => 'datetime',
        'is_published' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Scope for published announcements
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where(function($q) {
                        $q->whereNull('publish_at')
                          ->orWhere('publish_at', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('expire_at')
                          ->orWhere('expire_at', '>=', now());
                    });
    }

    // Check if announcement is active
    public function isActive()
    {
        return $this->is_published &&
               (!$this->publish_at || $this->publish_at <= now()) &&
               (!$this->expire_at || $this->expire_at >= now());
    }

    // Get priority badge color - PHP 7 COMPATIBLE VERSION
    public function getPriorityBadge()
    {
        switch ($this->priority) {
            case 'high':
                return 'danger';
            case 'medium':
                return 'warning';
            case 'low':
                return 'info';
            default:
                return 'secondary';
        }
    }
}