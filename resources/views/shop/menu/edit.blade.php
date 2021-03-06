@extends("shop.layouts.main")

@section("title","修改菜品")

@section("content")

    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>商品名称</label>
            <input type="text" class="form-control" placeholder="菜品名称" name="goods_name" value="{{old("goods_name",$menu->goods_name)}}">
        </div>

        {{--<div class="form-group">--}}
            {{--<label>商品评分</label>--}}
            {{--<input type="text" class="form-control" placeholder="评分" name="rating" value="{{old("rating",$menu->rating)}}">--}}
        {{--</div>--}}

        <div class="form-group">
            <label>商品所属商家</label>
            <input type="text" class="form-control" placeholder="所属商家" name="shop_id" value="{{old("shop_id",$menu->info->shop_name)}}" readonly>
        </div>

        <div class="form-group">
            <label>商品分类</label>
            <select name="category_id" class="form-control">
                <option>请选择</option>
                @foreach($results as $result)
                    <option value="{{$result->id}}"
                    <?php if($result['id']===$menu['category_id']) echo "selected='selected'";?>>
                        {{$result->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>商品价格</label>
            <input type="text" class="form-control" placeholder="价格" name="goods_price" value="{{old("goods_price",$menu->goods_price)}}">
        </div>

        <div class="form-group">
            <label>商品描述</label>
            <textarea name="description" cols="30" rows="5" class="form-control">{{$menu->description}}</textarea>
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label>商品月销量</label>--}}
            {{--<input type="text" class="form-control" placeholder="月销量" name="month_sales" value="{{old("month_sales",$menu->month_sales)}}">--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<label>商品评分数量</label>--}}
            {{--<input type="text" class="form-control" placeholder="评分数量" name="rating_count" value="{{old("rating_count",$menu->rating_count)}}">--}}
        {{--</div>--}}

        <div class="form-group">
            <label>提示信息</label>
            <input type="text" class="form-control" placeholder="提示信息" name="tips" value="{{old("tips",$menu->tips)}}">
        </div>

        {{--<div class="form-group">--}}
            {{--<label>满意度数量</label>--}}
            {{--<input type="text" class="form-control" placeholder="满意度数量" name="satisfy_count" value="{{old("satisfy_count",$menu->satisfy_count)}}">--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<label>满意度评分</label>--}}
            {{--<input type="text" class="form-control" placeholder="满意度评分" name="satisfy_rate" value="{{old("satisfy_rate",$menu->satisfy_rate)}}">--}}
        {{--</div>--}}

            <div class="form-group">
                <label>图像</label>
                <input type="hidden" name="goods_img" value="" id="img">
                <!--dom结构部分-->
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                    <img src="{{$menu->goods_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
                </div>
            </div>

        <div class="form-group">
            <label>商品状态</label>&emsp;
            <label class="radio-inline">

                <input type="radio" name="status" value="1" <?php if($menu->status==1) echo 'checked' ?>> 上线

            </label>
            <label class="radio-inline">

                <input type="radio" name="status" value="0" <?php if($menu->status==0) echo 'checked' ?>> 下线

            </label>
        </div>

        <button type="submit" class="btn btn-default">确认添加</button>
        </form>
@endsection

@section("js")
    <script>
        // 图片上传demo
        jQuery(function () {
            var $ = jQuery,
                $list = $('#fileList'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,

                // Web Uploader实例
                uploader;

            // 初始化Web Uploader
            uploader = WebUploader.create({

                // 自动上传。
                auto: true,

                formData: {
                    // 这里的token是外部生成的长期有效的，如果把token写死，是可以上传的。
                    _token:'{{csrf_token()}}'
                },


                // swf文件路径
                swf: '/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '{{route("shop.category.upload")}}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {
                var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');

                $list.html($li);

                // 创建缩略图
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr('src', src);
                }, thumbnailWidth, thumbnailHeight);
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');

                // 避免重复创建
                if (!$percent.length) {
                    $percent = $('<p class="progress"><span></span></p>')
                        .appendTo($li)
                        .find('span');
                }

                $percent.css('width', percentage * 100 + '%');
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file,data) {
                $('#' + file.id).addClass('upload-state-done');

                $("#img").val(data.url);
            });

            // 文件上传失败，现实上传出错。
            uploader.on('uploadError', function (file) {
                var $li = $('#' + file.id),
                    $error = $li.find('div.error');

                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error"></div>').appendTo($li);
                }

                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function (file) {
                $('#' + file.id).find('.progress').remove();
            });
        });
    </script>
@stop