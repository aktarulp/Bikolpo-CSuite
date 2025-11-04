<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCReator extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'qcreators';

    protected $fillable = [
        'full_name',
        'designation',
        'organization',
        'experiences',
        'remarks',
        'photo',
        'email',
        'phone',
    ];

    protected $casts = [
        'experiences' => 'string',
        'remarks' => 'string',
    ];

    // Relationship with exams
    public function exams()
    {
        return $this->hasMany(Exam::class, 'qcreator_id');
    }

    // Accessor to get the full photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Extract filename from the stored path
            $filename = basename($this->photo);
            
            // Use direct serving route for better Hostinger compatibility
            return route('qcreator.photo.serve', ['filename' => $filename]);
        }
        return url('images/default-avatar.svg');
    }
}