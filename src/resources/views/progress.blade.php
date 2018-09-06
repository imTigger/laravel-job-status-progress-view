<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>{{ trans("laravel-job-status::progress.title", ['name' => trans($status->type)]) }}</title>
  </head>
  <body>
    <main role="main" class="container">
        <h1 class="mt-5">{{ trans("laravel-job-status::progress.title", ['name' => trans($status->type)]) }}</h1>
        @if ($status->status == 'queued')
            <div class="alert alert-info">
                {{ trans("laravel-job-status::progress.submitted", ['name' => trans($status->type)]) }}
            </div>
        @elseif ($status->status == 'executing')
            <div class="alert alert-info">
                {{ trans("laravel-job-status::progress.processing", ['name' => trans($status->type)]) }}
            </div>
        @elseif ($status->status == 'finished')
            @if (isset($status->output['success_rows']))
                @if ($status->output['failed_rows'] == 0)
                    <div class="alert alert-success">
                        <p>{{ trans("laravel-job-status::progress.finished", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @elseif ($status->output['success_rows'] == 0)
                    <div class="alert alert-danger">
                        <p>{{ trans("laravel-job-status::progress.all_failed", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <p>{{ trans("laravel-job-status::progress.partially_finished", ['name' => trans($status->type)]) }}</p>
                        <p>{{ sprintf(trans("laravel-job-status::progress.result_numbers"), $status->output['total_rows'], $status->output['success_rows'], $status->output['skipped_rows'], $status->output['failed_rows']) }}</p>
                    </div>
                @endif
            @else
                <div class="alert alert-success">
                    <p>{{ trans("laravel-job-status::progress.finished", ['name' => trans($status->type)]) }}</p>
                </div>
            @endif
        @elseif ($status->status == 'failed')
            <div class="alert alert-danger">
                {{ $status->output['message'] }}
            </div>
        @endif

        @if (!empty($status->output['errors']))
            <p><textarea class="form-control bg-danger" rows="10">{!! implode(PHP_EOL, $status->output['errors']) !!}</textarea></p>
        @endif

        <div class="progress">
            <div class="progress-bar {{ $status->isEnded ?: 'progress-bar-striped progress-bar-animated' }}" role="progressbar" style="width: {{ $status->progress_percentage }}%;">
                <span>{{ $status->progress_now }} / {{ $status->progress_max }}</span>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        @if (!$status->isEnded)
            <script>
                setTimeout(function () {
                    document.location.href = document.location;
                }, 3000);
            </script>
        @else
            @if (isset($status->output['filename']))
            <script>
                document.location.href = '{{ action("\Imtigger\LaravelJobStatus\ProgressController@download", [$status->id]) }}';
            </script>
            @endif
        @endif
    </main>
  </body>
</html>