<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class studentController extends Controller
{
    public  function index(){
        $students = Student::all();
        $data = [
            'students' => $students,
            'status' => 200
        ];

        return $data;

    }
    public function store(Request $request ){

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'email'=>'required|email|unique:student',
            'phone'=>'required|digits:10',
            'lenguaje'=>'required'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400   
            ];
            
            return response()->json($data, 400);
        };

        $student = Student::create([

            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'lenguaje'=>$request->lenguaje
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500 
            ];

            return response()->json($data, 500);

        }

        $data = [
            'message' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);

    }
    public function show($id){

        $student = Student::find($id);

        if (!$student) {
            
            $data = [
                'message' => 'estudiante no encontrado',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => $student,
            'status' => '404'
        ];
        return response()->json($data, 200);
// 
    }

    public function destroy($id){

        $student = Student::find($id);

        if (!$student) {
            
            $data = [
                'message' => 'estudiante no encontrado',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message'=>'Eliminado con exito',
            'status' => 200

        ];
        return response()->json($data, 200);

    } 
    public function update(Request $request, $id){
        $student = Student::find($id);

        if (!$student) {
            
            $data = [
                'message' => 'estudiante no encontrado',
                'status' => '404'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),
        [
            'name'=>'required|max:255',
            'email'=>'required|email|unique:student',
            'phone'=>'required|digits:10',
            'lenguaje'=>'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400   
            ];
            
            return response()->json($data, 400);
        };

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->lenguaje = $request->lenguaje;


        $student->save();

        $data = [
            'message' => 'Estudiante actualizado con exito',
            'status' => '200'
        ];
        return response()->json($data, 200);
    }
    public function updatepartial(Request $request, $id){

        $student = Student::find($id);

        $validator = Validator::make($request->all(),[
            'name'=>'max:255',
            'email'=>'email|unique:student',
            'phone'=>'digits:10'
            
        ]);
        if ($validator->fails()) {

            $data = [
                'message' => 'error en la validacion',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        if ($request->has('name')) {
            $student->name = $request->name;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
            # code...
        }
        if ($request->has('phone')) {
            $student->phone = $request->phone;
            # code...
        }
        if ($request->has('lenguaje')) {
            $student->lenguaje = $request->lenguaje;
            # code...
        }

        $student->save();

        $data = [
            'message' => 'acualizado con exito',
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data,200);
        


    }
}
