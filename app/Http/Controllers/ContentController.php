<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;


class ContentController extends Controller
{
    public function reportContent(Request $request)
    {
        $content_id = $request->input('content_id');
        dd($request);
        $this->authorize('report');

        $user = auth()->user();
        if(Report::where('user_id', $user->id)->where('content_id', $content_id)->exists()){
            Report::where('user_id', $user->id)->where('content_id', $content_id)->delete();
        }
        else{
            $report = new Report([
                'user_id' => $user->id,
                'content_id' => $content_id
            ]);

            $report->save();
        }

        return redirect()->back();
    }
}
