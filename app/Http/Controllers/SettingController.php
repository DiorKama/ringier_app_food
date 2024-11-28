<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::whereNotNull('name')
            ->whereNotNull('address')
            ->first();

        if (!$setting) {
            $setting = Setting::create(config('settings'));
        }

        return view(
            'admin.settings.index',
            compact(
                'setting',
            )
        );
    }

    public function edit(Setting $setting)
    {
        return view(
            'admin.settings.edit',
            compact(
                'setting',
            )
        );
    }

    public function update(
        SettingUpdateRequest $request,
        Setting $setting
    ) {
        $validator = Validator::make(
            $request->all(),
            [
                'logo' => 'sometimes|mimes:jpeg,jpg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->route('admin.settings.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $setting->update($request->validated());

        return redirect()
            ->route('admin.settings.index')
            ->withMessage(__('Vos paramètres ont été mis à jour avec succès!'));
    }
}
