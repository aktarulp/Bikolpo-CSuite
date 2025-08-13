<?php

namespace App\Http\Controllers;

use App\Models\TypingPassage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TypingPassageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $passages = TypingPassage::with('creator')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['data' => $passages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Create method called']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string|min:10',
            'language' => 'required|in:english,bangla',
            'difficulty' => 'required|in:easy,medium,hard',
            'category' => 'required|in:general,technical,literature,news,academic,business',
            'author' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Calculate word and character counts
        $text = $request->passage_text;
        $wordCount = str_word_count($text);
        $charCount = strlen($text);

        $passage = TypingPassage::create([
            'title' => $request->title,
            'passage_text' => $text,
            'language' => $request->language,
            'difficulty' => $request->difficulty,
            'category' => $request->category,
            'author' => $request->author,
            'source' => null, // We don't have this field in the form
            'description' => $request->description,
            'word_count' => $wordCount,
            'character_count' => $charCount,
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Passage created successfully!',
            'passage' => $passage
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypingPassage $typingPassage)
    {
        return response()->json(['data' => $typingPassage]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypingPassage $typingPassage)
    {
        return response()->json(['data' => $typingPassage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypingPassage $typingPassage)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string|min:10',
            'language' => 'required|in:english,bangla',
            'difficulty' => 'required|in:easy,medium,hard',
            'category' => 'required|in:general,technical,literature,news,academic,business',
            'author' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Calculate word and character counts
        $text = $request->passage_text;
        $wordCount = str_word_count($text);
        $charCount = strlen($text);

        $typingPassage->update([
            'title' => $request->title,
            'passage_text' => $text,
            'language' => $request->language,
            'difficulty' => $request->difficulty,
            'category' => $request->category,
            'author' => $request->author,
            'source' => $request->source,
            'description' => $request->description,
            'word_count' => $wordCount,
            'character_count' => $charCount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Passage updated successfully!',
            'passage' => $typingPassage
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypingPassage $typingPassage)
    {
        $typingPassage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Passage deleted successfully!'
        ]);
    }

    /**
     * Get passages for typing test
     */
    public function getPassages(Request $request)
    {
        $query = TypingPassage::active();

        if ($request->has('language')) {
            $query->byLanguage($request->language);
        }

        if ($request->has('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        $passages = $query->inRandomOrder()->limit(10)->get();

        return response()->json([
            'success' => true,
            'passages' => $passages
        ]);
    }

    /**
     * Update passage statistics after test completion
     */
    public function updateStats(Request $request, TypingPassage $typingPassage)
    {
        $validator = Validator::make($request->all(), [
            'wpm' => 'required|integer|min:0',
            'accuracy' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $typingPassage->incrementUsageCount();
        $typingPassage->updateAverageStats($request->wpm, $request->accuracy);

        return response()->json([
            'success' => true,
            'message' => 'Statistics updated successfully!'
        ]);
    }

    /**
     * Toggle passage active status
     */
    public function toggleStatus(TypingPassage $typingPassage)
    {
        $typingPassage->update([
            'is_active' => !$typingPassage->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Passage status updated successfully!',
            'is_active' => $typingPassage->is_active
        ]);
    }
}
