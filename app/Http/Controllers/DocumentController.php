<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Document;
use App\Models\DocumentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docs = Document::get();
        return view("pages.documents.index",compact("docs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::get();
        return view("pages.documents.create", compact("projects"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }

        $doc = Document::create([
            'description' => $request->description,
            'project_id' => $request->project_id,
            'created_by' => auth()->user()->id
        ]);

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {
                if ($file != null && $request->file_description[$key] != null) {

                    $extension = $file->getClientOriginalExtension();
                    $uniqueFilename = 'echopus_' . uniqid() . '.' . $extension;

                    $path = $file->storeAs('documents', $uniqueFilename, 'public');

                    $docFile = DocumentFile::create([
                        'document_id' => $doc->id,
                        'file_url' => $path,
                        'file_description' => $request->file_description[$key]
                    ]);
                }
            }
        }

        toastr()->success('Files uploaded successfully!');
        return redirect()->back();
    }


    public function show(Document $document)
    {
        return response()->json($document->load("documenFiles"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $projects = Project::get();
        return view("pages.documents.edit", compact("document", "projects"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }

        $document->update([
            'description' => $request->description,
            'project_id' => $request->project_id,
        ]);
        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {
                if ($file != null && $request->file_description[$key] != null) {

                    $extension = $file->getClientOriginalExtension();
                    $uniqueFilename = 'echopus_' . uniqid() . '.' . $extension;

                    $path = $file->storeAs('documents', $uniqueFilename, 'public');

                    $docFile = DocumentFile::create([
                        'document_id' => $document->id,
                        'file_url' => $path,
                        'file_description' => $request->file_description[$key]
                    ]);
                }
            }
        }

        toastr()->success('Files uploaded successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {

        try{
            if(!empty($document->documenFiles)){
                foreach ($document->documenFiles as $file){
                    Storage::delete($file->file_url);
                    $file->delete();
                }
            }

            $document->delete();
            return response()->json(["message" => "Document deleted"], 200);
        }catch (\Exception $e){

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }


    public function destroyFile(DocumentFile $file)
    {

        try {
            Storage::delete($file->file_url);

            $file->delete();

            return response()->json(["message" => "File deleted"], 200);
        } catch (\Exception $e) {

            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
