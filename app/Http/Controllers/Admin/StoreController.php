<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Store;
use App\FileEntry;

class StoreController extends Controller {

    public function index(Request $request) {

        // 获取排序条件
        $orderColumn = $request->get('sort_up', $request->get('sort_down', 'created_at'));
        $direction   = $request->get('sort_up') ? 'asc' : 'desc' ;

        $stores = Store::orderBy($orderColumn, $direction)->paginate(999);;

        return view('admin.store.list', compact('stores', 'query'));
    }
    public function show($id) {
        $store = Store::find($id);
        return response()->json($store);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
        ]);

        $store = new Store;
        $store->fill($request->all());

        $store->save();

        return response()->json(['id' => $store->id]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
        ]);

        $store = Store::find($id);
        $store->fill($request->all());

        $store->save();

        return response()->json(['id' => $store->id]);
    }

    public function destroy($id)
    {
        $store = Store::find($id);

        if($store->file_entries_id !== 0) {
            $entry = FileEntry::find($store->file_entries_id);
            Storage::delete($entry->filename);
            $entry->delete();
        }

        $store->delete();
        return response()->json(['id' => $id]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getClassroomsByID(Request $request, $id) {
        $is_select = $request->input('is_select');

        $classrooms = DB::table('classrooms')->where('store_id', $id)->where('deleted_at', null);
        if($is_select === 1) {
            $classrooms->select('id', 'name');
        }
        $classrooms = $classrooms->get();

        return response()->json($classrooms);
    }

    public function updateCover(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $file = $request->file('cover');;
        $extension = $file->getClientOriginalExtension();
        $filename = 'cover/'.$store->id.'/'.$file->getFilename().'.'.$extension;
        Storage::disk('local')->put($filename, File::get($file));

        $entry = FileEntry::findOrNew($store->file_entries_id);
        if($store->file_entries_id !== 0) {
            Storage::delete($entry->filename);
        }

        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $filename;
        $entry->save();

        $store->file_entries_id = $entry->id;
        $store->save();

        return response()->json(['id' => $entry->id]);
    }
}
