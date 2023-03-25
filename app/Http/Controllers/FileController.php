<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
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
        $file = $request->file('file');
        $path = $file->store('temp');
        $file_content = file_get_contents(storage_path("app/$path"));
        $lines = explode(PHP_EOL, $file_content);
        $matched = false;
        $count = 0;
        foreach ($lines as $line) {
            $pattern = '/^(\S+) (\S+) (\S+) \[(.+)\] "(\S+) (\S+) (\S+)" (\S+) (\S+) "(.*?)" "(.*?)" "(.*?)"/';
            preg_match($pattern, $line, $matches);
            if ($matches) {
                $log = new Log();
                $log->remote_host = $matches[1];
                $log->remote_log = $matches[2];
                $log->remote_user = $matches[3];
                $log->time_stamp = date('Y-m-d H:i:s', strtotime($matches[4]));
                $log->http_method = $matches[5];
                $log->url_path = $matches[6];
                $log->protocol_version = $matches[7];
                $log->http_status_code = $matches[8];
                $log->bytes_sent = $matches[9];
                $log->referer_url = $matches[10];
                $log->user_agent = $matches[11];
                $log->forwarded_info = $matches[12];
                $log->save();
                $matched = true;
                $count++;
            } else {
                continue;
            }
        }
        if (!$matched) {
            return redirect()->back()->with('message', 'no match found in your log file!');
        }
        Storage::delete($path);
        return redirect()->route('logs')->with('message', "$count logs saved successfully!");
    }
    public function showAllLogs(Request $request)
    {
        if ($request->ajax()) {
            $logs = Log::query();
            return DataTables::of($logs)->make(true);
        }
        return view('logs');
    }
}
