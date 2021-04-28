<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Imports\ProjectsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()  // by this function we can show all dataTable in our Template
    {
        $projects = Project::latest()->paginate(5);

        $id = Auth::id();

        // print_r($id);
        // exit();

        return view('index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // this function show a Template to name create.blade.php
    public function create()
    {
        return view('create');
    }

    // this functionsave new data that we enter
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'introduction' => 'required',
            'location' => 'required',
            'cost' => 'required'
        ]);

        $projectName = $request->name;

        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', $projectName . ' created successfully.');
    }

    // this function show data in a Template to name show.blade.php
    public function show(Project $project)
    {
        return view('show', compact('project'));
    }

    // this function make to show that data for edit
    public function edit(Project $project)
    {
        return view('edit', compact('project'));
    }

    // this function update ourData
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'introduction' => 'required',
            'location' => 'required',
            'cost' => 'required'
        ]);

        $projectName = $request->name;

        $project->update($request->all());

        return redirect()->route('projects.index')
            ->with('success', $projectName . ' updated successfully');
    }

    // this function remove or delete data
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    // this function import new excel in database
    public function importProject()
    {

        Excel::import(new ProjectsImport, request()->file('file'));

        return back()->with('success', 'Project created successfully.');
    }
}
