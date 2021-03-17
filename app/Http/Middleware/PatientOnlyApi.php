<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PatientOnlyApi
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
        $client = new \GuzzleHttp\Client();


        try{
        $res = $client->request('GET', env('USER_API_URL','https://www.merohealthcare.com/api/user/'), [
                     'headers' => [
                         'Authorization'=>'Bearer '.$request->bearerToken()
                    ]
            ]
        );
        }catch(\Exception $e){
            abort(403);
        }


        $statusCode = $res->getStatusCode();
        $responseBody=$res->getBody();
        if($statusCode != 200){
            abort(403);
        }

        $user = json_decode((string)$responseBody);
        if(!$user){
            abort(403);
        }

        $patient = \App\Models\Patient::where('user_id', $user->id)->first();
        if($patient == null) {
            $patient = \App\Models\Patient::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'photo' => $user->photo,
                'contact_email' => $user->email,
                'date_of_birth' => $user->dob,
                'sex' => $user->gender,
                'cell_phone' => $user->phone,
                'city' => $user->city,
                'address' => $user->address,
            ]);
        }
        $user = $patient->user;
        $request->merge(['user' => $user ]);
        //add this
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}

