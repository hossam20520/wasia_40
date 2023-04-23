@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.categories.update", [$category->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.category.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $category->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="label">{{ trans('cruds.category.fields.label') }}</label>
                <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text" name="label" id="label" value="{{ old('label', $category->label) }}">
                @if($errors->has('label'))
                    <span class="text-danger">{{ $errors->first('label') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.label_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('isparent') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="isparent" value="0">
                    <input class="form-check-input" type="checkbox" name="isparent" id="isparent" value="1" {{ $category->isparent || old('isparent', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="isparent">{{ trans('cruds.category.fields.isparent') }}</label>
                </div>
                @if($errors->has('isparent'))
                    <span class="text-danger">{{ $errors->first('isparent') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.isparent_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('ischild') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="ischild" value="0">
                    <input class="form-check-input" type="checkbox" name="ischild" id="ischild" value="1" {{ $category->ischild || old('ischild', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ischild">{{ trans('cruds.category.fields.ischild') }}</label>
                </div>
                @if($errors->has('ischild'))
                    <span class="text-danger">{{ $errors->first('ischild') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.ischild_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.category.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="parent_category_id">{{ trans('cruds.category.fields.parent_category') }}</label>
                <select class="form-control select2 {{ $errors->has('parent_category') ? 'is-invalid' : '' }}" name="parent_category_id" id="parent_category_id">
                    @foreach($parent_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('parent_category_id') ? old('parent_category_id') : $category->parent_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('parent_category'))
                    <span class="text-danger">{{ $errors->first('parent_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.category.fields.parent_category_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.categories.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($category) && $category->image)
      var file = {!! json_encode($category->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection