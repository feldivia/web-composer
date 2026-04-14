<?php

declare(strict_types=1);

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class EditorController extends Controller
{
    public function editor(Page $page): View
    {
        return view('builder.editor', [
            'page' => $page,
            'fonts' => config('webcomposer.fonts'),
        ]);
    }

    public function templatePicker(Page $page): View
    {
        return view('builder.template-picker', [
            'page' => $page,
        ]);
    }
}
