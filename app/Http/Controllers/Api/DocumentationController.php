<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DocBreakdown;
use App\Model\DocDetail;
use App\Model\Version;
use App\Model\Topic;
use Auth;

class DocumentationController extends Controller
{
    public function getBreakdownHierarchy($versionId, $topicId, $data = [])
    {
        if (count($data) == 0) return $data;
        
        $index = 0;
        foreach ($data as $dt) {
            $getDocBreakdown = DocBreakdown::where([
                                ['version_id', $versionId],
                                ['topic_id', $topicId],
                                ['parent_id', $dt->id]
                            ])
                            ->get();

            $data[$index]->children = $this->getBreakdownHierarchy($versionId, $topicId, $getDocBreakdown);
            
            $index++;
        }

        return $data;
    }

    public function getDocBreakdown(Request $req)
    {
        $data = request(['version_id','topic_id']);
        $getParentBreakdown = DocBreakdown::where([
                                ['version_id', $data['version_id']],
                                ['topic_id', $data['topic_id']],
                                ['parent_id', null]
                            ])
                            ->get();

        $getDocBreakdown = $this->getBreakdownHierarchy($data['version_id'], $data['topic_id'], $getParentBreakdown);
        
        return response(['data' => $getDocBreakdown]);
    }

    public function saveDocBreakdown(Request $req)
    {
        $validator = $req->validate([
            'version_id' => 'required',
            'topic_id' => 'required',
            'name' => 'required'
        ]);
        
        $data = request(['version_id','topic_id','parent_id','name']);
        $data['link'] = base64_encode($data['version_id'] . $data['topic_id'] . strtotime(date('h:i:s')));
        $data['created_at'] = now();

        $insertDocBreakdown = DocBreakdown::insert($data);
        if (!$insertDocBreakdown) return response(['status' => $insertDocBreakdown], 500);
        
        $this->refreshLastUpdate($req->topic_id);
        
        return response(['status' => $insertDocBreakdown]);
    }

    public function getDocDetail(Request $req)
    {
        $validator = $req->validate([
            'breakdown_id' => 'required'
        ]);

        $data = request(['breakdown_id']);
        $detail = DocDetail::where('documentation_breakdown_id', $data['breakdown_id'])->first();

        if (!isset($detail)) return response(['data' => (Object) []]);

        return response([
            'data' => $detail
        ]);
    }

    public function getDocDetailWithUrl(Request $req)
    {
        $validator = $req->validate([
            'breakdown_url' => 'required'
        ]);

        $data = request(['breakdown_url']);
        $breakdown = DocBreakdown::where('link', $data['breakdown_url'])->first();

        $detail = null;
        if (isset($breakdown)) $detail = DocDetail::where('documentation_breakdown_id', $breakdown->id)->first();

        if (!isset($breakdown) || !isset($detail)) return response(['data' => (Object) []]);

        return response([
            'data' => $detail
        ]);
    }

    public function saveDocDetail(Request $req)
    {
        $data = request(['documentation_breakdown_id','content','created_by']);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $checkExisting = DocDetail::where('documentation_breakdown_id', $data['documentation_breakdown_id'])->first();

        if (!isset($checkExisting)) {
            $action = DocDetail::insert($data);
        } else {
            $action = DocDetail::where('documentation_breakdown_id', $data['documentation_breakdown_id'])
                        ->update([
                            'content' => $data['content']
                        ]);
        }
        
        if (!$action) return response(['status' => $insertDocDetail], 500);
        
        $currentBreadcrumb = DocBreakdown::where('id',$data['documentation_breakdown_id'])->first();
        $this->refreshLastUpdate($currentBreadcrumb->topic_id);
        
        return response(['status' => $action]);
    }

    public function generateBreadcrumbHierarchy($breadcrumb, $hierarchy = [])
    {
        if (!isset($breadcrumb)) return [];

        $getBreadcrumb = DocBreakdown::where('id', $breadcrumb->parent_id)->first();
        if (isset($getBreadcrumb)) $hierarchy[] = $getBreadcrumb;

        return $hierarchy;
    }

