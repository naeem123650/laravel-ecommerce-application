@extends('admin.app')

@section('title')
    Edit Attributes
@endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cogs"></i> {{ $pageTitle }}</h1>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row user">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">Attribute</a></li>
                    <li class="nav-item"><a class="nav-link" href="#attribute_values" data-toggle="tab">Attribute Values</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">
                        <form action="{{ route('admin.attributes.update') }}" method="POST" role="form">
                            @csrf
                            @method('put')
                            <h3 class="tile-title">Attribute Information</h3>
                            <hr>
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="code">Code</label>
                                    <input type="hidden" name="id" value={{ $targetAttribute->id }}>
                                    <input
                                        class="form-control @error('code') is-invalid @enderror"
                                        type="text"
                                        placeholder="Enter attribute code"
                                        id="code"
                                        name="code"
                                        value="{{ old('code',$targetAttribute->code) }}"

                                    />
                                    @error('code') <span class="text-danger"> {{ $message }} </span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Name</label>
                                    <input
                                        class="form-control @error('name') is-invalid @enderror"
                                        type="text"
                                        placeholder="Enter attribute name"
                                        id="name"
                                        name="name"
                                        value="{{ old('name',$targetAttribute->name) }}"
                                    />
                                    @error('name') <span class="text-danger"> {{ $message }} </span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="frontend_type">Frontend Type</label>
                                    @php $types = ['select' => 'Select Box', 'radio' => 'Radio Button', 'text' => 'Text Field', 'textarea' => 'Text Area']; @endphp
                                    <select name="frontend_type" id="frontend_type" class="form-control">
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" {{ $targetAttribute->frontend_type == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="is_filterable" name="is_filterable"  @checked(old('is_filterable',$targetAttribute->is_filterable))/>Filterable
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required" @checked(old('is_required',$targetAttribute->is_required))/>Required
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Attribute</button>
                                        <a class="btn btn-danger" href="{{ route('admin.attributes.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="attribute_values">
                    <div class="tile">
                        <form action="{{ route('admin.attributevalue.store',request()->id) }}" method="POST" role="form" id="attributeFormId">
                            @csrf
                            <h3 class="tile-title">Attribute Values</h3>
                            <hr>
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="code">Value</label>
                                    <input
                                        class="form-control @error('value') is-invalid @enderror"
                                        type="text"
                                        placeholder="Enter attribute code"
                                        id="value"
                                        name="value"
                                        value="{{ old('value') }}"
                                    />
                                    @error('value') <span class="text-danger"> {{ $message }} </span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Price</label>
                                    <input
                                        class="form-control @error('price') is-invalid @enderror"
                                        type="text"
                                        placeholder="Enter attribute price"
                                        id="price"
                                        name="price"
                                        value="{{ old('price') }}"
                                    />
                                    @error('price') <span class="text-danger"> {{ $message }} </span> @enderror
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="innerTextAttributeValue">Save Attribute<span></button>
                                        <a class="btn btn-danger" href="{{ route('admin.attributes.index') }}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th> Value </th>
                                        <th class="text-center"> Price </th>
                                        <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attributeValues as $attributeValue)
                                        <tr>
                                            <td>{{ $attributeValue->value }}</td>
                                            <td class="text-center">
                                                @if ($attributeValue->price != null)
                                                    <span >{{ $attributeValue->price }}</span>
                                                @else
                                                    <span class="badge badge-success">Free</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="Second group">
                                                    <a href="javascript:void(0)" onclick="editForm(<?php echo $attributeValue->id ?>)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.attributevalue.delete', $attributeValue->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script type="text/javascript">
        $(document).ready(function(){
            editForm = (id) => {
                $("#innerTextAttributeValue").text("Update Attribute");
                $("#attributeFormId").attr("action",`http://127.0.0.1:8000/admin/attributes/attribute/${id}/update`);

                $.ajax({
                    type:'GET',
                    url: `http://127.0.0.1:8000/admin/attributes/attribute/${id}/edit`,
                    data:{'attribute_id': id},
                    success: function(data){
                        $("#value").val(data.value);
                        $("#price").val(data.price);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            };
        });
    </script>
@endpush
