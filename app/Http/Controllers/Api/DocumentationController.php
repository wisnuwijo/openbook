<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DocBreakdown;
use App\Model\DocDetail;

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
        if (count($getDocBreakdown) == 0) return abort(404);
        
        return response(['data' => $getDocBreakdown]);
    }

    public function saveDocDetail(Request $req)
    {
        $data = request(['documentation_breakdown_id','content','created_by']);

        $insertDocDetail = DocDetail::insert($data);
        if (!$insertDocDetail) return response(['status' => $insertDocDetail], 500);
        
        return response(['status' => $insertDocDetail]);
    }
}
