<?php
/**
 * @author  Eddy <cumtsjh@163.com>
 */

namespace App\Repository\Admin;

use App\Model\Admin\Comment;
use App\Repository\Searchable;

class CommentRepository
{
    use Searchable;

    public static function list($perPage, $condition = [])
    {
        $data = Comment::query()
            ->where(function ($query) use ($condition) {
                Searchable::buildQuery($query, $condition);
            })
            ->with('entity:id,name')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        $data->transform(function ($item) {
            xssFilter($item);
            $item->editUrl = route('admin::comment.edit', ['id' => $item->id]);
            $item->deleteUrl = route('admin::comment.delete', ['id' => $item->id]);
            $item->entityName = !is_null($item->entity) ? $item->entity->name : '未知';
            $item->contentEditUrl = route('admin::content.edit', [$item->entity_id, $item->content_id]);
            $item->vistUrl = route('web::content', [$item->entity_id, $item->content_id]);
            return $item;
        });

        return [
            'code' => 0,
            'msg' => '',
            'count' => $data->total(),
            'data' => $data->items(),
        ];
    }

    public static function add($data)
    {
        return Comment::query()->create($data);
    }

    public static function update($id, $data)
    {
        return Comment::query()->where('id', $id)->update($data);
    }

    public static function find($id)
    {
        return Comment::query()->find($id);
    }

    public static function delete($id)
    {
        return Comment::destroy($id);
    }
}
