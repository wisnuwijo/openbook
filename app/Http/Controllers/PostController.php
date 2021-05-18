<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Topic;
use App\Model\TopicMeta;
use App\Model\Version;
use App\Model\DocBreakdown;
use App\Model\DocDetail;
use App\User;
use Auth;

class PostController extends Controller
{
    public function view()
    {
        hasPermission('VIEW_TOPIC_LIST');
        $deleteTopicPermission = hasPermission('DELETE_TOPIC','boolean');
        
        $data = [
            'delete_topic_permission' => $deleteTopicPermission
        ];

        return view('modules.documentation.index', $data);
    }

    public function setting($id)
    {
        hasPermission('UPDATE_TOPIC_SETTING');

        $id = base64_decode($id);
        $topic = Topic::find($id);
        $users = User::get();

        if (!isset($topic)) return abort(404);

        $getAssignees = TopicMeta::where('topic_id', $id)->get();
        
        $assignees = [];
        for ($i=0; $i < count($getAssignees); $i++) { 
            $assignees[] = $getAssignees[$i]->value;
        }

        $data = [
            'topic' => $topic,
            'assignees' => implode(',', $assignees),
            'user' => $users,
        ];

        return view('modules.documentation.setting', $data);
    }

    public function updateTopic($id, $data)
    {
        $validator = $data->validate([
            'name' => 'required|max:255',
            'open_for_public' => 'required',
        ]);

        $topic = Topic::where('id', $id);
        $updateTopic = $topic->update([
            'name' => $data->name,
            'open_for_public' => $data->open_for_public,
            'updated_at' => now(),
            'last_updated_by' => Auth::user()->id
        ]);

        $isAssigneesAvailable = isset($data->assignees) && count($data->assignees) > 0;
        if (!$isAssigneesAvailable) {
            // delete topic meta
            TopicMeta::where([
                ['topic_id', $id],
                ['key', 'assignees']
            ])
            ->delete();
        }

        if ($isAssigneesAvailable) {
            $resetAssignees = TopicMeta::where('topic_id', $id)->delete();
            foreach ($data->assignees as $asg) {
                TopicMeta::insert([
                    'topic_id' => $id,
                    'key' => 'assignees',
                    'value' => $asg,
                    'created_at' => now()
                ]);
            }
        }

        if (!$updateTopic) return false;
        return true;
    }

    public function update($id, Request $req)
    {
        $id = base64_decode($id);
        $validator = $req->validate([
            'name' => 'required|max:255',
            'open_for_public' => 'required',
        ]);

        $updateTopic = $this->updateTopic($id, $req);
        if (!$updateTopic) return redirect()->back()->with([
            'status-title' => 'Oops, something went wrong',
            'status->subtitle' => 'Task was unsuccessful! Please try again'
        ]);
        
        return redirect('/admin/documentation/view')->with([
            'status-title' => 'Success',
            'status-subtitle' => 'Topic updated',
        ]);;
    }

    public function newTopicAndVersion()
    {
        hasPermission('CREATE_NEW_TOPIC');

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
        $data["created_at"] = now();
        $data["created_by"] = Auth::user()->id;
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
        $versionData["created_at"] = now();

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

    public function gotoDocsBulder(Request $req)
    {
        $topicId = base64_decode($req->topic_id);
        $getLatestVersion = Version::where('topic_id', $topicId)
                            ->orderBy('id','desc')
                            ->first();
                            
        if (!isset($getLatestVersion)) return abort(404);

        return redirect('/admin/documentation/doc-breakdown?version_id='. $getLatestVersion->id . '&topic_id=' . $topicId);
    }

    public function docsBuilder(Request $req)
    {
        hasPermission('UPDATE_TOPIC_CONTENT');

        $topic = Topic::find($req->topic_id);
        return view('modules.documentation.docsBuilder', [
            'topic' => $topic
        ]);
    }

    public function deleteTopic($topicId)
    {
        $deleteTopicMeta = false;
        $deleteTopic = Topic::find($topicId)->delete();
        if ($deleteTopic) {
            $deleteTopicMeta = TopicMeta::where('topic_id', $topicId)->delete();
        }

        if ($deleteTopic) return true;
        return false;
    }

    public function deleteDocsBreakdownAndDetail($topicId)
    {
        $docsBreakdownIdList = [];
        $docsBreakdown = DocBreakdown::where('topic_id', $topicId)->get();
        for ($i=0; $i < count($docsBreakdown); $i++) { 
            $docsBreakdownIdList[] = $docsBreakdown[$i]->id;
        }

        $deleteDocsBreakdown = DocBreakdown::where('topic_id', $topicId)->delete();
        $deleteDocsDetail = DocDetail::whereIn('documentation_breakdown_id', $docsBreakdownIdList)->delete();

        return $deleteDocsBreakdown;
    }

    public function deleteDocsDetail($topicId)
    {
        return DocDetail::where('topic_id', $topicId)->delete();
    }

    public function deleteDocs($id)
    {
        $deleteTopic = $this->deleteTopic($id);
        $deleteDocs = $this->deleteDocsBreakdownAndDetail($id);

        return response([
            'status' => $deleteTopic
        ]);
    }
}
