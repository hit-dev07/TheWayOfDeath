<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\HomeVisit;
use Illuminate\Support\Facades\Auth;

class HomeVisitController extends Controller
{
    //
    public function getHomeVisit(){

    }

    public function createHomeVisit(Request $request){
        $this->validate($request,[
            'userInfo'=>'required',
            'deadline'=>'required',
            'type'=>'required',
            'description'=>'required',
            'content'=>'required'
        ]);
        $classId = $request->classId;
        if($classId){
            $contentId = 16;
        }else{
            $contentId = 10;
        }
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>$contentId,
            'userId'=>$userId,
            'classId'=>$classId,
            'schoolId'=>$request->schoolId
        ])->id;
        return HomeVisit::create([
            'userInfo'=>json_encode($request->userInfo),
            'deadline'=>$request->deadline,
            'type'=>$request->type,
            'description'=>json_encode($request->description),
            'content'=>json_encode($request->content),
            'postId'=>$postId
        ]);
    }

    public function updateHomeVisit(Request $request){

    }

    public function deleteHomeVisit(Request $request){

    }
}
