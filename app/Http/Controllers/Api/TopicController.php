<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TopicMeta;
use App\Model\Topic;
use App\User;
use Auth;

class TopicController extends Controller
{
    
    public function topicList(Request $req)
    {
        $topic = [];

        $isAdmin = Auth::user()->role_id == 1;
        if ($isAdmin) {
            $getTopic = Topic::get();
        } else {
            $gatherTopic = TopicMeta::where([
                                ['key', 'assignees'],
                                ['value', Auth::user()->id]
                            ])
                            ->get();

            $topicIdList = [];
            for ($i=0; $i < count($gatherTopic); $i++) { 
                $currElement = $gatherTopic[$i];
                $topicIdList[] = $currElement->topic_id;
            }

            $getTopic = Topic::where('created_by', Auth::user()->id)
                        ->orWhereIn('id', $topicIdList)
                        ->get();
        }
        
        if (count($getTopic) > 0) {
            foreach ($getTopic as $gt) {
                $assignees = [];
                $getTopicMeta = TopicMeta::where('topic_id', $gt->id)->get();

                for ($i=0; $i < count($getTopicMeta); $i++) { 
                    $element = $getTopicMeta[$i];
                    if ($element->key == 'assignees') {
                        $user = User::find($element->value);

                        if (isset($user)) $assignees[] = $user->name;
                    }
                }

                $btn = '<a href="'.url("admin/documentation/setting").'/'. base64_encode($gt->id) .'" class="btn btn-white">
                    Setting
                </a>
                <a href="'. url("admin/documentation/update?topic_id=") . base64_encode($gt->id) .'" class="btn btn-white">
                    Update
                </a>
                <a href="#" onclick="deleteConfirm(\''. $gt->id .'\',\''. $gt->name .'\')" class="btn btn-white confirm-delete-btn" data-toggle="modal" data-target="#confirm-delete-prompt">
                    Delete
                </a>';
                
                $topic[] = [
                    'topic_name' => $gt->name,
                    'topic_created_by' => $gt->user->name,
                    'topic_last_update' => datetimeIdFormat($gt->updated_at),
                    'topic_date_created' => datetimeIdFormat($gt->created_at),
                    'topic_assignees' => implode(',', $assignees),
                    'topic_id' => $gt->id,
                    'action_btn' => $btn
                ];
            }
        }

        return response([
            'data' => $topic
        ]);
    }
}
