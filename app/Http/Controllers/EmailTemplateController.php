<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email-templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->update($request->only('subject', 'body'));

        return redirect()->route('email-templates.index')->with('success', 'Template updated successfully.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'template_type' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required',
        ]);

        EmailTemplate::create($data);
        return redirect()->route('email-templates.index')->with('success', 'Template created successfully.');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();
        return redirect()->route('email-templates.index')->with('success', 'Template deleted successfully.');
    }
}
