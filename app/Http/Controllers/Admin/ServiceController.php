<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image_url' => ['nullable','string','max:2000'],
            'checklist_text' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $service = new Service();
        $service->icon = $data['icon'] ?? null;
        $service->title = $data['title'];
        $service->description = $data['description'] ?? null;
        $service->image_url = $data['image_url'] ?? null;
        $service->sort_order = $data['sort_order'] ?? 0;
        $service->checklist = $this->parseChecklist($data['checklist_text'] ?? '');
        $service->save();

        return redirect()->route('admin.services.index')->with('status','Service created');
    }

    public function edit(Service $service)
    {
        $checklist_text = is_array($service->checklist) ? implode("\n", $service->checklist) : '';
        return view('admin.services.edit', compact('service','checklist_text'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image_url' => ['nullable','string','max:2000'],
            'checklist_text' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $service->icon = $data['icon'] ?? null;
        $service->title = $data['title'];
        $service->description = $data['description'] ?? null;
        $service->image_url = $data['image_url'] ?? null;
        $service->sort_order = $data['sort_order'] ?? 0;
        $service->checklist = $this->parseChecklist($data['checklist_text'] ?? '');
        $service->save();

        return redirect()->route('admin.services.index')->with('status','Service updated');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        // Renumber sort_order so remaining services are 1, 2, 3, ...
        $remaining = Service::orderBy('sort_order')->orderBy('id')->get();
        foreach ($remaining as $i => $s) {
            $s->sort_order = $i + 1;
            $s->save();
        }

        return redirect()->route('admin.services.index')->with('status','Service deleted');
    }

    private function parseChecklist(string $text): array
    {
        // split by newlines or commas, trim, remove empties
        $items = preg_split('/\r\n|\r|\n|,/', $text);
        $items = array_map('trim', $items ?: []);
        return array_values(array_filter($items, fn($v) => $v !== ''));
    }
}
