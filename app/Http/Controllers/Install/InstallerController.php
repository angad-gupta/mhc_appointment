<?php

namespace App\Http\Controllers\Install;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\SaveAppRequest;
use App\Http\Requests\SaveMySQLRequest;
use App\Mail\TestMail;
use App\Models\Admin;
use App\Traits\Installer;
use App\User;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Image;

class InstallerController
{

    use Installer;

    /**
     * Will show installation began page with all required module
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('installer.welcome');
    }

    /**
     * Will show database setup page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function database()
    {
        return view('installer.database');
    }

    /**
     * Save database variable and migrate database
     *
     * @param SaveMySQLRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDatabase(SaveMySQLRequest $request)
    {
        
        $this->setConfigDB($request);
        try {
            
            DB::connection()->getPdo();
            
             Artisan::call('migrate', ['--force' => true]);
            
            $this->changeEnvValuesForDB($request);
            return redirect()->route('install.mail');
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->with('db_error', $exception->getMessage());
        }
    }

    /**
     * Show app personalization where user can change timezone, app name and many more.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function personalization()
    {
        $langs = array_map('basename', File::directories(resource_path('lang')));
        return view('installer.personalization', compact('langs'));
    }

    /**
     * Update app personalization environment variable
     *
     * @param SaveAppRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function postPersonalization(SaveAppRequest $request)
    {
        $this->savePersonalization($request);

        if ($request->hasFile('logo')) {
            $img = Image::make($request->logo);
            $img->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path('/web/icons/') . 'icon' . '.' . $request->logo->extension());
            $img->save(public_path('/') . 'icon.ico');
        }

        if ($request->hasFile('banner')) {
            $img = Image::make($request->banner);
            $img->save(public_path('/uploads/website/') . 'banner.png');
        }

        return redirect()->route('install.database');
    }

    /**
     * Show mail setup page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mail()
    {
        return view('installer.mail');
    }

    /**
     * Storage email env variable if given details are true
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postMail(Request $request)
    {
        $this->setConfigMail($request);
        try {
            Mail::to('kmrifat@gmail.com')->send(new TestMail());
            $this->changeEnvValueMail($request);
//            Artisan::call('config:cache');
            return redirect()->route('install.admin');
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->with('mail_error', $exception->getMessage());
        }
    }

    /**
     * Skip mail setup
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function skippingMail(Request $request)
    {
//        Artisan::call('config:cache');
        return redirect()->route('install.admin')->with('success', 'All Set');
    }

    /**
     * Show admin setup
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin()
    {
        return view('installer.super-admin');
    }

    /**
     * Save store
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function storeAdmin(AdminRequest $request)
    {
        $this->setDBConfigFromEnv();

        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->role = 1;
        if ($user->save()) {
            $admin = new Admin();
            $admin->fill($request->all());
            $admin->user_id = $user->id;
            $admin->save();
        }
        $this->setStatusToInstallDone();
        return redirect()->route('install.done');
    }

    /**
     * Show install done
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installDone()
    {
        return view('installer.done');
    }

    /**
     * Cache config and redirect
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveInstallDone(Request $request)
    {
        Artisan::call('config:cache');
        return redirect()->to('/');
    }

}
