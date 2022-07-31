<div>
    <div class="container" style="padding: 30px e;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sale Setting
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="updateSale()">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-4">
                                      <select class="form-control" wire:model = "status" >
                                      @if($sale->status == 1)
                                        <option value="{{$sale->status}}" >Active</option>
                                      @else
                                        <option value="{{$sale->status}}" select="selected">Inactive</option>
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Sale Date</label>
                                <div class="col-md-4">
                                    <input type="datetime-local" id="sale-date" value = "{{$sale->sale_date}}" placeholder="{{$sale->sale_date}}" class="form-control input-md" wire:model="sale_date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
$(function(){
    $('#sale-date').datetimepicker({
        
        format:'Y-m-d h:m:s',

    }).on('dp.change',function(ev){
var data = $('#sale-date').val();
      @this.set('sale_date',data);
    });
});


</script>
@endpush