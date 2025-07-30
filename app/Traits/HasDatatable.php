<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HasDatatable
{
    public function showData(Request $request, $model, array $relations = [], array $selectFields = [])
    {
        $query = $model->with($relations);

        $searchValue = $request->input('search.value');
        if ($searchValue) {
            $query->where(function ($q) use ($model, $searchValue) {
                foreach ($model->getFillable() as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $searchValue . '%');
                }
            });
        }

        $total = $query->count();

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $query->offset($start)->limit($length);

        $data = $query->get();

        // Filter specific columns if requested
        if (!empty($selectFields)) {
            $data = $data->map(function ($item) use ($selectFields) {
                $filtered = [];
                foreach ($selectFields as $key => $field) {
                    $alias = is_string($key) ? $key : null;

                    $parts = explode('.', $field);
                    $value = $item;
                    foreach ($parts as $part) {
                        $value = $value[$part] ?? null;
                    }

                    $filtered[$alias ?? $field] = $value;
                }
                return $filtered;
            });
        }

        return response()->json([
            'data' => $data->values(),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ]);
    }
}