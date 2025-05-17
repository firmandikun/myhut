<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\OperationCategory;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index()
    {
        $operations = Operation::with('category')->get();
        return view('operations.index', compact('operations'));
    }

    public function create()
    {
        $categories = OperationCategory::all();
        return view('operations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'  => 'required|string|max:255',
            'cost'         => 'required|numeric|min:0',
            'category_id'  => 'required|exists:operation_categories,id',
            'date'         => 'required|date',
        ]);

        Operation::create($validated);

        return redirect()->route('operations.index')->with('success', 'Operational data added successfully!');
    }


    public function show($id)
    {
        $category = OperationCategory::findOrFail($id);
        return view('operations.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $operation = Operation::findOrFail($id);
        $categories = OperationCategory::all();
        return view('operations.edit', compact('operation', 'categories'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'description'  => 'required|string|max:255',
        'cost'         => 'required|numeric|min:0',
        'category_id'  => 'required|exists:operation_categories,id',
        'date'         => 'required|date',
    ]);

    $operation = Operation::findOrFail($id);
    $operation->update($validated);

    return redirect()->route('operations.index')->with('success', 'Operational data updated successfully!');
}


    public function destroy($id)
    {
        $operation = Operation::findOrFail($id);
        $operation->delete();

        return redirect()->route('operations.index')->with('success', 'Operational data deleted successfully!');
    }
}
