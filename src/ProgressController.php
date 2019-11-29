<?php

namespace Imtigger\LaravelJobStatus;

use Illuminate\Routing\Controller as BaseController;
use Imtigger\LaravelJobStatus\JobStatus;
use Illuminate\Support\Facades\Storage;

class ProgressController extends BaseController
{
    function progress($id) {
        $status = JobStatus::findOrFail($id);

        return view('laravel-job-status::progress', [
            'status' => $status
        ]);
    }

    function download($id) {
        $status = JobStatus::findOrFail($id);

        if (!Storage::exists($status->output['filename'])) {
            abort(404);
        }

        return Storage::download($status->output['filename']);
    }
    
    function view($id) {
        $status = JobStatus::findOrFail($id);

        if (!Storage::exists($status->output['filename'])) {
            abort(404);
        }

        return Storage::get($status->output['filename']);
    }
    
    /**
     * @param $as
     *
     * Shortcut for creating group of named route
     */
    public static function routes($as = 'progress') {
        \Route::get("progress/{id}", ['as' => "{$as}", 'uses' => "\\" . static::class . "@progress"]);
        \Route::get("progress/{id}/download", ['as' => "{$as}.download", 'uses' => "\\" . static::class ."@download"]);
        \Route::get("progress/{id}/view", ['as' => "{$as}.print", 'uses' => "\\" . static::class ."@view"]);
    }
}