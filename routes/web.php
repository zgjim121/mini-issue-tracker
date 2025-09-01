<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('projects.index');
});


Route::resource('projects', ProjectController::class);
Route::resource('issues', IssueController::class);
Route::resource('tags', TagController::class)->only(['index', 'show']);

//AJAX routes for issue tags
Route::post('issues/{issue}/tags', [IssueController::class, 'store'])->name('issues.tags.store');
Route::delete('issues/{issue}/tags/{tag}', [IssueTagController::class, 'destroy'])->name('issues.tags.destroy');

//AJAX Routes for comments
Route::get('issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments.index');
Route::post('issues/{issue}/comments', [CommentController::class, 'store'])->name('issues.comments.store');