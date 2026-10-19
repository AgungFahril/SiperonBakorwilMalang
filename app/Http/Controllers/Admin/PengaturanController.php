<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        $waStatus = \App\Services\WhatsAppService::getDeviceStatus();
        return view('admin.pengaturan', compact('settings', 'waStatus'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
