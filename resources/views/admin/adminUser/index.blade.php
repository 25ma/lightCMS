@extends('admin.base')

@section('content')
    @include('admin.breadcrumb')

    <table class="layui-table" lay-data="{url:'{{ route('admin::adminUser.list') }}', page:true, id:'test', toolbar:'<div><a href=\'{{ route('admin::adminUser.create') }}\'><i class=\'layui-icon layui-icon-add-1\'></i>新增管理员</a></div>'}" lay-filter="test">
        <thead>
        <tr>
            <th lay-data="{field:'id', width:80, sort: true}">ID</th>
            <th lay-data="{field:'name'}">用户名</th>
            <th lay-data="{field:'statusText'}">状态</th>
            <th lay-data="{field:'created_at'}">添加时间</th>
            <th lay-data="{field:'updated_at'}">更新时间</th>
            <th lay-data="{width:200, templet:'#action'}">操作</th>
        </tr>
        </thead>
    </table>
@endsection

<script type="text/html" id="action">
    <a href="<% d.editUrl %>" class="layui-table-link"><i class="layui-icon layui-icon-edit"></i></a>
</script>

@section('js')
    <script>
        var laytpl = layui.laytpl;
        laytpl.config({
            open: '<%',
            close: '%>'
        });
    </script>
@endsection