<div class="container" style="padding: 30px e;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Mange Home Categories
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="updateHomeCategory()">

                          <div class="form-group">
                                <label class="col-md-4 control-label">Choose Category</label>
                                <div class="col-md-4" wire:ignore>
                                    <select class="sel-categories form-control" name ="categories[]" multiple="multiple" wire:model = "selected_categories" >
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" > {{$category->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">No Of Products</label>
                                <div class="col-md-4">
                                    <input type="text" placeholder="Number Of Products" class="form-control input-md" wire:model="numberofproducts" />
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function(){
    $('.sel-categories').select2();
    $('.sel-categories').on('change',function(e){
        var data = $('.sel-categories').select2("val");
        @this.set('selected_categories',data);
    })
});
</script>
@endpush