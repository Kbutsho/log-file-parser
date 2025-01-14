<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables as DataTables;

class FileController extends Controller
{
    public function showForm()
    {
        return view('logFileForm');
    }
    public function fileParse(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|file|mimetypes:text/plain'
            ],
            [
                'file.required' => 'log file is required!',
                'file.mimetypes' => 'file must be a (.txt) file!',
            ]
        );
        // $file = $request->file('file');
        // $path = $file->store('temp');
        // $file_content = file_get_contents(storage_path("app/$path"));
        // $lines = explode(PHP_EOL, $file_content);
        // $matched = false;
        // $count = 0;
        // $chunkSize = 1000;
        // $logs = [];
        // // Begin a transaction
        // DB::beginTransaction();
        // try {
        //     // batch insertion
        //     foreach ($lines as $line) {
        //         $pattern = '/^(\S+) (\S+) (\S+) \[(.+)\] "(\S+) (\S+) (\S+)" (\S+) (\S+) "(.*?)" "(.*?)" "(.*?)"/';
        //         preg_match($pattern, $line, $matches);
        //         if ($matches) {
        //             $log = [
        //                 'remote_host' => $matches[1],
        //                 'remote_log' => $matches[2],
        //                 'remote_user' => $matches[3],
        //                 'time_stamp' => date('Y-m-d H:i:s', strtotime($matches[4])),
        //                 'http_method' => $matches[5],
        //                 'url_path' => $matches[6],
        //                 'protocol_version' => $matches[7],
        //                 'http_status_code' => $matches[8],
        //                 'bytes_sent' => $matches[9],
        //                 'referer_url' => $matches[10],
        //                 'user_agent' => $matches[11],
        //                 'forwarded_info' => $matches[12],
        //             ];
        //             $logs[] = $log;
        //             $matched = true;
        //             $count++;
        //             if ($count % $chunkSize == 0) {
        //                 // Batch insertion
        //                 DB::table('logs')->insert($logs);
        //                 $logs = [];
        //             }
        //         } else {
        //             continue;
        //         }
        //     }
        //     // Insert remaining data
        //     if (!empty($logs)) {
        //         DB::table('logs')->insert($logs);
        //     }
        //     DB::commit();
        //     if (!$matched) {
        //         return redirect()->back()
        //             ->with('message', 'no log found in your file!');
        //     }
        //     Storage::delete($path);
        //     return redirect()->route('logs')
        //         ->with('message', "$count logs saved successfully!");
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()
        //         ->with('message', 'an error occurred while saving the logs!');
        // }

        $file = $request->file('file');
        $path = $file->store('temp');
        $file_content = file_get_contents(storage_path("app/$path"));
        $lines = explode(PHP_EOL, $file_content);
        $matched = false;
        $count = 0;
        DB::beginTransaction();
        try {
            $values = "";
            foreach ($lines as $line) {
                $pattern = '/^(\S+) (\S+) (\S+) \[(.+)\] "(\S+) (\S+) (\S+)" (\S+) (\S+) "(.*?)" "(.*?)" "(.*?)"/';
                preg_match($pattern, $line, $matches);
                if ($matches) {
                    $log = [
                        'remote_host' => $matches[1],
                        'remote_log' => $matches[2],
                        'remote_user' => $matches[3],
                        'time_stamp' => date('Y-m-d H:i:s', strtotime($matches[4])),
                        'http_method' => $matches[5],
                        'url_path' => $matches[6],
                        'protocol_version' => $matches[7],
                        'http_status_code' => $matches[8],
                        'bytes_sent' => $matches[9],
                        'referer_url' => $matches[10],
                        'user_agent' => $matches[11],
                        'forwarded_info' => $matches[12],
                    ];
                    $values .= "('" . implode("', '", $log) . "'),";
                    $matched = true;
                    $count++;
                } else {
                    continue;
                }
            }
            $query = "INSERT INTO logs (remote_host, remote_log, remote_user, time_stamp, http_method, url_path, protocol_version, http_status_code, bytes_sent, referer_url, user_agent, forwarded_info) VALUES " . rtrim($values, ", ") . ";";
            DB::statement($query);
            DB::commit();
            if (!$matched) {
                return redirect()->back()
                    ->with('message', 'no log found in your file!');
            }
            Storage::delete($path);
            return redirect()->route('logs')
                ->with('message', "$count logs saved successfully!");
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()
                ->with('message', 'An error occurred while saving the logs.');
        }
    }
    public function showAllLogs(Request $request)
    {
        if ($request->ajax()) {
            $logs = Log::query();
            return DataTables::of($logs)
                ->addColumn('actions', function ($row) {
                    return "<a href='" . route('log.details', $row->id) . "' class='btn btn-sm btn-success px-2 mr-2'><i class='ms-1 fas fa-info-circle'></i> Details</a>
                        <form action='" . route('log.delete', $row->id) . "' method='POST' class='d-inline-block'>
                            " . csrf_field() . "
                            " . method_field('DELETE') . "
                            <button type='submit' class='btn btn-sm btn-danger px-2' onclick='return confirm(\"Are you sure you want to delete this log?\")'>Delete <i class='ms-1  fas fa-trash'></i> </button>
                     </form>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $count = Log::count();
        return view('logs')->with('logs', $count);
    }
    public function deleteAllLogs()
    {
        $count = Log::count();
        if ($count > 0) {
            Log::truncate();
            return redirect()->route('logs')->with('message', 'All logs has been deleted!');
        } else {
            return redirect()->route('logs')->with('message', 'No logs found to delete!');
        }
    }
    public function deleteLogById($id)
    {
        $log = Log::find($id);
        if ($log) {
            $log->delete();
            return redirect()->route('logs')->with('message', 'Log id ' . $id . ' deleted successfully!');
        } else {
            return redirect()->route('logs')->with('message', 'Log record not found!');
        }
    }
    public function detailsLogById($id)
    {
        $log = Log::find($id);
        if ($log) {
            return view('logDetails', ['log' => $log]);
        } else {
            return redirect()->route('logs')->with('message', 'Log record not found!');
        }
    }
}
