<div>
    <style>
        nav svg {
            height: 20px;
        }

        nav .hidden {
            display: block !important;
        }
        }
        .sclist{
            list-style:none;
        }
        .sclist li{
            line-height: 33px;
            border-bottom: 1px solid #ccc;
            }
    </style>
    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                All Attributes
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.addattribute') }}" class="btn btn-success pull-right">Add New</a>
                            </div>
                        </div>
                        </div>
                        <div class="panel-body">
                             @if (Session::has('message'))
                                <div class="alert alert-success">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Attribute Name</th>
                                        <th>Created_at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attributes as $attribute)
                                        <tr>
                                            <td>{{ $attribute->id }}</td>
                                            <td>{{ $attribute->name }}</td>
                                            <td>{{ $attribute->created_at }}</td>
                                            
                                            <td>
                                               <a href="{{route('admin.editattribute', ['attribute_id'=>$attribute->id])}}"><i class="fa fa-edit fa-2x"></i></a>
                                                <a href="#" onclick="confirm('are you sure that you want delete this item ?')||event.stopimmediatepropagation()" wire:click.prevent="deleteAttribute({{$attribute->id}})" style="margin-left:10px; "><i class="fa fa-times fa-2x text-danger"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $attributes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
