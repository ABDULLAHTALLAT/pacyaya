<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        return view('designs.index', [
            'designs' => $request->user()->designs()->with('template')->latest()->get(),
        ]);
    }

    public function create(Template $template)
    {
        $design = new Design([
            'name' => 'My ' . $template->name,
            'template_id' => $template->id,
            'shape' => $template->shape,
            'width' => $template->width,
            'height' => $template->height,
            'depth' => $template->depth,
            'color' => $template->default_color,
            'text' => 'Pacyaya',
            'text_color' => '#ffffff',
            'font_size' => 64,
        ]);

        return view('designs.editor', ['design' => $design, 'template' => $template]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['shape'] = Template::findOrFail($data['template_id'])->shape;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('designs', 'public');
        }

        $design = Design::create($data);

        return redirect()->route('designs.edit', $design)->with('status', __('ui.msg_saved'));
    }

    public function edit(Request $request, Design $design)
    {
        $this->authorizeOwner($request, $design);

        return view('designs.editor', ['design' => $design, 'template' => $design->template]);
    }

    public function update(Request $request, Design $design)
    {
        $this->authorizeOwner($request, $design);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($design->image_path) {
                Storage::disk('public')->delete($design->image_path);
            }
            $data['image_path'] = $request->file('image')->store('designs', 'public');
        } elseif ($request->boolean('remove_image') && $design->image_path) {
            Storage::disk('public')->delete($design->image_path);
            $data['image_path'] = null;
        }

        $design->update($data);

        return back()->with('status', __('ui.msg_updated'));
    }

    public function destroy(Request $request, Design $design)
    {
        $this->authorizeOwner($request, $design);

        if ($design->image_path) {
            Storage::disk('public')->delete($design->image_path);
        }
        $design->delete();

        return redirect()->route('designs.index')->with('status', __('ui.msg_deleted'));
    }

    public function preview(string $uuid)
    {
        $design = Design::with('template', 'user')->where('uuid', $uuid)->firstOrFail();

        return view('designs.preview', compact('design'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'template_id' => ['required', 'exists:templates,id'],
            'name' => ['required', 'string', 'max:120'],
            'width' => ['required', 'numeric', 'between:3,80'],
            'height' => ['required', 'numeric', 'between:3,80'],
            'depth' => ['required', 'numeric', 'between:3,80'],
            'color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'text' => ['nullable', 'string', 'max:60'],
            'text_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'font_size' => ['required', 'integer', 'between:12,160'],
            'image' => ['nullable', 'image', 'max:4096'],
            'pattern' => ['nullable', 'in:stripes,dots,waves,grid,chevron,stars'],
        ]);
    }

    private function authorizeOwner(Request $request, Design $design): void
    {
        abort_unless($design->user_id === $request->user()->id || $request->user()->isAdmin(), 403);
    }
}
