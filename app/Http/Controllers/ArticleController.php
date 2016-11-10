<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DateTime;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Bican\Roles\Models\Permission;

class ArticleController extends Controller
{

    public function viewWithFilter(Request $request){

        $articles = Article::author($request->user)->from($request->from)->to($request->to)->orderBy('date', 'desc');
        $art = $articles->paginate(3);
        $countFilter = $articles->count()? $articles->count() : $request->countFilter ;

        if($request->user && $request->user != 'Все'){
            $art->appends(['user' => $request->user])->render();
        }
        if($request->from){
            $art->appends(['from' => $request->from])->render();
        }
        if($request->to){
            $art->appends(['to' => $request->to])->render();
        }
            $art->appends(['countFilter' => $countFilter])->render();

        return view('article.list', [
            'articles' => $art,
            'users' => User::all(),
            'countAll' => Article::all(),
            'countFilter' => $countFilter
        ]);
    }

    public function viewOne($id){

        return view('article.one', [
            'article' => Article::find($id),
        ]);
    }

    public function addComment(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'text' => 'required',
        ]);

        $model = new Comment();
        $model->article_id = $request->article_id;
        $model->email = $request->email;
        $model->text = $request->text;
        $model->date = new DateTime();

        if($model->save()){

            Auth::user()->attachPermission(Permission::firstOrCreate([
                'name' => 'comment_'.$model->id,
                'slug' => 'comment.'.$model->id,
            ]));

            return redirect()->back()->with('message', 'Комментарий успешно добавлен!)');
        }
        return redirect()->back()->with('message', 'FAIL');
    }

    public function updateComment(Request $request){
        if(Auth::user()->canUpdateAll() || Auth::user()->can('comment.'.$request->id)){

            $this->validate($request, [
                'email' => 'required|email',
                'text' => 'required',
            ]);

            $model = Comment::find($request->id);
            $model->article_id = $request->article_id;
            $model->email = $request->email;
            $model->text = $request->text;
            $model->date = new DateTime();

            if($model->save()){
               // return redirect()->back()->with('message', 'Комментарий успешно отредактирован!)');
                return redirect()->route('article.one', [$request->article_id])->with('message', 'Комметарий успешно отредактирован');
            }
            return redirect()->back()->with('message', 'FAIL');
        }
    }

    public function deleteComment($id){
        if(Auth::user()->canDeleteAll()){
           if(Comment::find($id)->delete()){
               return redirect()->back()->with('message', 'Успешно удалено!');
          }
        }
        return redirect()->back()->with('message', 'Нельзя удалить комментарий');
    }

    public function viewArticleUpdate($id){
        return view('article.updateArticle', ['article' => Article::find($id)]);
    }

    public function viewCommentUpdate($id){
        return view('article.updateComment', ['comment' => Comment::find($id)]);
    }


    public function updateArticle(Request $request){
        if(Auth::user()->canUpdateAll()){

            $this->validate($request, [
                'title' => 'required',
                'text' => 'required',
            ]);

            $model = Article::find($request->id);
            $model->user_id = $request->user_id;
            $model->title = $request->title;
            $model->text = $request->text;
            $model->date = new DateTime();

            if($model->save()){
                return redirect('/')->with('message', 'Статья успешно отредактирована');
            }
            return redirect()->back()->with('message', 'Неудачно');
        }
        return redirect()->back()->with('message', 'Недостаточно прав');
    }

    public function deleteArticle($id){
        if(Auth::user()->canDeleteAll()){
            Article::find($id)->delete();
            return redirect()->back()->with('message', 'OK');
        }
        return redirect()->back()->with('message', 'Нельзя удалить статью');
    }

    public function addArticle(Request $request){

            $this->validate($request, [
                'title' => 'required',
                'text' => 'required',
            ]);

            $model = new Article();
            $model->user_id = Auth::id();
            $model->title = $request->title;
            $model->text = $request->text;
            $model->date = new DateTime();

            if($model->save()){
                return redirect('/')->with('message', 'Запись успешно добавлена!)');
            }
            return redirect()->back()->with('message', 'FAIL');
    }

    public function viewAddForm(){

        return view('article.addArticle');
    }
}
