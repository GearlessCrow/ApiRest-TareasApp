<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\Validator;

class tareasController extends Controller
{
    public function index()
    {
        $tareas = Tareas::all();
        //if($tareas->isEmpty()){
        //    $data = [
        //        'message' => 'No hay tareas registradas'
        //        'status' => 200
        //    ]
        //    return response()->json($data, 404)
        //}
        return response()->json($tareas, 200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:100',
            'descripcion' => 'required|max:255',
            'estado' =>'required|in:pendiente,progreso,completado'
        ]);
         if($validator->fails()){
             $data = [
                'message' => 'Error en la validacion de los datos',
                 'status' => 400
             ];
         }
        $tareas = Tareas::create([
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'estado'=>$request->estado
        ]);

        if(!$tareas){
            $data = [
                'message'=>'Error al crear una tarea',
                'status'=>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'tareas' => $tareas,
            'status' =>201
        ];
        return response()->json($data, 201);


    }
    public function show($id){
        $tareas = Tareas::find($id);
        if(!$tareas){
            $data=[
                'message'=>'tarea no encontrada',
                'status'=>'404'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'tarea' => $tareas,
            'status'=>200
        ];
        return response()->json($data,200);
    }

    public function destroy($id){
        $tareas = Tareas::find($id);
        if(!$tareas){
            $data=[
                'message'=>'Estudiante no eliminado',
                'status'=>'404'
            ];
            return response()->json($data, 404);
        }
        $tareas->delete();
        $data = [
            'message'=> 'Estudiante Eliminado',
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request,$id){
        $tareas = Tareas::find($id);
        if(!$tareas){
            $data=[
                'message'=>'tarea no encontrada',
                'status'=>'404'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'requerid|max:100',
            'descripcion' => 'requerid|max:255',
            'estado' =>'requerid|in:pendiente,progreso,completado'
        ]);

        $tareas->titulo=$request->titulo;
        $tareas->descripcion=$request->descripcion;
        $tareas->estado=$request->estado;

        $tareas->save();

        $data = [
            'message'=>'tarea actualiazada',
            'tareas'=> $tareas,
            'status'=>200
        ];
        return response()->json($data,200);


    }

    public function updateParcial(Request $request, $id){
        $tareas = Tareas::find($id);
        if(!$tareas){
            $data=[
                'message'=>'tarea no encontrada',
                'status'=>'404'
            ];
            return response()->json($data, 404);
        }
        return response()->json($request->all(),200);

        $validator=Validator::make($request->all(),[
            'titulo' => 'requerid|max:100',
            'descripcion' => 'requerid|max:255',
            'estado' =>'requerid|in:pendiente,progreso,completado'
        ]);
        if($validator->fails()){
            $data = [
               'message' => 'Error en la validacion de los datos',
                'status' => 400
            ];
        }
        if ($request->has('titulo')){
            $tareas->titulo=$request->titulo;
        }
        if ($request->has('descripcion')){
            $tareas->descripcion=$request->descripcion;
        }
        if ($request->has('estado')){
            $tareas->estado=$request->estado;
        }
        $tareas->save();

        $data =[
            'message'=>'tarea actualizada',
            'tarea'=>$tareas,
            'status'=>200
        ];
        return response()->json($data,200);

    }


}
