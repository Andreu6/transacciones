<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Teacher;

class TeacherController extends Controller
{
    public function registerTeacher(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {

            DB::beginTransaction();
            $request->validate([
                'nombre' => 'required',
                'apellido' => 'required',
                'dni' => 'required'
            ]);
            $Teacher = new Teacher();
            $Teacher->nombre = $request->nombre;
            $Teacher->apellido = $request->apellido;
            $Teacher->dni = $request->dni;
            $Teacher->save();

            DB::commit();
            return response()->json([
                "status" => 1,
                "msg" => "¡Teacher insertado con exito!",
            ]);
        }

        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }

    public function updateTeacher(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 4) {
            DB::beginTransaction();
            $request->validate(['id' => 'required', 'nombre' => 'required', 'apellido' => 'required', 'dni' => 'required']);

            DB::update(
                'update teachers set nombre = ?, apellido = ?, dni = ? WHERE id = ?',
                [$request->nombre, $request->apellido, $request->dni, $request->id]
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

    public function deleteTeacher(Request $request)
    {

        if (auth()->user()->role == 1 || auth()->user()->role == 4) {
            DB::beginTransaction();
            $request->validate([
                'id' => 'required'
            ]);

            $res = Teacher::find($request)->each->delete();
            if ($res) {
                $data = [
                    'status' => '1',
                    'msg' => 'Se ha borrado el Teacher'
                ];
            } else {
                $data = [
                    'status' => '0',
                    'msg' => 'No se ha borrado el Teacher'
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

    public function readTeacher(Request $request)
    {
        if (auth()->user()->role == 1) {
            DB::beginTransaction();
            $posts = Teacher::all();

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
