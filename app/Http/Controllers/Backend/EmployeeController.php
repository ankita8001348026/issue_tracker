<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class EmployeeController extends Controller
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
            $query = User::type(1)->when(is_numeric($request->status), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
                ->when($request->query('search_keyword'), function ($query) use ($request) {
                    return $query->where('name', 'like', '%' . $request->search_keyword . '%');
                })
                ->when($request->query('start_date') && $request->query('end_date'), function ($query) use ($request) {
                    return $query->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                })
                ->orderBy('id', 'desc');
            $totalFiltered = $query->count();
            $items = $query->offset($start)->limit($limit)->get();

            $data = [];
            if (count($items) > 0) {
                foreach ($items as $key => $item) {
                    $nestedData['name'] = $item->name ?? '-';
                    $nestedData['email'] = $item->email ?? '-';
                    $nestedData['mobile'] = $item->mobile ?? '-';
                    if ($item->status == 1) {
                        $nestedData['status'] = '<span class="badge badge-success p-1">Active</span>';
                    } else {
                        $nestedData['status'] = '<span class="badge badge-danger p-1">Inactive</span>';
                    }
                    $nestedData['action'] = (string)View::make('backend.employee.action', ['item' => $item])->render();
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
        return view('backend.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.employee.create');
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|numeric|unique:users,mobile',
            'status' => 'required|numeric',
        ]);
        try {
            $create = new User();
            $create->type = 1;
            $create->name = $request->name;
            $create->mobile = $request->number;
            $create->email = $request->email;
            $create->status = $request->status;
            $create->password = 12345678;
            $create->save();

            return redirect()->route('employee.index')->with('success', 'Item(s) created successfully.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.employee.update', compact('user'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'required|numeric|unique:users,mobile,' . $id,
            'status' => 'required|numeric',
        ]);
        try {
            $update = User::findOrFail($id);
            $update->name = $request->name;
            $update->mobile = $request->number;
            $update->email = $request->email;
            $update->status = $request->status;
            $update->password = 12345678;
            $update->save();

            return redirect()->route('employee.index')->with('success', 'Item(s) updated successfully.');
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
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Item(s) deleted successfully.');
    }
}
