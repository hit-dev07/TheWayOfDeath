<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\Post;
use App\Template;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{

    public function getShare(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $roleId = Auth::user()->roleId;
        if ($roleId < 3) {
            if ($request->userId) {
                return Post::where(['schoolId' => $request->schoolId, 'userId' => $request->userId, 'contentId' => 23])
                    ->orWhere(function ($query) use ($request) {
                        $query->where(['contentId' => 23, 'classId' => null, 'schoolId' => $request->schoolId]);
                    })
                    ->with([
                        'likes',
                        'views',
                        'comments.users:id,name',
                        'shares',
                        'users:id,name,avatar'
                    ])
                    ->orderBy('fixTop', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            } else {
                return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 23])
                    ->orWhere(function ($query) use ($request) {
                        $query->where(['contentId' => 23, 'classId' => null, 'schoolId' => $request->schoolId]);
                    })
                    ->with([
                        'likes',
                        'views',
                        'comments.users:id,name',
                        'shares',
                        'users:id,name,avatar'
                    ])
                    ->orderBy('fixTop', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            }
        } else {
            if ($request->userId) {
                return Post::where(['schoolId' => $request->schoolId, 'userId' => $request->userId, 'contentId' => 23])
                    ->orWhere(function ($query) use ($request) {
                        $query->where(['contentId' => 23, 'classId' => null, 'schoolId' => $request->schoolId]);
                    })
                    ->with([
                        'likes',
                        'views',
                        'comments.users:id,name',
                        'shares' => function ($query) use ($userId) {
                            $query->where("viewList", "like", "%{$userId}")
                                ->orWhere('viewList', null);
                        },
                        'users:id,name,avatar'
                    ])
                    ->orderBy('fixTop', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            } else {
                return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 23])
                    ->orWhere(function ($query) use ($request) {
                        $query->where(['contentId' => 23, 'classId' => null, 'schoolId' => $request->schoolId]);
                    })
                    ->with([
                        'likes',
                        'views',
                        'comments.users:id,name',
                        'shares' => function ($query) use ($userId) {
                            $query->where("viewList", "like", "%{$userId}%")
                                ->orWhere('viewList', null);
                        },
                        'users:id,name,avatar'
                    ])
                    ->orderBy('fixTop', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            }
        }
    }

    public function createShare(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 23,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        if ($request->publishType == 'pub') {
            Share::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
            ]);
        } else if ($request->publishType == 'spec') {
            Share::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $request->specUsers,
            ]);
        } else if ($request->publishType == 'pvt') {
            $pvtArr = array();
            array_push($pvtArr, $userId);
            Share::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $pvtArr,
            ]);
        }

        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function getTempCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTempList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemp(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 23,
            'userId' => $userId,
            'tempTitle' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType,
            'lessonId' => $request->lessonId
        ]);
        return true;
    }

    public function deleteTemp(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Template::where('id', $request->id)->delete();
    }
}
