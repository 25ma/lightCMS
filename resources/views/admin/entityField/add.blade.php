@extends('admin.base')

@section('content')
    <div class="layui-card">

        @include('admin.breadcrumb')

        <div class="layui-card-body">
            <form class="layui-form" action="@if(isset($id)){{ route('admin::entityField.update', ['id' => $id]) }}@else{{ route('admin::entityField.save') }}@endif" method="post">
                @if(isset($id)) {{ method_field('PUT') }} @endif
                    <div class="layui-form-item">
                        <label class="layui-form-label">模型</label>
                        <div class="layui-input-block">
                            <select name="model_id">
                            @foreach($entity as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                            </select>

                        </div>
                    </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">字段名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required  lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->name ?? ''  }}">
                    </div>
                </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">字段类型</label>
                        <div class="layui-input-block">
                            <input type="text" name="type" required  lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->type ?? ''  }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">字段注释</label>
                        <div class="layui-input-block">
                            <input type="text" name="comment" autocomplete="off" class="layui-input" value="{{ $model->comment ?? ''  }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">表单名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="form_name" required  lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->form_name ?? ''  }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">表单类型</label>
                        <div class="layui-input-block">
                            <input type="text" name="form_type" required  lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->form_type ?? ''  }}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">表单备注</label>
                        <div class="layui-input-block">
                            <input type="text" name="form_comment" autocomplete="off" class="layui-input" value="{{ $model->form_comment ?? ''  }}">
                        </div>
                    </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formAdminUser" id="submitBtn">提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var form = layui.form;

        //监听提交
        form.on('submit(formAdminUser)', function(data){
            window.form_submit = $('#submitBtn');
            form_submit.prop('disabled', true);
            $.ajax({
                url: data.form.action,
                data: data.field,
                success: function (result) {
                    if (result.code !== 0) {
                        form_submit.prop('disabled', false);
                        layer.msg(result.msg, {shift: 6});
                        return false;
                    }
                    layer.msg(result.msg, {icon: 1}, function () {
                        if (result.reload) {
                            location.reload();
                        }
                        if (result.redirect) {
                            location.href = result.redirect;
                        }
                    });
                }
            });

            return false;
        });
    </script>
@endsection
