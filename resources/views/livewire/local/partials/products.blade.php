<div class="row mb-3">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <h5 class="text-center mb-3">PRODUCTOS</h5>
                <div class="connect-sorting-content">
                    <div class="card simple-normal-title-task ui-sorteable-handle">
                        <div class="card-body">
                            <div class="task-header">
                                <div class="row">
                                    <div class="form-inline">
                                        @foreach ($categoriesProducts as $category)
                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-primary">
                                                <input wire:model="category_selected" name="category_selected"
                                                    type="radio" value="{{$category->id}}" class="new-control-input" />
                                                <span class="new-control-indicator"></span>{{$category->name}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @foreach ($products as $product )
                                    <div class="col-4 mb-1">
                                        <a href="javascript:void(0)"
                                            wire:click.prevent="$emit('scan-code', {{$product->barcode}})" title="Ver">
                                            <div class="card component-card_2">

                                                <div class="card-body">
                                                    <h5 class="card-title text-center">{{$product->name}}</h5>
                                                    <p>{{$product->price}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.pos.partials.productform')
