<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Traits\FlashMessages;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //used here for laravel flash messages
    use FlashMessages;

    protected $data = null;

    // this method is used to set title and subtitle for the pages

    public function setPageTitle($title,$subTitle)
    {
        view()->share(['pageTitle'=> $title,'subTitle' => $subTitle]);
    }

    /**
     *  this method will help you to display the error pages for example
     *      we founded error message "Not Found" with '404' Error Code
     *          then it will dynamically call error.404 page which will available inside
     *              "error" Folder 404.blade.php file where you can set message and status code
     */

    protected function showErrorPage($errorCode = 404,$message = null)
    {
        $data['message'] = $message;

        return response()->view('errors.'.$errorCode,$data,$errorCode);
    }

    // in case you use ajax or framework you need to return json response.

    protected function responseJson($error = true,$message = [],$errorCode = 404,$data = null)
    {
        return response()->json([
            'error' => $error,
            'message' => $message,
            'errorCode' => $errorCode,
            'data' => $data
        ]);
    }

    protected function responseRedirect($route,$type = 'info',$message,$error = false,$withOldInputWhenError = false)
    {
        // For Set and display flash message on action.
        $this->setFlashMessage($message,$type);
        $this->showFlashMessages();

        // For eg. While Adding Record is there any information is wrong then after page load filled information will filled with filled information.
        if($error && $withOldInputWhenError){
            return redirect()->back()->withInput();
        }

        // if there is no Error then it will be redirect on given route.
        return redirect()->route($route);
    }


    /**
     * this function is use when eg. category page on single page edit. when user click on edit page
     *  informations are filled in same page.
     * @return void
     */
    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        try {
            $this->setFlashMessages($message, $type);
            $this->showFlashMessages();

            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
