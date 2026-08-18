<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $projects = Project::query()->published()->ordered()->get();

        return view('pages.home', [
            'projects'  => $projects,
            'board'     => $projects->where('on_board', true),
            'spotlight' => $projects->where('is_spotlight', true),
        ]);
    }
}
