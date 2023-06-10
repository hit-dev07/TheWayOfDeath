<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function getSchoolPost(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        // $isLiked = Like::where('userId',$userId)->count();
        $roleId = Auth::user()->roleId;
        if ($roleId < 3) {
            return Post::whereIn('contentId', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 23, 24])
                ->where('schoolId', $request->schoolId)
                ->where('classId', $request->lessonId)
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'votings',
                    'anouncements',
                    'shares',
                    'shiftMng',
                    'safestudy',
                    'repairdata',
                    'schoolstory',
                    'regnames',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::whereIn('contentId', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 23, 24])
                ->where('schoolId', $request->schoolId)
                ->where('classId', $request->lessonId)
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'votings',
                    'anouncements' => function ($query) use ($userId) {
                        $query->where("showList", "like", "%{$userId}%")
                            ->orWhere('showList', null);
                    },
                    'shares' => function ($query) use ($userId) {
                        $query->where('viewList', null)
                            ->orWhere("viewList", "like", "%{$userId}%");
                    },
                    'shiftMng',
                    'safestudy' => function ($query) use ($userId) {
                        $query->where('viewList', null)
                            ->orWhere("viewList", "like", "%{$userId}%");
                    },
                    'repairdata',
                    'schoolstory' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'regnames',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function getClassPost(Request $request)
    {
        $this->validate($request, [
            'classId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $classId = $request->classId;
        $roleId = Auth::user()->roleId;
        if ($roleId < 3) {
            return Post::whereIn('contentId', [1, 2, 5, 7, 8, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27])
                ->where('classId', $classId)
                ->orWhere(function ($query) use ($classId) {
                    $query->where('viewList', 'like', "%{$classId}%");
                    // ->orWhere('viewList', null);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'votings',
                    'anouncements',
                    'homeVisit',
                    'notifications',
                    'evaluations',
                    'recognitions',
                    'homework',
                    // 'homeworkResult.homework',
                    'safestudy',
                    'shares',
                    'regnames',
                    'classstory',
                    'interclassstory',
                    'vacations',
                    'returnteam',
                    'repairdata',
                    'todayduty',
                    'lattendance',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::whereIn('contentId', [1, 2, 5, 7, 8, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27])
                ->where('classId', $classId)
                ->orWhere(function ($query) use ($classId) {
                    $query->where('viewList', 'like', "%{$classId}%");
                    // ->orWhere('viewList', null);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'votings',
                    'anouncements' => function ($query) use ($userId) {
                        $query->where("showList", "like", "%{$userId}%")
                            ->orWhere('showList', null);
                    },
                    'homeVisit',
                    'notifications',
                    'evaluations',
                    'recognitions',
                    'homework' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    // 'homeworkResult.homework',
                    'safestudy' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'shares' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'regnames',
                    'classstory' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'interclassstory' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'vacations',
                    'returnteam',
                    'repairdata',
                    'todayduty',
                    'lattendance',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function getClassPhoto(Request $request)
    {
        $this->validate($request, [
            'classId' => 'required'
        ]);
        $classId = $request->classId;
        $posts = Post::whereIn('contentId', [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->where('classId', $classId)
            ->with([
                'questionnaires:postId,content',
                'votings:postId,content',
                'homework:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'homeworkResult:postId,content',
                'users:id,name'
            ])
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $albumData = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 12:
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $imgUrls = $questionItem->imgUrl;
                                    foreach ($imgUrls as $imgUrl) {
                                        $path = $imgUrl->path;
                                        array_push($albumData, $path);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 13:
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($albumData, $path);
                        }
                    }
                    break;
                case 14:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homework->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 15:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 16:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homeVisit->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 17:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->notifications->description);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 18:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = json_decode($post->evaluations->selMedalList);
                    break;
                case 19:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = $post;
                    // $contentData = $post;
                    // $contentData = $post->recognitions;
                    // $contentData = $post->recognitions->imgUrl;
                    break;
                case 20:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 21:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 22:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 23:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                default:
                    break;
            }
        }
        return $albumData;
    }

    public function getClassFile(Request $request)
    {
        $this->validate($request, [
            'classId' => 'required'
        ]);
        $classId = $request->classId;
        $posts = Post::whereIn('contentId', [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->where('classId', $classId)
            ->with([
                'questionnaires:postId,content',
                'votings:postId,content',
                'homework:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'homeworkResult:postId,content',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        $fileData = array();
        $videoData = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 12:
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $otherUrls = $questionItem->otherUrl;
                                    foreach ($otherUrls as $otherUrl) {
                                        // $path = $otherUrl->path;
                                        array_push($fileData, $otherUrl);
                                    }
                                    $videoUrls = $questionItem->videoUrl;
                                    foreach ($videoUrls as $videoUrl) {
                                        // $path = $videoUrl->path;
                                        array_push($videoData, $videoUrl);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 13:
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            // $path = $otherUrl->path;
                            array_push($fileData, $otherUrl);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            // $path = $videoUrl->path;
                            array_push($videoData, $videoUrl);
                        }
                    }
                    break;
                case 14:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homework->content);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 15:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 16:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homeVisit->content);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 17:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->notifications->description);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 18:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = json_decode($post->evaluations->selMedalList);
                    break;
                case 19:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = $post;
                    // $contentData = $post;
                    // $contentData = $post->recognitions;
                    // $contentData = $post->recognitions->imgUrl;
                    break;
                case 20:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 21:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 22:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 23:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                default:
                    break;
            }
        }
        return response()->json([
            'fileData' => $fileData,
            'videoData' => $videoData
        ], 200);
    }

    public function deletePost(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        Post::where('id', $request->postId)->delete();
        return $request->postId;
    }

    public function getReadCnt(Request $request)
    {
        $this->validate($request, [
            'userList' => 'required'
        ]);

        return User::whereIn('id', $request->userList)->get();
    }

    public function createReadCnt(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        $post = Post::where('id', $request->postId)->first();
        $readList = $post->readList;
        $userId = Auth::user()->id;
        if (is_null($readList)) {
            $newArr = array();
            array_push($newArr, $userId);
            $post->readList = $newArr;
        } else {
            $newArr = array();
            if (!in_array($userId, $readList, true)) {
                array_push($readList, $userId);
            }
            $post->readList = $readList;
        }
        $post->update();
        return true;
    }

    public function fixTop(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        $post = Post::where('id', $request->postId)->first();
        // $post->updated_at = DB::raw('NOW()');
        // $post->update();
        $currentTime = \Carbon\Carbon::now();
        $post->fixTop = $currentTime;
        // $post->touch();
        $post->update();
        return $post->id;
    }

    public function relaseTop(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        $post = Post::where('id', $request->postId)->first();
        // $post->updated_at = DB::raw('NOW()');
        // $post->update();
        $currentTime = NULL;
        $post->fixTop = $currentTime;
        // $post->touch();
        $post->update();
        return $post->id;
    }
}
