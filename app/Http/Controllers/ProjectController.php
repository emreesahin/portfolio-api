<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{

    // Project list

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
                    'status' => false,
                    'message' => 'Projeler listelenemedi',
                    'errors' => $e->getMessage(),
                ], 500);
            }
        }

    // Project details

    public function show (string $slug) {
        try {
            $project = Project::where('slug',$slug)->with('media')->firstOrFail();
            return new ProjectResource($project);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Proje bulunamadı.',
                'errors' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Proje detayı getirilirken bir hata oluştu.',
                'errors' => $e->getMessage(),
            ], 500);
        }


    }

    // Create project

    public function store(ProjectRequest $request)
    {
        try {
            $project = DB::transaction(function () use ($request){
                return Project::create($request->validated());
            });
            return (new ProjectResource($project))
                ->additional([
                    'status' => true,
                    'message' => 'Proje başarıyla oluşturuldu.',
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Proje oluşturulurken bir hata oluştu.',
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }

    // Update project

    public function update (ProjectRequest $request, Project $project) {
        try{
            DB::transaction(function() use ($request, $project) {
                return $project->update($request->validated());
            });
            return (new ProjectResource($project))
                ->additional([
                    'status' => true,
                    'message' => 'Proje başarıyla güncellendi.',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Proje güncellenirken bir hata oluştu.',
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }

    // Delete project

    public function destroy (Project $project) {
        try{
            DB::transaction(function()use($project){
                $project->delete();
            });
            return response()->json([
                'status' => true,
                'message' => 'Proje başarıyla silindi.'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Proje silinirken bir hata oluştu.',
                'errors' => $exception->getMessage(),
            ], 500);
        }
    }

    // Upload cover image

   public function uploadCover(Request $request, Project $project) {
    try {
        $request->validate(['file' => 'required|image|max:4096']);

        DB::transaction(function () use ($request, $project) {
            $project->clearMediaCollection('cover');
            $project
                ->addMedia($request->file('file'))
                ->toMediaCollection('cover');
        });

        return response()->json([
            'status' => true,
            'message' => 'Kapak resmi başarıyla yüklendi.',
            'cover' => $project->getFirstMediaUrl('cover'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Kapak resmi yüklenirken bir hata oluştu.',
            'errors' => $e->getMessage(),
        ], 500);
    }
}

    // Upload gallery images

public function uploadGallery(Request $request, Project $project) {
    try {
       $request->validate([
    'files' => 'required',
    'files.*' => 'image|max:4096'
]);

$files = is_array($request->file('files'))
    ? $request->file('files')
    : [$request->file('files')]; // tek dosyayı array'e çevir

foreach ($files as $file) {
    $project
        ->addMedia($file)
        ->toMediaCollection('gallery');
}


        DB::transaction(function () use ($request, $project) {
            foreach ($request->file('files') as $file) {
                $project
                    ->addMedia($file)
                    ->toMediaCollection('gallery');
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Galeri resimleri başarıyla yüklendi.',
            'gallery' => $project->getMedia('gallery')->map->getUrl(),
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Galeri resimleri yüklenirken bir hata oluştu.',
            'errors' => $e->getMessage(),
        ], 500);
    }
}



    }

