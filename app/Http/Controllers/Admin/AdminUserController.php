<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserUpdateRequest;

class AdminUserController extends Controller
{
    /**
     * 사용자 전체 조회
     */
    public function index()
    {
        $users = User::latest()->withTrashed()->paginate(20);

        return view('admin.user-index', compact('users'));
    }

    /**
     * 특정 사용자 상세 조회
     */
    public function show(User $user)
    {
        return view('admin.user-show', compact('user'));
    }

    /**
     * 사용자 정보 수정 폼 표시
     */
    public function edit(User $user)
    {
        return view('admin.user-edit', compact('user'));
    }

    /**
     * 사용자 정보 수정
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', __('User information has been updated.'));
    }

    /**
     * 사용자 삭제
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', __('User has been deleted.'));
    }

    /**
     * 사용자 정지
     */
    public function ban(Request $request, User $user) 
    {
        // 1. 입력값 유효성 검사
        $request->validate([
            'reason' => 'required|string|max:255',
            'period' => 'required|integer|min:0', // 0이면 영구 정지, 그 외에는 일수
        ]);

        // 2. 정지 종료일 계산
        // period가 0보다 크면 현재 시간 + period일, 0이면 null (영구 정지)
        $bannedUntil = $request->period > 0 ? now()->addDays((int)$request->input('period')) : null;

        // 3. UserBan 모델 생성
        $user->bans()->create([
            'reason' => $request->reason,
            'banned_until' => $bannedUntil,
        ]);

        return back()->with('success', __('User has been banned.'));
    }

    /** 
     * 사용자 정지 해제
     */
    public function unban(User $user)
    {
        // 현재 적용 중인 밴(영구 정지이거나, 아직 기간이 남은 정지)을 찾아서 삭제
        $user->bans()
            ->where(function ($query) {
                $query->whereNull('banned_until') // 영구 정지
                      ->orWhere('banned_until', '>', now()); // 기간이 남은 정지
            })
            ->delete();

        return back()->with('success', __('User has been unbanned.'));
    }
}
