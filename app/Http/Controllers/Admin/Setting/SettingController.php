<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Core\BaseController;
use App\Models\Setting\Setting;
use App\Traits\FlashMessages;
use App\Traits\Uploadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingController extends BaseController
{
    use Uploadable,FlashMessages;

    protected $settings = [];

    public function index()
    {
        try {
            $this->setPageTitle('Settings','Manage Settings Information');

            return view('admin.settings.index');
        } catch (\Exception $e) {
            return $this->responseRedirectBack($e->getMessage(),"error");
        }

    }

    public function update(Request $request)
    {
        try {

            if($request->hasFile('image')){

                $files = $request->file('image');

                foreach ($files as $key => $file) {

                    if(config('settings.'.$key)){
                        $this->deleteOne(config('settings.'.$key));
                    }

                    $filePath = $this->uploadOne($file,$key);

                    Setting::set($key,$filePath);
                }
            }
            else{
                $siteInformation = $request->except('_token');

                foreach ($siteInformation as $siteKey => $siteValue) {
                    Setting::set($siteKey,$siteValue);
                }
            }

            return $this->responseRedirectBack("Settings updated successfully.","success");

        } catch (\Exception $e) {
            return $this->responseRedirectBack($e->getMessage(),"error");
        }
    }
}
