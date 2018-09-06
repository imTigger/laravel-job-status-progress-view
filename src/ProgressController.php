<?php

namespace Imtigger\LaravelJobStatus;

use Illuminate\Routing\Controller as BaseController;
use Imtigger\LaravelJobStatus\JobStatus;

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

        if (!is_file(storage_path($status->output['filename']))) {
            abort(404);
        }

        return response()->download(storage_path($status->output['filename']));
    }
    
    function view($id) {
        $status = JobStatus::findOrFail($id);

        if (!is_file(storage_path($status->output['filename']))) {
            abort(404);
        }

        return response()->file(storage_path($status->output['filename']));
    }
    
    /**
     * @param $as
     *
     * Shortcut for creating group of named route
     */
    public static function routes($as = 'progress') {
        \Route::get("progress/{id}", ['as' => "{$as}", 'uses' => "\\" . self::class . "@progress"]);
        \Route::get("progress/{id}/download", ['as' => "{$as}.download", 'uses' => "\\" . self::class ."@download"]);
        \Route::get("progress/{id}/view", ['as' => "{$as}.print", 'uses' => "\\" . self::class ."@view"]);
    }
}