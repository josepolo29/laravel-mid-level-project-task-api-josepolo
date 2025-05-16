<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Tareas",
 *     description="Operaciones CRUD para tareas"
 * )
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Listar tareas con filtros",
     *     tags={"Tareas"},
     *     @OA\Parameter(name="status", in="query", @OA\Schema(type="string"), description="Estado de la tarea"),
     *     @OA\Parameter(name="priority", in="query", @OA\Schema(type="string"), description="Prioridad de la tarea"),
     *     @OA\Parameter(name="due_date", in="query", @OA\Schema(type="string", format="date"), description="Fecha límite"),
     *     @OA\Parameter(name="project_id", in="query", @OA\Schema(type="string", format="uuid"), description="ID del proyecto"),
     *     @OA\Response(response=200, description="Listado de tareas")
     * )
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if($request->has('status')) $query->where('status', $request->status);
        if($request->has('priority')) $query->where('priority', $request->priority);
        if($request->has('due_date')) $query->where('due_date', $request->due_date);
        if($request->has('project_id')) $query->where('project_id', $request->project_id);

        return response()->json($query->latest()->paginate());
    }

     /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Crear una nueva tarea",
     *     tags={"Tareas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"project_id", "title", "status", "priority", "due_date"},
     *             @OA\Property(property="project_id", type="string", format="uuid"),
     *             @OA\Property(property="title", type="string", example="Tarea A"),
     *             @OA\Property(property="description", type="string", example="Descripción opcional"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="priority", type="string", example="medium"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-06-01")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Tarea creada exitosamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return response()->json([
            'message' => 'Se guardó con éxito!',
            'data' => $task
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Obtener detalle de una tarea",
     *     tags={"Tareas"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Detalle de la tarea"),
     *     @OA\Response(response=404, description="Tarea no encontrada")
     * )
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Actualizar una tarea",
     *     tags={"Tareas"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"project_id", "title", "status", "priority", "due_date"},
     *             @OA\Property(property="project_id", type="string", format="uuid"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="priority", type="string"),
     *             @OA\Property(property="due_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Tarea actualizada"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json([
            'message' => 'Se actualizó con éxito!',
            'data' => $task
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Eliminar una tarea",
     *     tags={"Tareas"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Tarea eliminada exitosamente"),
     *     @OA\Response(response=404, description="Tarea no encontrada")
     * )
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Se eliminó con éxito!']);
    }
}
