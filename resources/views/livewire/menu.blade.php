<div>
    <style>
        body {
            background-color: black;
            color: whitesmoke !important;
        }

        p {
            color: #959595;
        }

        .media-heading {
            color: whitesmoke;
            font-size: 1.3rem;
            margin-top: 5px;
        }

        .page-title h3 {
            color: whitesmoke;
        }

        .page-title h4 {
            color: whitesmoke;
            font-size: 1.1rem;
        }

        .page-title::before {
            background: #157b03;
        }

        #content {
            margin-top: 40px;
        }

        .media {
            margin: 34px 0px 34px 0px;
            /* background: rgba(0, 0, 0, 0.2);
            box-shadow: -2px 0px 5px 3px rgba(202, 202, 202, 0.11);
            -webkit-box-shadow: -2px 0px 5px 3px rgba(202, 202, 202, 0.11);
            -moz-box-shadow: -2px 0px 5px 3px rgba(202, 202, 202, 0.11);

            box-shadow: rgb(202 202 202 / 80%) 0px 8px 34px -25px;*/
        }

        .media img {
            margin-right: 13px;
            border-radius: 2px;
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
                        @foreach ($categories as $category )
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
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
