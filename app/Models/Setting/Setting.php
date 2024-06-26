<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['key','value'];

    public static function get($key)
    {
        $setting = new self();

        $entry = $setting->where('key', $key)->first();

        if(!$entry){
            return ;
        }

        return $entry->value;
    }

    public static function set($key,$value)
    {
        $setting = new self();

        $entry = $setting->where('key',$key)->firstOrFail();

        $entry->value = $value;

        $entry->saveOrFail();

        config(['settings.'.$key => $value]);

        if(config('settings'.$key) == $value){
            return true;
        }
        return false;
    }
}
