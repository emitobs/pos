<div>

    <style>
        body {
            background-color: black;
        }

        p {
            color: whitesmoke;
        }
    </style>
    <img class="media-object justify-content-center" src="{{asset('assets/img/campobar.PNG')}}" alt="" width="200px"
        style="display: block; margin:auto;">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Menú</h3>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="mail-box-container">
                    <div class="mail-overlay"></div>
                    <div class="tab-title">

                        @foreach ($foods->sortBy('menu_position') as $category )
                        <div class="page-header">
                            <div class="page-title">
                                <h4>{{$category->name}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            @if($category->name == "CROQUETAS")
                            @foreach ($category->products as $product)
                            @if($product->price > 0)
                            <div class="media col-lg-4">
                                <img class="media-object justify-content-center" width="96" height="96"
                                    src="https://campobar.uy/assets/img/campobar.PNG" alt=""
                                    style="object-fit: contain;">
                                <div class="media-body">
                                    <h4 class="media-heading">{{$product->name}}</h4>
                                    <p>{{$product->description}}</p>
                                    <p>${{$product->price}}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-header">
                                        <div class="page-title">
                                            <h4>Sabores de nuestras croquetas</h4>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($category->products as $product)
                                @if($product->price == 0)
                                <div class="media col-lg-4">
                                    <img class="media-object justify-content-center" width="96" height="96"
                                        src="https://campobar.uy/assets/img/campobar.PNG" alt=""
                                        style="object-fit: contain;">
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$product->name}}</h4>
                                        <p>{{$product->description}}</p>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            @else

                            @foreach ($category->products as $product)
                            @if($product->desactivated == 0)
                            <div class="media col-lg-4">
                                <img class="media-object justify-content-center" width="96" height="96"
                                    src="https://campobar.uy/assets/img/campobar.PNG" alt=""
                                    style="object-fit: contain;">
                                <div class="media-body">
                                    <h4 class="media-heading">{{$product->name}}</h4>
                                    <p>{{$product->description}}</p>
                                    <p>${{$product->price}}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach

                            @endif
                        </div>
                        @endforeach

                        @foreach ($drinks->sortBy('menu_position') as $category )
                        <div class="page-header">
                            <div class="page-title">
                                <h4>{{$category->name}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($category->products as $product)
                            @if($product->desactivated == 0)
                            <div class="media col-lg-4">
                                <img class="media-object justify-content-center" width="96" height="96"
                                    src="https://campobar.uy/assets/img/campobar.PNG" alt=""
                                    style="object-fit: contain;">
                                <div class="media-body">
                                    <h4 class="media-heading">{{$product->name}}</h4>
                                    <p>{{$product->description}}</p>
                                    <p>${{$product->price}}</p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
