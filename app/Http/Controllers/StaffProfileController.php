<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        $stats = [
            'total_articles' => Article::where('user_id', $userId)->count(),
            'published'      => Article::where('user_id', $userId)->where('status', 'published')->count(),
            'views'          => Article::where('user_id', $userId)->sum('views'),
            'downloads'      => Article::where('user_id', $userId)->sum('downloads'),
            'likes'          => Like::whereHas('article', fn($q) => $q->where('user_id', $userId))->count(),
            'comments'       => Comment::whereHas('article', fn($q) => $q->where('user_id', $userId))->count(),
            'rating'         => Article::where('user_id', $userId)->avg('rating_avg'),
        ];
        
        $recentActivities = Article::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $badges = [
            'top_contributor'   => $stats['total_articles'] >= 5,
            'knowledge_master'  => $stats['total_articles'] >= 20,
            'most_viewed'       => $stats['views'] >= 5000,
            '100_articles'      => $stats['total_articles'] >= 100,
        ];

        return view('staff-profile', compact('user', 'stats', 'recentActivities', 'badges'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'nip'       => 'nullable|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'bidang'    => 'nullable|string|max:255',
            'jabatan'   => 'nullable|string|max:255',
            'no_hp'     => 'nullable|string|max:20',
            'bio'       => 'nullable|string',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->except(['password', 'password_confirmation']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}