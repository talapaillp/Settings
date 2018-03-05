<?php

namespace Backpack\Settings\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use CrudTrait;

    protected $table = 'settings';
    protected $fillable = ['value'];

    public static function get($key)
    {
    	$setting = new Setting;
    	$entry = $setting->where('key', $key)->first();

    	if (!$entry) {
    		return null;
    	}

		return $entry->value;
    }

    public static function set($key, $value = null)
    {
    	$setting = new Setting;
    	$entry = $setting->where('key', $key)->first();

    	if (!$entry) {
    		return false;
    	}

    	$entry->update(['value' => $value]);
    	\Config::set('settings.'.$key, $value);

    	return true;
    }
}