    public function getDocBreakcrumb(Request $req)
    {
        $validator = $req->validate([
            'id' => 'required'
        ]);

        $id = $req->id;
        $getBreadcrumb = DocBreakdown::find($id);
        $getContentDetail = DocDetail::where('documentation_breakdown_id', $id)->first();
        if (isset($getBreadcrumb)) {
            $data = $this->generateBreadcrumbHierarchy($getBreadcrumb, [$getBreadcrumb]);

            return response([
                'breadcrumb' => array_reverse($data),
                'content' => isset($getContentDetail) ? json_decode($getContentDetail->content) : (Object) []
            ]);
        }

        return response([]);
    }

    public function updateDocBreakcrumb(Request $req)
    {
        $validator = $req->validate([
            'id' => 'required',
            'name' => 'required'
        ]);

        $id = $req->id;
        $update = DocBreakdown::where('id', $id)->update([
            'name' => $req->name
        ]);

        if ($update) {
            $getTopicId = DocBreakdown::where('id', $id)->first();
            $this->refreshLastUpdate($getTopicId->topic_id);

            return response([
                'status' => true
            ]);
        }

        return response([
            'status' => false
        ]);
    }

    public function deleteDocBreakcrumb(Request $req)
    {
        $validator = $req->validate([
            'id' => 'required'
        ]);

        $id = $req->id;

        $currentBreadcrumb = DocBreakdown::find($id);
        $deleteBreadcrumb = $currentBreadcrumb->delete();
        $deleteChildren = DocBreakdown::where('parent_id', $id)->delete();

        if ($deleteBreadcrumb) {
            $this->refreshLastUpdate($currentBreadcrumb->topic_id);

            return response(['status' => true]);
        }

        return response(['status' => false]);
    }

    public function generateNewVersionId()
    {
        $getLastVersion = Version::orderBy('id','desc')->first();
        if (!isset($getLastVersion)) return 1;

        $lastId = $getLastVersion->id + 1;

        return $lastId;
    }

    public function getVersion(Request $req)
    {
        $validator = $req->validate([
            'topic_id' => 'required'
        ]);
        
        $getVersions = Version::where('topic_id', $req->topic_id)->get();

        return response([
            'versions' => $getVersions
        ]);
    }

    public function refreshLastUpdate($topicId)
    {
        if ($topicId == '') return false;
        if ($topicId == null) return false;

        $update = Topic::where('id', $topicId)
                  ->update([
                      'updated_at' => now(),
                      'last_updated_by' => Auth::user()->id
                  ]);

        return $update;
    }

    public function saveVersion(Request $req)
    {
        $validator = $req->validate([
            'name' => 'required',
            'topic_id' => 'required'
        ]);
        
        $newId = $this->generateNewVersionId();
        $insertVersion = Version::insert([
            'id' => $newId,
            'topic_id' => $req->topic_id,
            'name' => $req->name
        ]);

        if ($insertVersion) {
            $this->refreshLastUpdate($req->topic_id);

            $insertedVersion = Version::find($newId);
            return response(['status' => true, 'data' => $insertedVersion]);
        }

        return response(['status' => false]);
    }

    public function getBreakdown(Request $req)
    {
        $validator = $req->validate([
            'version_id' => 'required',
            'topic_id' => 'required'
        ]);
        
        $getParentBreakdown = DocBreakdown::where([
                                ['version_id', $req->version_id],
                                ['topic_id', $req->topic_id],
                                ['parent_id', null]
                            ])
                            ->get();

        $getDocBreakdown = $this->getBreakdownHierarchy($req->version_id, $req->topic_id, $getParentBreakdown);
        
        return response()->json([
            'breakdown' => $getDocBreakdown
        ]);
    }

    public function updateTopic(Request $req)
    {
        $validator = $req->validate([
            'name' => 'required',
            'topic_id' => 'required'
        ]);

        $update = Topic::where('id', $req->topic_id)->update([
            'name' => $req->name,
            'updated_at' => now(),
            'last_updated_by' => Auth::user()->id
        ]);

        return response([
            'status' => $update
        ]);
    }
}
