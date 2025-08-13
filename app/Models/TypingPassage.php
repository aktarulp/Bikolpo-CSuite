<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypingPassage extends Model
{
    use HasFactory;

    protected $fillable = [
        'passage_text',
        'title',
        'language',
        'difficulty',
        'category',
        'word_count',
        'character_count',
        'author',
        'source',
        'description',
        'is_active',
        'usage_count',
        'average_wpm',
        'average_accuracy',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer',
        'average_wpm' => 'integer',
        'average_accuracy' => 'integer',
        'word_count' => 'integer',
        'character_count' => 'integer'
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes for filtering
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Methods for updating statistics
    public function incrementUsageCount()
    {
        $this->increment('usage_count');
    }

    public function updateAverageStats($wpm, $accuracy)
    {
        $currentTotalWPM = $this->average_wpm * $this->usage_count;
        $currentTotalAccuracy = $this->average_accuracy * $this->usage_count;
        
        $newTotalWPM = $currentTotalWPM + $wpm;
        $newTotalAccuracy = $currentTotalAccuracy + $accuracy;
        $newUsageCount = $this->usage_count + 1;
        
        $this->average_wpm = round($newTotalWPM / $newUsageCount);
        $this->average_accuracy = round($newTotalAccuracy / $newUsageCount);
        $this->save();
    }

    // Helper methods
    public function getFormattedWordCountAttribute()
    {
        return number_format($this->word_count);
    }

    public function getFormattedCharacterCountAttribute()
    {
        return number_format($this->character_count);
    }

    public function getDifficultyColorAttribute()
    {
        return match($this->difficulty) {
            'easy' => 'text-green-600',
            'medium' => 'text-yellow-600',
            'hard' => 'text-red-600',
            default => 'text-gray-600'
        };
    }

    public function getLanguageFlagAttribute()
    {
        return match($this->language) {
            'english' => '🇺🇸',
            'bangla' => '🇧🇩',
            default => '🌐'
        };
    }
}
