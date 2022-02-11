<style>
    .products-container {
        max-height: 350px;
        overflow-y: auto;
    }
</style>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="connect-sorting-content">
            <div class="card simple-normal-title-task ui-sorteable-handle">
                <div class="card-body">
                    <div class="task-header">
                        <div class="row">
                            <div class="col">
                                @include('common.searchbox')
                                @if(strlen($search) > 0)
                                <div wire:loading class="rounded-t-none shadow-lg list-group">
                                    <div class="list-item">Buscando...</div>
                                </div>

                                {{$searched_products->count()}}
                                <ul class="list-group">
                                    {{-- @foreach ($searched_products as $product)
                                    <li class="list-group-item"
                                        wire:click.prevent="$emit('select_product', {{$product->barcode}})">
                                        Producto: <b>{{$product->name}}</b> &nbsp; Precio: <b>${{$product->price}}</b>{{$product->unitSale->unit}}
                                    </li>

                                    @endforeach --}}
                                </ul>

                                @endif
                            </div>
                        </div>
                        @if(strlen($search) == 0)
                        <div class="row">
                            <div class="form-inline">
                                @foreach ($categoriesProducts as $category)
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-primary">
                                        <input wire:model="category_selected" name="category_selected" type="radio"
                                            value="{{$category->id}}" class="new-control-input" />
                                        <span class="new-control-indicator"></span>{{$category->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="row products-container">
                            @foreach ($products as $product )
                            <div class="col-6 mb-1">
                                <a href="javascript:void(0)"
                                    wire:click.prevent="$emit('select_product', {{$product->barcode}})" title="Ver">
                                    <div class="card component-card_2">

                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{$product->name}}
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.pos.partials.productform')
