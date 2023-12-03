<div>
    <style>
        body {
            background-color: black;
        }

        p {
            color: whitesmoke;
        }
    </style>
    <img class="media-object justify-content-center" src="{{asset(getLogo())}}" alt="" width="200px"
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
                        @foreach ($categories->sortBy('menu_position') as $category )
                        <div class="page-header">
                            <div class="page-title">
                                <h4>{{$category->name}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($category->products->where('desactivated',0)->where('inWebMenu',1)->sortBy('menu_position')
                            as $product)
                            @if($product->desactivated == 0)
                            <div class="media col-lg-4">
                                @if($product->image == null)
                                <img class="media-object justify-content-center" width="96" height="96"
                                    src={{asset(getLogo())}} alt="" style="object-fit: contain;">
                                @else
                                <img class="media-object justify-content-center" width="96" height="96" src={{
                                    asset('storage/products/' . $product->image) }} alt=""
                                style="object-fit: contain;">
                                @endif
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
