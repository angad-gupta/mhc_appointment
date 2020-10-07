<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAppRequest;
use App\Http\Requests\SaveMailRequest;
use App\Mail\TestMail;
use App\Traits\Installer;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Image;

class AppSetupController extends Controller
{
    use Installer;

    /**
     * Show app setting page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $langs = array_map('basename', File::directories(resource_path('lang')));

        return view('operations.app-setting.app-setting', compact('langs'));
    }

    /**
     * Save mail details
     *
     * @param SaveMailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function saveMail(SaveMailRequest $request)
    {
        $this->setConfigMail($request);
        try {
            Mail::to('kmrifat@gmail.com')->send(new TestMail());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
        $this->changeEnvValueMail($request);

        return redirect()->back()->with('success', 'Mail setting has been modified successfully');
    }

    /**
     * Save app details
     *
     * @param SaveAppRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Brotzka\DotenvEditor\Exceptions\DotEnvException
     */
    public function saveApp(SaveAppRequest $request)
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
            $banner_img = Image::make($request->file('banner'));
            $banner_img->save(public_path('/uploads/website/banner.png'), 80);
        }

        return redirect()->back()->with('success', 'App setting has been modified successfully');
    }

    /**
     * Config server cache
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function configCache(Request $request)
    {
        try {
            Artisan::call('config:cache');
            return view('operations.app-setting.config-cache');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

}
