<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Topic;
use App\Model\Version;

class PostController extends Controller
{
    public function view()
    {
        return view('modules.documentation.index');
    }

    public function newTopicAndVersion()
    {
        return view('modules.documentation.newTopic');
    }

    public function generateNewTopicId()
    {
        $topicId = 1;
        $lastId = Topic::orderBy('id','desc')->first();
        if (isset($lastId)) $topicId = $lastId->id + 1;

        return $topicId;
    }

    public function generateNewVersionId()
    {
        $versionId = 1;
        $lastId = Version::orderBy('id','desc')->first();
        if (isset($lastId)) $versionId = $lastId->id + 1;

        return $versionId;
    }

    /**
     * insert new topic
     * 
     * @param Request $req
     * on succeed
     * @return Int $newTopicId
     * on failed
     * @return false
     */
    public function insertNewTopic(Request $req)
    {
        $validator = $req->validate([
            'name' => 'required|max:255',
            'open_for_public' => 'required',
        ]);

        $data = $req->only([
            'name',
            'open_for_public'
        ]);

        $newTopicId = $this->generateNewTopicId();
        $data["id"] = $newTopicId;
        $insertNewRecord = Topic::insert($data);

        if (!$insertNewRecord) return false;
        
        return $newTopicId;
    }

    public function insertNewVersion(Request $req)
    {
        $validator = $req->validate([
            'topic_id' => 'required',
            'name' => 'required',
        ]);
        
        $versionData = $req->only([
            'topic_id',
            'name'
        ]);
        
        $newVersionId = $this->generateNewVersionId();
        $versionData["id"] = $newVersionId;
        $insertNewVersion = Version::insert($versionData);

        if (!$insertNewVersion) return false;

        return $newVersionId;
    }

    public function newTopicAndVersionSave(Request $req)
    {
        $validator = $req->validate([
            'name' => 'required|max:255',
            'version_name' => 'required',
            'open_for_public' => 'required',
        ]);
        
        // insert new topic
        $newTopicId = $this->insertNewTopic($req);

        // insert new version
        if ($newTopicId) {
            $versionData = new Request();
            $versionData["name"] = $req->version_name;
            $versionData["topic_id"] = $newTopicId;
            $newVersionId = $this->insertNewVersion($versionData);
    
            if (!$newVersionId) {
                return redirect()->back()->with([
                    'status' => 'Task was unsuccessful! Please try again'
                ]);
            }

            $urlParams = '?version_id='. $newVersionId . '&topic_id=' . $newTopicId;
            return redirect('/admin/documentation/doc-breakdown' . $urlParams);
        }

        return redirect()->back()->with([
            'status' => 'Task was unsuccessful! Please try again'
        ]);
    }

    public function docBreakdown(Request $req)
    {
        return view('modules.documentation.docBreakdown');
    }

    public function docBreakdownx(Request $req)
    {
        return view('modules.documentation.docBreakdownx');
    }

    public function docBreakdownx1(Request $req)
    {
        return view('modules.documentation.docBreakdownx1');
    }
}
