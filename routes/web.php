<?php use App\Http\Controllers\ChatController;

Route::get('/', [ChatController::class, 'showStoryForm']);
Route::post('/generate-story', [ChatController::class, 'generateStory']);
