<?php

namespace App\Http\Middleware;

use App\Models\VideoCall;
use Closure;
use Session;
use Auth;

class CheckActiveVideo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('extra_user')->check()){
            $videoCall = VideoCall::where('patient_id',auth('extra_user')->user()->patient->id)->where('status',1)->first();
            if($videoCall)
            {
                Session::flash('video_call_status',$videoCall->room_id);
                return $next($request);
            }
            else{
                Session::forget('video_call_status');
            }
        }
       
        return $next($request);
    }
}
