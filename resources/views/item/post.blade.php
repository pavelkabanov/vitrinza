<!-- Modal -->
<div class="modal fade" id="create_item" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Добавление вещи</h4>
            </div>
            <form action="{{ route('item.create') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="item_name">Название вещи:</label>
                        <input type="text" name="name" class="form-control" id="item_name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="item_description">Описание вещи:</label>
                        <textarea name="description" class="form-control" rows="2" id="item_description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="category">Категория:</label>
                        <select class="form-control" id="category" name="category">
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected':'' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                        <label for="item_link">Сайт, на котором можно купить вещь:</label>
                        <input type="text" name="link" class="form-control" id="item_link" placeholder="укажите ссылку" value="{{ old('link') }}">
                        @if ($errors->has('link'))
                            <span class="help-block">
                                <strong>{{ $errors->first('link') }}</strong>
                            </span>
                        @endif
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('myimage') ? ' has-error' : '' }}">
                            <div style="width: 160px; margin: 0 auto;">
                            <label for="item_image">Изображение вещи:</label>
                            <div id="imageDiv">
                                <img id="uploadPreview" style="max-width: 148px; max-height: 148px; display: none;" />
                                <a href="#" id="imageLink"><span>Нажмите или перетащите сюда изображение</span></a>
                                <input type="file" id="uploadImage" name="myimage" onchange="coverImage()">
                              
                            </div>
                            @if ($errors->has('myimage'))
                            <span class="help-block">
                                <strong>{{ $errors->first('myimage') }}</strong>
                            </span>
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Опубликовать</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
      
    </div>
</div>

<!-- End Modal -->
                            