# Laravel Job Status Progress View

Progress View page for Laravel Job Status

*** Testing phase only! Currently tightly coupled with my own theme ***

## Requirements

- PHP >= 5.6.4
- Laravel >= 5.3
- `laravel-job-status` >= 0.1.14

## Installation

This plugin can only be installed from [Composer](https://getcomposer.org/).

Run the following command:
```
composer require imtigger/laravel-job-status-progress-view
```

#### 1. Add Service Provider (Laravel < 5.5)

Add the following to your `config/app.php`:

```php
'providers' => [
    ...
    Imtigger\LaravelJobStatus\LaravelJobStatusServiceProgressViewProvider::class,
]
```

### Usage

In your `routes.php`, add this route helper:

```php
    ...
    \Imtigger\LaravelJobStatus\ProgressController::routes('admin.progress');
```

In your controller, redirect to this route

```php
    $this->dispatch($job);
    return redirect()->route("admin.progress", [$job->getJobStatusId()]);
```

In your job, write the following fields to outputs

| Field      | type     | Description |
| ---------- | -------- | ----------- |
total_rows   | Integer  | Optional, If present show detailed results upon finished
success_rows | Integer  | Optional, Ditto
skipped_rows | Integer  | Optional, Ditto
failed_rows  | Integer  | Optional, Ditto
errors       | Array of String | Optional, Usually for non-fatal exception message
message      | String          | Optional, Usually for fatal exception message
filename     | String          | Optional, Path relative to `storage` folder. If present, redirect to download that file upon finished

