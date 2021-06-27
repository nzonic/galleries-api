<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\User;
use App\Rules\ArrayAtLeastOneRequired;
use App\Http\Requests\GalleryRequest;
class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('PAGE_SIZE', 10);
        $search = $request->query('search', '');
        $id = $request->query('userId', 0);
        if ($id > 0) {
            return User::findOrFail($id)->galleries()->withOnly(['user', 'images'])->search($search)->orderBy('created_at', 'DESC')->paginate($pageSize);
        }
        return Gallery::withOnly(['user', 'images'])->search($search)->orderBy('created_at', 'DESC')->paginate($pageSize);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $data = $request->validated();
        $user = User::find(auth()->id());
        $gallery = $user->galleries()->create($data);
        // $gallery->images()->saveMany($request->input('images'));
        foreach ($request->input('images') as $key => $data) {
            $gallery->images()->create($data);
        }
        return $gallery;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return $gallery;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();
        $gallery->update($request->except('images'));
        $gallery->images()->delete();
        foreach ($request->input('images') as $value) {
            unset($value['created_at']);
            unset($value['updated_at']);
            $gallery->images()->updateOrCreate($value);
        }
        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response('Successfully Deleted', 200);
    }
}
