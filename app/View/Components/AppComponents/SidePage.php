<?php

namespace App\View\Components\AppComponents;

use Closure;
use App\Models\User;
use App\Models\Follows;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class SidePage extends Component
{
    /**
     * Create a new component instance.
     */
    public $role;
    public function __construct($role)
    {
        $this->role=$role;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $authUserId = Auth::id();


$followings = Follows::select('friend_user_a')
    ->fromSub(function ($query) use ($authUserId) {
        $query->select('f1.following_id AS user_a', 'f1.follower_id AS friend_user_a')
            ->from('follows as f1')
            ->where('f1.follower_id', $authUserId);

        $query->unionAll(function ($query) use ($authUserId) {
            $query->select('f2.following_id AS user_b', 'f2.follower_id AS friend_user_b')
                ->from('follows as f2')
                ->whereIn('f2.following_id', function ($subquery) use ($authUserId) {
                    $subquery->select('follower_id')
                        ->from('follows')
                        ->where('following_id', $authUserId);
                });
        });
    }, 'following_cte')
    ->whereNotIn('following_cte.friend_user_a', function ($subquery) use ($authUserId) {
        $subquery->select('follower_id')
            ->from('follows')
            ->where('following_id', $authUserId);
    })
    ->where('following_cte.friend_user_a', '!=', $authUserId)
    ->distinct()
    ->get();
    $users = User::whereIn('id', $followings->pluck('friend_user_a'))
    ->take(5)
    ->get();

    if($users->isEmpty())
    $users= User::inRandomOrder()->where('id','!=',$authUserId)->take(5)->get();
        return view('components.app-components.side-page',['users'=>$users]);
    }
}
