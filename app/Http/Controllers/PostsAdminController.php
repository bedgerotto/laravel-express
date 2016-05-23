<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsAdminController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {

        $posts = $this->post->paginate(5);

        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Requests\PostRequest $request)
    {
        $post = $this->post->create($request->all());

        $post->tags()->sync($this->getTags($request->tags));

        return redirect()->route('admin.index');
    }

    public function edit($id)
    {
        $post = $this->post->find($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update($id, Requests\PostRequest $request)
    {
        $this->post->find($id)->update($request->all());
        $post = $this->post->find($id);
        $post->tags()->sync($this->getTags($request->tags));
        return redirect()->route('admin.index');
    }

    public function destroy($id)
    {
        $this->post->find($id)->delete();
        return redirect()->route('admin.index');
    }

    private function getTags($tagList)
    {
        $tags = array_filter(array_map('trim', explode(',', $tagList)));

        $tagsId = [];

        foreach ($tags as $tag) {
            $tagsId[] = Tag::firstOrCreate(['name' => $tag])->id;
        }

        return $tagsId;
    }
}
