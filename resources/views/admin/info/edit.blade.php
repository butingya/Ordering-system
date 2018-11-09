@extends("admin.layouts.main")

@section("title","商家店铺资料修改")

@section("content")

    <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label>店铺名称</label>
            <input type="text" class="form-control" name="shop_name" value="{{old("shop_name",$info->shop_name)}}">
        </div>

        <div class="form-group">
            <label>店铺分类</label>
            {{--<input type="tetx" class="form-control" placeholder="店铺分类" name="shop_category_id" value="{{old("shop_category_id")}}">--}}
            <select name="shop_category_id">
                <option value="">请选择分类</option>
                @foreach($results as $result)
                    <option value="{{$result->id}}" <?php if($result['id']===$info['shop_category_id']) echo "selected='selected'";?>>{{$result->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>店铺图片</label>
            <input type="text" name="shop_img" id="img">
            <!--dom结构部分-->
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
                {{--<img src="{{env("ALIYUN_OSS_URL").$info->shop_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">--}}
                <img src="{{$info->shop_img}}?x-oss-process=image/resize,m_fill,w_150,h_100">
            </div>
        </div>

        <div class="form-group">
            <label>起送金额</label>
            <input type="text" class="form-control" name="start_send" value="{{old("start_send",$info->start_send)}}">
        </div>

        <div class="form-group">
            <label>配送费</label>
            <input type="text" class="form-control" placeholder="配送费" name="send_cost" value="{{old("send_cost",$info->send_cost)}}">
        </div>

        <div class="form-group">
            <label>店铺公告</label>
            {{--<input type="text" class="form-control" placeholder="店铺公告" name="notice" value="{{old("notice")}}">--}}
            <textarea name="notice" cols="10" rows="5" class="form-control">{{$info->notice}}</textarea>
        </div>

        <div class="form-group">
            <label>优惠信息</label>
            {{--<input type="text" class="form-control" placeholder="优惠信息" name="discount" value="{{old("discount")}}">--}}
            <textarea name="discount" cols="10" rows="5" class="form-control">{{$info->discount}}</textarea>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="brand" value="1" <?php if($info->brand==1) echo 'checked' ?>> 是否品牌联盟&emsp;
            </label>

            <label>
                {{--<input type="checkbox" name="on_time"> 准时送达&emsp;--}}
                <input type="checkbox" name="on_time" value="1" <?php if($info->on_time==1) echo 'checked' ?>> 准时送达&emsp;
            </label>
            <label>
                {{--<input type="checkbox" name="fengniao"> 蜂鸟配送&emsp;--}}
                <input type="checkbox" name="fengniao" value="1" <?php if($info->fengniao==1) echo 'checked' ?>> 蜂鸟配送
            </label>
            <label>
                {{--<input type="checkbox" name="bao"> 保&emsp;--}}
                <input type="checkbox" name="bao" value="1" <?php if($info->bao==1) echo 'checked' ?>> 保
            </label>
            <label>
                {{--<input type="checkbox" name="piao"> 票--}}
                <input type="checkbox" name="piao" value="1" <?php if($info->piao==1) echo 'checked' ?>> 票&emsp;
            </label>
            <label>
                {{--<input type="checkbox" name="zhun"> 准 &emsp;--}}
                <input type="checkbox" name="zhun" value="1" <?php if($info->zhun==1) echo 'checked' ?>> 准&emsp;
            </label>
        </div>

        <button type="submit" class="btn btn-default">确认修改</button>
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
                server: '{{route("admin.info.upload")}}',

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