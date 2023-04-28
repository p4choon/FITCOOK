<?php
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\RoutineController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('exercises', ExerciseController::class);
Route::post('exercises/{exercise}', [ExerciseController::class, 'update_workaround']);

Route::apiResource('routines', RoutineController::class);
Route::post('routines/{routine}', [RoutineController::class, 'update_workaround']);

Route::apiResource('ingredients', IngredientController::class);
Route::post('ingredients/{ingredient}', [IngredientController::class, 'update_workaround']);

Route::apiResource('recipes', RecipeController::class);
Route::post('recipes/{recipe}', [RecipeController::class, 'update_workaround']);