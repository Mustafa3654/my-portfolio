<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\Document;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $projects = Project::query()->published()->ordered()->get();

        return view('pages.home', [
            'profile'      => Profile::current(),
            'projects'     => $projects,
            'board'        => $projects->where('on_board', true),
            'spotlight'    => $projects->where('is_spotlight', true),
            'experience'   => Experience::query()->published()->ordered()->get(),
            'education'    => Education::query()->published()->ordered()->get(),
            'capabilities' => Capability::query()->published()->ordered()->get(),
            'cv'           => Document::cv(),
            'certificates' => Document::certificates(),
        ]);
    }
}
