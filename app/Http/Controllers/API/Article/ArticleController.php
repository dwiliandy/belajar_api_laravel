<?php

namespace App\Http\Controllers\Api\Article;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        return auth()->user()->articles;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'body' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id
         ]);

        return response()
            ->json(['data' => $article]);
    }
    public function show(Article $article){
        return response()->json(['data' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        
        $input = $request->all();
        return response()->json(['data' => $input]);
        $validator = Validator::make($request->all(),[
            'title' => ['required','string'],
            'body' => ['required']
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        
        $article->update($input);

        return response()->json(['data' => $article]);
    }


    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'successfully delete data']);
    }
}
