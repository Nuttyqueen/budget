<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function create()
    {
        return view('members.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prefix' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date|before_or_equal:today',
            'profile_image' => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $imagePath;
        }

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'สมาชิกใหม่ถูกบันทึกเรียบร้อยแล้ว');
    }

    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->has('search')) {
            $query->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name', 'like', "%{$request->search}%");
        }

        $members = $query->get()->sortByDesc(function ($member) {
            return \Carbon\Carbon::parse($member->birthdate)->age;
        });


        /*         $members = Member::all();
        $ageGroups = ['0-10', '11-20', '21-30', '31-40', '41-50', '51+'];
        $memberCounts = array_fill(0, count($ageGroups), 0);
        foreach ($members as $member) {
            $age = $member->age;

            if ($age <= 10) $memberCounts[0]++;
            elseif ($age <= 20) $memberCounts[1]++;
            elseif ($age <= 30) $memberCounts[2]++;
            elseif ($age <= 40) $memberCounts[3]++;
            elseif ($age <= 50) $memberCounts[4]++;
            else $memberCounts[5]++;
        } */

        return view('members.index', compact('members'/* , 'ageGroups', 'memberCounts' */));
    }
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'prefix' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date|before_or_equal:today',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $member = Member::findOrFail($id);

        if ($request->hasFile('profile_image')) {
            if ($member->profile_image) {
                Storage::disk('public')->delete($member->profile_image);
            }
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $imagePath;
        }

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'ข้อมูลสมาชิกถูกอัปเดตเรียบร้อยแล้ว');
    }
    public function destroy(Member $member)
    {
        if ($member->profile_image) {
            Storage::disk('public')->delete($member->profile_image);
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'ข้อมูลสมาชิกถูกลบเรียบร้อยแล้ว');
    }
    public function updateFinance(Request $request)
    {
        return $income = $request->input('income', []);
        $income = $request->input('income', []);
        $expense = $request->input('expense', []);

        foreach ($income as $memberId => $amount) {
            $member = Member::find($memberId);
            if ($member) {
                $member->total_income = $amount;
                $member->save();
            }
        }

        foreach ($expense as $memberId => $amount) {
            $member = Member::find($memberId);
            if ($member) {
                $member->total_expense = $amount;
                $member->save();
            }
        }

        return redirect()->route('members.index')->with('success', 'ข้อมูลรายรับและรายจ่ายถูกบันทึกเรียบร้อยแล้ว');
    }
}
