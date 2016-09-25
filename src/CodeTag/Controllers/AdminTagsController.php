<?php


namespace CodePress\CodeTag\Controllers;

use CodePress\CodeTag\Repository\TagRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminTagsController extends Controller
{
    private $repository;
    private $response;

    public function __construct(ResponseFactory $response, TagRepositoryInterface $repository)
    {
        $this->response = $response;
        $this->repository = $repository;
    }

    public function index()
    {
        $tags = $this->repository->all();
        return $this->response->view('codetag::index', compact('tags'));
    }

    public function create()
    {
        return $this->response->view('codetag::create');
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('admin.tags.index');
    }

    public function edit($id)
    {
        $tag = $this->repository->find($id);
        return $this->response->view('codetag::edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        unset($data['_token']);

        if (!isset($data['active'])) {
            $data['active'] = 0;
        }

        $this->repository->update($data, $id);
        return redirect()->route('admin.tags.index');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.tags.index');
    }
}