<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Support\Facades\View;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $limit = $request->length;
            $start = $request->start;
            $query = Issue::with(['assigned', 'user'])
                ->when($request->search_keyword, function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->whereHas('assigned', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search_keyword . '%');
                        })
                            ->orWhereHas('user', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->search_keyword . '%');
                            });
                    });
                })
                ->when(is_numeric($request->status), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->query('start_date') && $request->query('end_date'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [
                        $request->start_date . " 00:00:00",
                        $request->end_date . " 23:59:59"
                    ]);
                })
                ->orderBy('id', 'desc');
            $totalFiltered = $query->count();
            $items = $query->offset($start)->limit($limit)->get();

            $data = [];
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $nestedData['title'] = $item->title ?? '-';
                    $nestedData['assigned_to'] = $item->assigned->name ?? '-';
                    $nestedData['created_by'] = $item->user->name ?? '-';
                    if ($item->status == 1) {
                        $nestedData['status'] = '<span class="badge badge-warning p-1">Panding</span>';
                    } else {
                        $nestedData['status'] = '<span class="badge badge-success p-1">Complate</span>';
                    }
                    $nestedData['action'] = (string)View::make('backend.issue.action', ['item' => $item])->render();
                    $data[$key] = $nestedData;
                }
            }

            $json_data = [
                'draw' => $request->query('draw'),
                'recordsTotal' => count($data),
                'recordsFiltered' => $totalFiltered,
                'data' => $data
            ];
            return response()->json($json_data);
        }
        return view('backend.issue.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assigneds = User::type(1)->where('status', 1)->get();
        $createds = User::type(2)->where('status', 1)->get();
        return view('backend.issue.create', compact('assigneds', 'createds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'assigned_to' => 'required',
            'created_by' => 'required',
            'description' => 'required',
            'status' => 'required|numeric',
        ]);
        try {
            $create = new Issue();
            $create->title = $request->title;
            $create->assigned_to = $request->assigned_to;
            $create->created_by = $request->created_by;
            $create->description = $request->description;
            $create->status = $request->status;
            $create->save();

            return redirect()->route('issue.index')->with('success', 'Item(s) created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $issue = Issue::find($id);
        return view('backend.issue.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = Issue::find($id);
        $assigneds = User::type(1)->where('status', 1)->get();
        $createds = User::type(2)->where('status', 1)->get();
        return view('backend.issue.update', compact('issue', 'assigneds', 'createds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'assigned_to' => 'required',
            'created_by' => 'required',
            'description' => 'required',
            'status' => 'required|numeric',
        ]);
        try {
            $update = Issue::findOrFail($id);
            $update->title = $request->title;
            $update->assigned_to = $request->assigned_to;
            $update->created_by = $request->created_by;
            $update->description = $request->description;
            $update->status = $request->status;
            $update->save();

            return redirect()->route('issue.index')->with('success', 'Item(s) updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Issue::find($id)->delete();
        return redirect()->back()->with('success', 'Item(s) deleted successfully.');
    }
}
