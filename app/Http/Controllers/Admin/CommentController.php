<?php
/**
 * @author  Eddy <cumtsjh@163.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentRequest;
use App\Repository\Admin\CommentRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommentController extends Controller
{
    protected $formNames = [];

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumb[] = ['title' => '评论列表', 'url' => route('admin::comment.index')];
    }

    /**
     * 评论管理-评论列表
     *
     */
    public function index()
    {
        $this->breadcrumb[] = ['title' => '评论列表', 'url' => ''];
        return view('admin.comment.index', ['breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 评论列表数据接口
     *
     * @param Request $request
     * @return array
     */
    public function list(Request $request)
    {
        $perPage = (int) $request->get('limit', 50);
        $condition = $request->only($this->formNames);

        $data = CommentRepository::list($perPage, $condition);

        return $data;
    }

    /**
     * 评论管理-新增评论
     *
     */
    public function create()
    {
        $this->breadcrumb[] = ['title' => '新增评论', 'url' => ''];
        return view('admin.comment.add', ['breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 评论管理-保存评论
     *
     * @param CommentRequest $request
     * @return array
     */
    public function save(CommentRequest $request)
    {
        try {
            CommentRepository::add($request->only($this->formNames));
            return [
                'code' => 0,
                'msg' => '新增成功',
                'redirect' => true
            ];
        } catch (QueryException $e) {
            return [
                'code' => 1,
                'msg' => '新增失败：' . (Str::contains($e->getMessage(), 'Duplicate entry') ? '当前评论已存在' : '其它错误'),
                'redirect' => false
            ];
        }
    }

    /**
     * 评论管理-编辑评论
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $this->breadcrumb[] = ['title' => '编辑评论', 'url' => ''];

        $model = CommentRepository::find($id);
        return view('admin.comment.add', ['id' => $id, 'model' => $model, 'breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 评论管理-更新评论
     *
     * @param CommentRequest $request
     * @param int $id
     * @return array
     */
    public function update(CommentRequest $request, $id)
    {
        $data = $request->only($this->formNames);
        try {
            CommentRepository::update($id, $data);
            return [
                'code' => 0,
                'msg' => '编辑成功',
                'redirect' => true
            ];
        } catch (QueryException $e) {
            return [
                'code' => 1,
                'msg' => '编辑失败：' . (Str::contains($e->getMessage(), 'Duplicate entry') ? '当前评论已存在' : '其它错误'),
                'redirect' => false
            ];
        }
    }

    /**
     * 评论管理-删除评论
     *
     * @param int $id
     */
    public function delete($id)
    {
        try {
            CommentRepository::delete($id);
            return [
                'code' => 0,
                'msg' => '删除成功',
                'redirect' => route('admin::comment.index')
            ];
        } catch (\RuntimeException $e) {
            return [
                'code' => 1,
                'msg' => '删除失败：' . $e->getMessage(),
                'redirect' => false
            ];
        }
    }
}
