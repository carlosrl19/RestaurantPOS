<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\StoreRequest;
use App\Http\Requests\Settings\UpdateRequest;
use App\Models\Settings;

class SettingsController extends Controller
{

    public function index()
    {
        $settings = Settings::first();
        return view('modules.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('modules.settings.create');
    }

    public function edit($id)
    {
        $setting = Settings::findOrFail($id);
        return view('modules.settings.edit', compact('setting'));
    }

    public function store(StoreRequest $request)
    {
        if (Settings::first()) {
            return redirect()->route('settings.index')->with('error', 'Ya existe una configuración guardada');
        }

        try {
            // Procesar y guardar la imagen para 'system_logo_report'
            $logoCompany = null;
            if ($request->hasFile('system_logo_report')) {
                $image = $request->file('system_logo_report');
                $imageName = 'system_logo_report.' . $image->getClientOriginalExtension();
                $image->move(storage_path('app/public/sys_config/img/'), $imageName);
                $logoCompany = $imageName; // Ruta relativa para el enlace simbólico
            }

            // Procesar y guardar la imagen para 'system_logo'
            $systemIcon = null;
            if ($request->hasFile('system_logo')) {
                $icon = $request->file('system_logo');
                $iconName = 'system_logo.' . $icon->getClientOriginalExtension();
                $icon->move(storage_path('app/public/sys_config/img/'), $iconName);
                $systemIcon = $iconName; // Ruta relativa para el enlace simbólico
            }

            // Crear el registro en la base de datos
            Settings::create([
                'system_logo_report' => $logoCompany,
                'system_logo' => $systemIcon,
                'system_name' => $request->input('system_name'),
                'company_name' => $request->input('company_name'),
                'company_cai' => $request->input('company_cai'),
                'company_rtn' => $request->input('company_rtn'),
                'company_phone' => $request->input('company_phone'),
                'company_email' => $request->input('company_email'),
                'company_address' => $request->input('company_address'),
                'company_short_address' => $request->input('company_short_address'),
            ]);

            return redirect()->route('settings.index')->with('success', 'Configuración guardada correctamente');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $settings = Settings::find($id);

        try {
            // Eliminar las imágenes antiguas si se suben nuevas
            if ($request->hasFile('system_logo_report')) {
                $oldLogoPath = storage_path('app/public/sys_config/img/') . $settings->system_logo_report;
                if (file_exists($oldLogoPath) && is_file($oldLogoPath)) {
                    unlink($oldLogoPath);
                }

                // Procesar y guardar la imagen para 'system_logo_report'
                $image = $request->file('system_logo_report');
                $imageName = 'system_logo_report.' . $image->getClientOriginalExtension();
                $image->move(storage_path('app/public/sys_config/img/'), $imageName);
                $settings->system_logo_report = $imageName;
            }

            if ($request->hasFile('system_logo')) {
                $oldIconPath = storage_path('app/public/sys_config/img/') . $settings->system_logo;
                if (file_exists($oldIconPath) && is_file($oldIconPath)) {
                    unlink($oldIconPath);
                }

                // Procesar y guardar la imagen para 'system_logo'
                $icon = $request->file('system_logo');
                $iconName = 'system_logo.' . $icon->getClientOriginalExtension();
                $icon->move(storage_path('app/public/sys_config/img/'), $iconName);
                $settings->system_logo = $iconName;
            }

            $settings->system_name = $request->input('system_name');
            $settings->company_name = $request->input('company_name');
            $settings->company_cai = $request->input('company_cai');
            $settings->company_rtn = $request->input('company_rtn');
            $settings->company_phone = $request->input('company_phone');
            $settings->company_email = $request->input('company_email');
            $settings->company_address = $request->input('company_address');
            $settings->company_short_address = $request->input('company_short_address');

            // Actualizar el registro en la base de datos
            $settings->save();

            return back()->with('success', 'Configuración actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }
}
