<?php

namespace App\Traits;

trait FlashMessages
{ // here we have to add three methods setter,getter and show flash messages.
    protected $errorMessages = [];  //danger(Red) color

    protected $successMessages = []; // success(grees) color

    protected $infoMessages = []; // info(blue)  color

    protected $warningMessages = []; //warning(Yellow) Color

    protected function setFlashMessages($message,$type)
    {


        $model = 'infoMessages';

        switch ($type) {
            case 'info': {
                $model = 'infoMessages';
            }
                break;
            case 'error': {
                $model = 'errorMessages';
            }
                break;
            case 'success': {
                $model = 'successMessages';
            }
                break;
            case 'warning': {
                $model = 'warningMessages';
            }
                break;
        }

        if (is_array($message)) {
            foreach ($message as $key => $value)
            {
                array_push($this->$model, $value);
            }
        } else {
            array_push($this->$model, $message);
        }

    }

    protected function getFlashMessages()
    {
        return [
            'error' => $this->errorMessages,
            'info' => $this->infoMessages,
            'success' => $this->successMessages,
            'warning' => $this->warningMessages,
        ];
    }

    /**
     * Flushing flash messages to Laravel's session
     */

    public function showFlashMessages()
    {
       return[
            session()->flash('info',$this->errorMessages),
            session()->flash('success',$this->successMessages),
            session()->flash('error',$this->errorMessages),
            session()->flash('warning',$this->warningMessages),
       ];
    }
}
