<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Topic;
use App\Model\Version;

class PostController extends Controller
{
    public function view()
    {
        return view('modules.post.index');
    }

    public function newTopic()
    {
        return view('modules.post.newTopic');
    }

    public function newTopicSave(Request $req)
    {
        $data = $req->except('_token');

        $validator = $req->validate([
            'name' => 'required|max:255',
            'open_for_public' => 'required',
        ]);
        
        $insertNewRecord = Topic::insert($data);

        if (!$insertNewRecord) {
            return redirect()->back()->with([
                'status' => 'Task was unsuccessful! Please try again'
            ]);
        }

        return redirect('/admin/post/new-version');
    }
}
