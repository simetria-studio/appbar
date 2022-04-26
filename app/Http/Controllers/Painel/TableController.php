<?php

namespace App\Http\Controllers\Painel;

use App\Models\Unity;
use App\Models\Table;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $unities = Unity::all();
        $tables = Table::with('unity')->orderBy('unity_id')->get();
        return view('painel.tables.index', compact('unities', 'tables'));
    }

    public function store(Request $request)
    {
        $table = Table::create([
            'name' => $request->name,
            'unity_id' => $request->unity_id,
        ]);

        $code = 'UN'.str_pad($request->unity_id, 2, '0', STR_PAD_LEFT).'MS'.str_pad($table->id, 2, '0', STR_PAD_LEFT);

        Table::find($table->id)->update(['code' => $code]);

        return redirect()->route('table')->with('success', 'Mesa cadastrada com successo!');
    }

    public function edit($id)
    {
        $unities = Unity::all();
        $table = Table::with('unity')->find($id);
        return view('painel.tables.editTable', compact('unities', 'table'));
    }

    public function update(Request $request, $id)
    {
        $table = Table::find($id);
        $code = 'UN'.str_pad($request->unity_id, 2, '0', STR_PAD_LEFT).'MS'.str_pad($id, 2, '0', STR_PAD_LEFT);
        $table->update([
            'name' => $request->name,
            'code' => $code,
            'unity_id' => $request->unity_id,
        ]);

        return redirect()->route('table')->with('success', 'Mesa alterado com successo!');
    }

    public function destroy($id)
    {
        Table::find($id)->delete();
        return response()->json(['success' => true]);
    }

    // Unidade
    public function storeUnity(Request $request)
    {
        Unity::create([
            'name' => $request->name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number' => $request->number,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect()->route('table')->with('success', 'Unidade cadastrada com successo!');
    }

    public function editUnity($id)
    {
        $unity = Unity::find($id);
        return view('painel.tables.editUnity', compact('unity'));
    }

    public function updateUnity(Request $request, $id)
    {
        $unity = Unity::find($id);
        $unity->update([
            'name' => $request->name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number' => $request->number,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect()->route('table')->with('success', 'Unidade alterada com successo!');
    }

    public function destroyUnity($id)
    {
        Unity::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
