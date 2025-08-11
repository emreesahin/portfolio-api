<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request) {
    try {
        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters(['featured', 'title'])
            ->allowedSorts(['created_at', 'started_at'])
            ->with('media')
            ->paginate($request->integer('per_page', 10))
            ->appends($request->query());

        return ProjectResource::collection($projects);
    } catch (\Exception $e) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Projeler listelenemedi',
                    'errors' => $e->getMessage(),
                ], 500);
            }
        }


    public function show (string $slug) {

        $project = Project::where('slug',$slug)->with('media')->firstOrFail();
        return new ProjectResource($project);

    }

    public function store (ProjectRequest $request) {
        $project = Project::create($request->validated());
        return new ProjectResource($project);
    }

    public function update (ProjectRequest $request, Project $project) {
        $project->update($request->validated());
        return new ProjectResource($project);
    }

    public function destroy (Project $project) {
        $project->delete();
        return response()->json(['ok' => true]);
    }

    public function uploadCover(Request $request, Project $project) {

        $request->validate(['file' => 'required|image|max:4096']);
        $project->clearMediaCollection('cover');
        $project->addMedia($request->file('file')->toMediaCollection('cover'));

        return response()->json([
            'ok' => true,
            'cover' => $project->getFirstMediaUrl('cover'),
        ]);
    }

    public function uploadGallery(Request $request, Project $project){
        $request->validate(['files.*' => 'required|media|max:4096']);


         foreach (($request->file('files') ?? []) as $file) {
            $project->addMedia($file)->toMediaCollection('gallery');
        }

        return respone()->json([
            'ok' => true,
            'gallery' => $project->getMedia('gallery')->map->getUrl(),
        ]);
    }
}
