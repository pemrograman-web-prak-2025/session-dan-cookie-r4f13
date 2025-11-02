<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        $leader = Auth::user();

        if (!$leader) redirect()->route('login')->with('error', 'Log In terlebih dahulu');

        $units = Unit::with('leader')->get();

        $byParent = $units->groupBy('parent_id');

        $rootUnit = Unit::where('leader_id', $leader->id)->first();

        if (!$rootUnit) {
            return view('units', ['units' => []])->with('error', 'Tidak ada unit yang dipimpin.');
        }

        $buildTree = function ($parentId) use (&$buildTree, $byParent) {
            return ($byParent[$parentId] ?? collect())->map(function ($unit) use (&$buildTree, $byParent) {
                return [
                    'id' => $unit->id,
                    'name' => $unit->name,
                    'leader' => $unit->leader?->name,
                    'image_url' => $unit->image_url,
                    'location' => $unit->location,
                    'description' => $unit->description,
                    'children' => $buildTree($unit->id),
                ];
            })->values()->toArray();
        };

        $rootTree = [
            'id' => $rootUnit->id,
            'name' => $rootUnit->name,
            'leader' => $rootUnit->leader?->name,
            'image_url' => $rootUnit->image_url,
            'location' => $rootUnit->location,
            'description' => $rootUnit->description,
            'children' => $buildTree($rootUnit->id),
        ];

        $tree = [$rootTree];

        // return response()->json($tree);
        return view('units', ['units' => $tree]);
    }

    protected function isUnderLeader(Unit $unit, $leaderId){
        while ($unit) {
            if ((int)$unit->leader_id == (int)$leaderId) {
                return true;
            }
            $unit = $unit->parent;
        }
        return false;
    }


    public function delete($id)
    {
        $user = Auth::user();
        $unit = Unit::findOrFail($id);

        if (!$this->isUnderLeader($unit, $user->id)) {
            return redirect('/units')->with('error', 'Anda tidak memimpin unit ini');
        }

        $unit->delete();
        return redirect('/units')->with('success', 'Unit berhasil dihapus');
    }

    public function create(Request $request){
        $user = Auth::user();
        $parentId = $request->input('parent_id');
        $parentUnit = Unit::findOrFail($parentId);

        // if (!$this->isUnderLeader($parentUnit, $user->id)) {
        //     return redirect('/units')->with('error', 'Anda tidak memimpin unit ini');
        // }

        $leaderName = $request->input('leader');

        $leader = Leader::firstWhere('name', $leaderName);

        if ($leader) {
            $existingUnit = Unit::where('leader_id', $leader->id)
                    ->first();
            if ($existingUnit) {
                return redirect('/units')->with('error', 'Leader ini sudah memimpin unit lain');
            }
            $leaderId = $leader->id;
        } else if(!empty($leaderName)) {
            $leader = Leader::create([
                'name' => $leaderName,
                'password' => bcrypt('12345'),
            ]);
            $leaderId = $leader->id;
        }

        $unit = Unit::create([
            'name' => $request->input('name'),
            'leader_id' => $leaderId??null,
            'parent_id' => $parentId,
            'description' => $request->input('description') ?? null,
            'location' => $request->input('location') ?? null,
            'image_url' => $request->input('image_url') ?? null,
        ]);

        return redirect('/units')->with('success', 'Unit berhasil dibuat');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $unit = Unit::findOrFail($id);
        $user = Auth::user();

        // if (!$this->isUnderLeader($unit, $user->id)) {
        //     return redirect('/units')->with('error', 'Anda tidak memiliki akses untuk mengedit unit ini');
        // }

        $leaderName = $request->input('leader');

        // Ambil leader jika ada
        $leader = Leader::firstWhere('name', $leaderName);

        if ($leader) {
            //Abaikan jika leader tidak diubah
            if($unit['leader_id']!=$leader['id']){
                $existingUnit = Unit::firstWhere('name', $leader['name']);
                if ($existingUnit) {
                    return redirect('/units')->with('error', 'Leader ini sudah memimpin unit lain');
                }
            }
            $leaderId = $leader->id;
        } else if(!empty($leaderName)) {
            $leader = Leader::create([
                'name' => $leaderName,
                'password' => bcrypt('12345'),
            ]);
            $leaderId = $leader->id;
        }

        $unit->update([
            'name' => $request->input('name'),
            'leader_id' => $leader->id,
            'image_url' => $request->input('image_url'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
        ]);

        return redirect('/units')->with('success', 'Unit berhasil diperbarui');
    }


}
