{!! Form::model($post, [
    'route' => $post->id ? ['admin.posts.update', $post] : 'admin.posts.index',
    'method' => $post->id ? 'PUT' : 'POST'
]) !!}

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group @if($errors->first('name')) has-danger @endif">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @if($errors->first('name'))
                <small class="form-control-feedback">{{ $errors->first('name') }}</small>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group @if($errors->first('slug')) has-danger @endif">
                {!! Form::label('slug', 'Slug') !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                @if($errors->first('slug'))
                    <small class="form-control-feedback">{{ $errors->first('slug') }}</small>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group @if($errors->first('category_id')) has-danger @endif">
                {!! Form::label('category_id', 'Category') !!}
                {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'required' => 'required']) !!}
                @if($errors->first('category_id'))
                    <small class="form-control-feedback">{{ $errors->first('category_id') }}</small>
                @endif
            </div>
        </div>
        @can('changeOwner',$post)
        <div class="col-sm-6">
            <div class="form-group @if($errors->first('user_id')) has-danger @endif">
                {!! Form::label('user_id', 'User') !!}
                {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'required' => 'required']) !!}
                @if($errors->first('user_id'))
                    <small class="form-control-feedback">{{ $errors->first('user_id') }}</small>
                @endif
            </div>
        </div>
        @endcan

        <div id="privatePost" class="col-sm-6">
            <div class="form-group @if($errors->first('private')) has-danger @endif">
                <label>
                    {!! Form::checkbox('private',1,$post->private) !!}
                    Private
                </label>
                @if($errors->first('private'))
                <small class="form-control-feedback">{{ $errors->first('private') }}</small>
                @endif
            </div>
        </div>

    </div>
    <script src="{{ URL::to('tinymce/js/tinymce/tinymce.min.js') }}"></script>

<div class="input-group">
    <span class="input-group-btn">
         <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
           <i class="fa fa-picture-o"></i> Choose
         </a>
    </span>
    <input id="thumbnail" class="form-control" type="text" name="filepath">
</div>
 <img id="holder" style="margin-top:15px;max-height:100px;">
<script src="{{ URL::to('vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <div class="form-group @if($errors->first('content')) has-danger @endif">
        {!! Form::label('content', 'Content') !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required']) !!}
        @if($errors->first('content'))
            <small class="form-control-feedback">{{ $errors->first('content') }}</small>
        @endif
    </div>
<script> 
var domain = "{{ URL::to('/') }}/laravel-filemanager";
 $('#lfm').filemanager('image', {prefix: domain});
/*var editor_config = {
        branding: false,//'<a href="https://nextweb.ch" target="_blank">nextweb.ch</a>',
        path_absolute : "{{ URL::to('/') }}/",
        selector: "textarea",
        plugins: [
            "autolink lists link image anchor pagebreak",
            "nonbreaking save",
            "emoticons paste textcolor textpattern youtube",
            "link image"
        ],
        menubar: true,
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image youtube",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            });
        }
    };*/
var editor_config = {
    path_absolute : "{{ URL::to('/') }}/",
    selector: "textarea",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };
    tinymce.init(editor_config);
</script>
    {!! Form::submit($post->id ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}