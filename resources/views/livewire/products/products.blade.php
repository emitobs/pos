<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">Descripcion</th>
                                <th class="table-th text-white text-center">Cod Barras</th>
                                <th class="table-th text-white text-center">Categoría</th>
                                <th class="table-th text-white text-center">Precio</th>
                                <th class="table-th text-white text-center">Stock</th>
                                <th class="table-th text-white text-center">Inv. min</th>
                                <th class="table-th text-white text-center">Imagen</th>
                                <th class="table-th text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                            <tr>
                                <td>
                                    <h6>{{$product->name}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$product->barcode}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$product->category}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$product->price}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$product->stock}}</h6>
                                </td>
                                <td>
                                    <h6 class="text-center">{{$product->alerts}}</h6>
                                </td>

                                <td class="text-center">
                                    <span>
                                        <img src="{{asset('storage/products/' . $product->imagen)}}"
                                            alt="{{$product->name}}" height="70" width="80" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click.prevent="Edit({{$product->id}})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{$product->id}}')"
                                        class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-deleted', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display','none');
        });
    });

    function Confirm(id, products){
swal({
    title : 'CONFIRMAR',
    text : '¿Confirmas eliminar el registro?',
    type: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Cerrar',
    cancelButtonColor: '#fff',
    confirmButtonColor: '#3b3f5c',
    confirmButtonText: 'Aceptar'
}).then(function(result){
    if(result.value){
        window.livewire.emit('deleteRow',id);
        swal.close();
    }
});
}
</script>
