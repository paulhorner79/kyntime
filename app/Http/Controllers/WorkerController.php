<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\Worker;

class WorkerController extends Controller
{
    public function worker($job)
    {
        if ($worker = Worker::job($job)) {
            $msg = $worker->run();
            return response()->json(['info' => $msg]);
        }
        return response()->json([], 404);
    }
}
