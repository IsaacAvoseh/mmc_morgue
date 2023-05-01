<?php

namespace App\Traits;
use Illuminate\Http\Request;

trait CrudTrait
{
    // protected $model;
    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
        return response()->json(['message' => 'Deleted successfully Testing']);
    }

    

    public function insert(Request $request)
    {
        $model = $this->model->create($request->all());
        return response()->json(['message' => 'Inserted successfully', 'data' => $model]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($request->all());
        return response()->json(['message' => 'Updated successfully', 'data' => $model]);
    }
}
