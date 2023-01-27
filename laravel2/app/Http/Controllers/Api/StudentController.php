<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;




class StudentController extends Controller
{
    public function registerStudent(Request $request)
    {

        if (auth()->user()->role == 1) {
            DB::beginTransaction();
            $request->validate([
                'nombre' => 'required',
                'apellido' => 'required',
                'dni' => 'required',
                'curso' => 'required'
            ]);

            $Student = new Student();
            $Student->nombre = $request->nombre;
            $Student->apellido = $request->apellido;
            $Student->dni = $request->dni;
            $Student->curso = $request->curso;
            $Student->save();
            DB::commit();
            return response()->json([
                "status" => 1,
                "msg" => "¡Student insertado con exito!",
            ]);
        }
        DB::rollBack();
        return response()->json([
            "status" => 1,
            "msg" => "¡No tiene permisos para realizar la siguiente operación!",
        ]);
    }

    public function updateStudent(Request $request)
    {

        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            DB::beginTransaction();
            $request->validate(['id' => 'required', 'nombre' => 'required', 'apellido' => 'required', 'dni' => 'required', 'curso' => 'required']);

            DB::update(
                'update students set nombre = ?, apellido = ?, dni = ?, curso = ? WHERE id = ?',
                [$request->nombre, $request->apellido, $request->dni, $request->curso, $request->id]
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

    public function deleteStudent(Request $request)
    {
        if (auth()->user()->role == 1) {
            DB::beginTransaction();
            $request->validate([
                'id' => 'required'
            ]);

            $res = Student::find($request)->each->delete();
            if ($res) {
                $data = [
                    'status' => '1',
                    'msg' => 'Se ha borrado el student'
                ];
            } else {
                $data = [
                    'status' => '0',
                    'msg' => 'No se ha borrado el student'
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

    public function readStudent(Request $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {
            DB::beginTransaction();
            $posts = Student::all();
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
