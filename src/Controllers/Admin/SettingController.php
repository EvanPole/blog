<?php

namespace Azuriom\Plugin\Blog\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show()
    {
        return view('blog::admin.settings', [
            'apiKey' => setting('blog.openai_key'),
            'model' => setting('blog.openai_model', 'gpt-4o-mini'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'openai_key' => ['nullable', 'string', 'max:255'],
            'openai_model' => ['required', 'string', 'max:50'],
        ]);

        Setting::updateSettings([
            'blog.openai_key' => $data['openai_key'],
            'blog.openai_model' => $data['openai_model'],
        ]);

        return to_route('blog.admin.settings')
            ->with('success', trans('messages.status.success'));
    }
}
