<?php
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\RoutineController;
use App\Http\Controllers\Api\RoutineExerciseController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\StripePaymentController;
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

Route::get('user', [TokenController::class, 'user'])->middleware('auth:sanctum');
Route::post('logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');
Route::post('login', [TokenController::class, 'login']);
Route::post('register', [TokenController::class, 'register']);

Route::apiResource('exercises', ExerciseController::class);
Route::post('exercises/{exercise}', [ExerciseController::class, 'update_workaround']);

Route::apiResource('routines', RoutineController::class);
Route::post('routines/{routine}', [RoutineController::class, 'update_workaround']);

Route::apiResource('routine_exercises', RoutineExerciseController::class);
Route::post('routine_exercises/{routine_exercise}', [RoutineExerciseController::class, 'update_workaround']);

Route::apiResource('ingredients', IngredientController::class);
Route::post('ingredients/{ingredient}', [IngredientController::class, 'update_workaround']);

Route::apiResource('recipes', RecipeController::class);
Route::post('recipes/{recipe}', [RecipeController::class, 'update_workaround']);

Route::post('stripe', [StripePaymentController::class, 'stripePost']);