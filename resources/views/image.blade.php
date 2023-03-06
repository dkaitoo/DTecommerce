<a href="#">
@if($image)
    <img id="preview" src="{{ url('/assets/uploads/category/'.$image) }}" alt="Preview" class="form-group hidden" width="50" height="50">
@else
    <img id="preview" src="{{ url('/img/default_category.jpg') }}" alt="Preview" class="form-group hidden" width="50" height="50">
@endif
</a>
