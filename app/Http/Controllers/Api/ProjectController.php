<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *  name="Proyectos",
 *  description="API RESTFul de Proyectos"
 * )
 */
class ProjectController extends Controller
{
    

     /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Listar proyectos",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar por estado (active, inactive)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nombre parcial",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="from_date",
     *         in="query",
     *         description="Fecha inicial de creación (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="to_date",
     *         in="query",
     *         description="Fecha final de creación (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de proyectos"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Project::query();

        if($request->has('status')) $query->where('status', 'like', $request->status);
        if($request->has('name')) $query->where('name', 'like', '%' . $request->name . '%');
        if($request->has(['from_date', 'to_date'])) $query->whereBetween('created_at', [$request->from_date, $request->to_date]);

        return response()->json($query->paginate());
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Crear nuevo proyecto",
     *     tags={"Proyectos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string", example="Proyecto Nuevo"),
     *             @OA\Property(property="description", type="string", example="Descripción opcional"),
     *             @OA\Property(property="status", type="string", example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Proyecto creado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return response()->json([
            'message' => 'Se guardó con éxito!', 
            'data' => $project]
        , 201);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Mostrar detalle de proyecto",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto (UUID)",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalle del proyecto"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     )
     * )
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Actualizar proyecto",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto (UUID)",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "status"},
     *             @OA\Property(property="name", type="string", example="Proyecto Actualizado"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada"),
     *             @OA\Property(property="status", type="string", example="inactive")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto actualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     )
     * )
     */
    public function update(Request $request, Project $project)
    {
        $project->update($request->validate());
        return response()->json([
            'message' => 'Se actualizó con éxito!', 
            'data' => $project
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Eliminar proyecto",
     *     tags={"Proyectos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del proyecto (UUID)",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proyecto eliminado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proyecto no encontrado"
     *     )
     * )
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Se eliminó con éxito!']);
    }
}
