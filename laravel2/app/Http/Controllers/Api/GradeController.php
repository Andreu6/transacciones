<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Grade;

class GradeController extends Controller
{
    public function registerGrade(Request $request)
    {

        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            DB::beginTransaction();
            $request->validate([
                'nombre_curso' => 'required',
                'id_teacher' => 'required',
            ]);

            $Grade = new Grade();
            $Grade->nombre_curso = $request->nombre_curso;
            $Grade->id_teacher = $request->id_teacher;
            $Grade->save();
            DB::commit();
            return response()->json([
                "status" => 1,
                "msg" => "¡Curso insertado con exito!",
            ]);
        }
        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }

    public function updateGrade(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            DB::beginTransaction();
            $request->validate(['id' => 'required', 'nombre_curso' => 'required', 'id_teacher' => 'required']);

            DB::update(
                'update grade set nombre_curso = ?, id_teacher = ? WHERE id = ?',
                [$request->nombre_curso, $request->id_teacher, $request->id]
            );
            DB::commit();
            return response()->json([
                "status" => 1,
                "msg" => "Update Exitoso"
            ]);
        }
        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }

    public function deleteGrade(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 3) {
            DB::beginTransaction();
            $request->validate([
                'id' => 'required'
            ]);

            $res = Grade::find($request)->each->delete();
            if ($res) {
                $data = [
                    'status' => '1',
                    'msg' => 'Se ha borrado el curso'
                ];
            } else {
                $data = [
                    'status' => '0',
                    'msg' => 'No se ha borrado el curso'
                ];
            }
            DB::commit();
            return response()->json($data);
        }
        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }

    public function readGrade(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {
            DB::beginTransaction();
            $posts = Grade::all();
            DB::commit();
            return response()->json($posts);
        }
        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }
}
