@extends('layouts.theme.app')

@section('content')
<div class="row justify-content-around">
    {{-- CONFIG DASHBOARD STYLES --}}
    <div class="col-4 shadow-lg p-2 contentConfig rounded mb-4">
        <div style="margin-top: 10px;">
            <h4>Configuracion de Dashboard</h4>
        </div>
        <div class="">
            @livewire('color-picker', ['element' => 'navbar_background', 'color' => getNavbarBackground()])
            @livewire('color-picker', ['element' => 'navbar_color', 'color' => getNavbarColor()])
            @livewire('color-picker', ['element' => 'sidebar_background', 'color' => getSidebarBackground()])
            @livewire('color-picker', ['element' => 'sidebar_icos_color', 'color' => getSidebarIconsColor()])
            @livewire('color-picker', ['element' => 'sidebar_color', 'color' => getSidebarColor()])
            @livewire('color-picker', ['element' => 'bodyBackground', 'color' => getBodyBackground()])
            @livewire('color-picker', ['element' => 'contentConfig', 'color' => getContentConfig()])
        </div>
    </div>
    {{-- CONFIG TABLES STYLES --}}
    <div class="col-6 shadow-lg p-2 contentConfig rounded mb-4">
        <div style="margin-top: 10px;">
            <h4>Configuracion de Tablas</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-7">
                @livewire('color-picker', ['element' => 'tableHeadColor', 'color' => getTableHeadColor()])
                @livewire('color-picker', ['element' => 'tableHeadTextColor', 'color' => getTableHeadTextColor()])
                @livewire('color-picker', ['element' => 'tableBodyColor', 'color' => getTableBodyColor()])
                @livewire('color-picker', ['element' => 'tableTextColor', 'color' => getTableTextColor()])
            </div>
            <div class="col-5">
                <div class="table-responsive">
                    <table class="table table-bordered tableBodyColor mt-1">
                        <thead class="tableHeadColor">
                            <tr>
                                <th class="table-th tableHeadTextColor ">Nº</th>
                                <th class="table-th tableHeadTextColor text-center">Nombre</th>
                                <th class="table-th tableHeadTextColor text-center">Ciudad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h6 class="tableTextColor">1</h6>
                                </td>
                                <td>
                                    <h6 class="tableTextColor">Joe Doe</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="tableTextColor">Los Angeles</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="tableTextColor">2</h6>
                                </td>
                                <td>
                                    <h6 class="tableTextColor">Angelina Jolie</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="tableTextColor">Amsterdam</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="tableTextColor">1</h6>
                                </td>
                                <td>
                                    <h6 class="tableTextColor">Julian Arregui</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="tableTextColor">Uruguay</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- EDICION MODAL PAYROLLS --}}
    <div class="col-11 shadow-lg p-2 contentConfig rounded mb-4">
        <div style="margin-top: 10px;">
            <h4>Configuracion de Modal</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                @livewire('color-picker', ['element' => 'bgPayrollModalHeaderColor', 'color' =>
                getBgPayrollModalHeaderColor()])
                @livewire('color-picker', ['element' => 'textPayrollModalHeaderTextColor', 'color' =>
                getTextPayrollModalHeaderTextColor()])
                @livewire('color-picker', ['element' => 'bgPayrollModalBodyColor', 'color' =>
                getBgPayrollModalBodyColor()])
                @livewire('color-picker', ['element' => 'bgPayrollModalContainerColor', 'color' =>
                getBgPayrollModalContainerColor()])
                @livewire('color-picker', ['element' => 'bgPayrollModalInfoContainerColor', 'color' =>
                getBgPayrollModalInfoContainerColor()])
                @livewire('color-picker', ['element' => 'payrollModalInfoContainerTextColor', 'color' =>
                getPayrollModalInfoContainerTextColor()])
                @livewire('color-picker', ['element' => 'payrollModalInfoContainerTextTableColor', 'color' =>
                getPayrollModalInfoContainerTextTableColor()])
                @livewire('color-picker', ['element' => 'payrollModalInfoContainerbodyColor', 'color' =>
                getPayrollModalInfoContainerbodyColor()])
            </div>
            <div class="col-6">
                <div class="modal-content ">
                    <div class="modal-header bgPayrollModalHeaderColor">
                        <h5 class="modal-title textPayrollModalHeaderTextColor">
                            Planilla Nº 9 | Detalles
                        </h5>
                        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
                    </div>
                    <div class="modal-body bgPayrollModalBodyColor">
                        <div class="row mb-3">
                            <div class="col-12 ">
                                <div class="card bgPayrollModalContainerColor">
                                    <div class="card-body">
                                        <h5 class="card-title">Fecha: 10-01-1992</h5>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="card ">
                                                    <div class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                                        <h5 class="mb-3 payrollModalInfoContainerTextColor">Cobros 6
                                                        </h5>
                                                        <div class="row ">
                                                            <div class="col-12 col-md-6">
                                                                <div class="card payrollModalInfoContainerbodyColor">
                                                                    <div class="card-body">
                                                                        <h5
                                                                            class="card-title mb-3 payrollModalInfoContainerTextColor">
                                                                            Local</h5>
                                                                        <table
                                                                            class="table payrollModalInfoContainerTextTableColor">
                                                                            <tr>
                                                                                <th>Metodo de pago</th>
                                                                                <th>Pedidos</th>
                                                                                <th>Recaudo</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Efectivo</td>
                                                                                <td>2</td>
                                                                                <td>$500</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Transferencia</td>
                                                                                <td>1</td>
                                                                                <td>$250</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Handy</td>
                                                                                <td>1</td>
                                                                                <td>$250</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h5
                                                                            class="card-title mb-3 payrollModalInfoContainerTextColor">
                                                                            El Gino
                                                                        </h5>
                                                                        <table
                                                                            class="table payrollModalInfoContainerTextTableColor">
                                                                            <tr>
                                                                                <th>Metodo de pago</th>
                                                                                <th>Pedidos</th>
                                                                                <th>Recaudo</th>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Efectivo</td>
                                                                                <td>2</td>
                                                                                <td>$660</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark close-btn text-info"
                                data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--COLOR CARD --}}

    <div class="col-11 shadow-lg p-2 contentConfig rounded mb-4">
        <div style="margin-top: 10px;">
            <h4>Configuracion de Modal</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-7">
                @livewire('color-picker', ['element' => 'bgCardColor', 'color' =>
                getBgPayrollModalHeaderColor()])

            </div>

        </div>

        <div class="row">
            <div class="col-3">
                <div class="connect-sorting-content">
                    <div class="card simple-normal-title-task ui-sorteable-handle">
                        <div class="card-body">
                            <div class="task-header">
                                <div class="form-row">
                                    <div class="col-12">
                                        <div wire:ignore="">
                                            <select id="search_client" class="select-client select2-hidden-accessible"
                                                wire:model="searched_client" name=""
                                                data-select2-id="select2-data-search_client" tabindex="-1"
                                                aria-hidden="true"></select><span
                                                class="select2 select2-container select2-container--default" dir="ltr"
                                                data-select2-id="select2-data-4-q5q4" style="width: 24px;"><span
                                                    class="selection"><span
                                                        class="select2-selection select2-selection--single"
                                                        role="combobox" aria-haspopup="true" aria-expanded="false"
                                                        tabindex="0" aria-disabled="false"
                                                        aria-labelledby="select2-search_client-container"
                                                        aria-controls="select2-search_client-container"><span
                                                            class="select2-selection__rendered"
                                                            id="select2-search_client-container" role="textbox"
                                                            aria-readonly="true" title="Buscar cliente"><span
                                                                class="select2-selection__placeholder">Buscar
                                                                cliente</span></span><span
                                                            class="select2-selection__arrow" role="presentation"><b
                                                                role="presentation"></b></span></span></span><span
                                                    class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="form mt-4">
                                                <div class="form-group mb-4">
                                                    <input type="number" class="form-control" wire:model="telephone"
                                                        id="rtelephone" placeholder="Teléfono" required="">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="text" class="form-control" wire:model="client"
                                                        id="rClientName" placeholder="Cliente" required="">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="text" class="form-control" wire:model="address"
                                                        id="rAdress" placeholder="Dirección" required="">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input type="time" class="form-control" wire:model="deliveryTime"
                                                        id="rDeliveryTime" placeholder="Hora de entrega" required="">
                                                </div>
                                                <div class="input-group mb-4">
                                                    <textarea wire:model="clarifications" class="form-control"
                                                        placeholder="Aclaraciones" aria-label="Aclaraciones"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-5">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="connect-sorting-content">
                            <div class="card simple-normal-title-task ui-sorteable-handle">
                                <div class="card-body">
                                    <div class="task-header">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <div class="form-group mb-2" wire:ignore="">
                                                    <select id="selected_product" wire:model="select_product"
                                                        class="form-control select2-hidden-accessible"
                                                        data-select2-id="select2-data-selected_product" tabindex="-1"
                                                        aria-hidden="true">


                                                    </select><span
                                                        class="select2 select2-container select2-container--default"
                                                        dir="ltr" data-select2-id="select2-data-3-6noy"
                                                        style="width: 661.328px;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0" aria-disabled="false"
                                                                aria-labelledby="select2-selected_product-container"
                                                                aria-controls="select2-selected_product-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-selected_product-container"
                                                                    role="textbox" aria-readonly="true"
                                                                    title="Buscar producto"><span
                                                                        class="select2-selection__placeholder">Buscar
                                                                        producto</span></span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b role="presentation"
                                                                        style="color: rgb(255, 255, 255);"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span><input type="number"
                                                        id="quantity" wire:model="quantity" placeholder="Cantidad"
                                                        class="form-control mt-2">
                                                </div>
                                                <div class="form-group">
                                                    <textarea wire:model="detail" name="" id="" cols="30" rows="4"
                                                        class="form-control" placeholder="Detalle"></textarea>
                                                </div>
                                                <input wire:click="ScanCode" type="button" class="btn btn-primary"
                                                    value="Agregar al pedido">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <style>
                    .quantity {
                        position: relative;
                        display: flex;
                        align-items: center;
                    }

                    .quantity-buttons {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-right: 10px;
                    }

                    .input-quantity {
                        width: 45px;
                        height: 42px;
                        line-height: 1.65;
                        padding-left: 20px;
                        border: 1px solid #eee;
                    }

                    .quantity-button {
                        cursor: pointer;
                        border: none;
                        background: none;
                        color: #333;
                        font-size: 13px;
                        font-family: "Trebuchet MS", Helvetica, sans-serif !important;
                        line-height: 1.7;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        -o-user-select: none;
                        user-select: none;
                        padding: 0;
                        margin-bottom: 5px;
                    }

                    .quantity-button.quantity-up {
                        margin-bottom: 0;
                    }

                    .quantity-button {
                        display: inline-block;
                        background-color: #f8f9fa;
                        color: #333;
                        text-align: center;
                        font-size: 16px;
                        padding: 10px;
                        border-radius: 50%;
                        width: 30px;
                        height: 30px;
                        border: none;
                        transition: background-color 0.3s ease;
                        line-height: 10px;
                        /* ajustar si es necesario */
                    }

                    .quantity-button:hover {
                        background-color: #e2e6ea;
                        cursor: pointer;
                    }

                    .quantity-up {
                        margin-bottom: 5px;
                    }

                    .quantity-down {
                        margin-top: 5px;
                    }
                </style>
                <div style="min-height: 30vh; max-height: 30vh; overflow-y:auto;">
                    <div class="card simple-title-task ui-sorteable-handle">
                        <div class="card-body">
                            Articulos: 0
                            <h5 class="text-center text-muted">Agrega productos a la venta</h5>

                            <div wire:loading.inline="" wire:target="saveSale">
                                <h4 class="text-danger text-center">Guardando Venta...</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="connect-sorting-content mt-4">
                        <div class="card simple-title-task ui-sortable-handle">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mb-3">
                                    </div>
                                </div>
                                <div class="input-group input-group-md mb-3">
                                    <div class="input-group-prepend" style="min-width: 133px;">
                                        <span class="input-group-text input-gp hideonsm"
                                            style="background: #3b3f5c; color:white;  min-width: 133px;">
                                            Descuento F7
                                        </span>
                                    </div>
                                    <input type="number" id="discount" wire:model="discount"
                                        class="form-control text-center" value="0">
                                    <div class="input-group-append">
                                        <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                                            style="background: #3b3f5c; color:white;">
                                            <i class=" fas fa-backspace fa-2x"></i>
                                        </span>
                                    </div>
                                </div>

                                <div id="cash_data">
                                    <ul class="ul-money-detail">
                                        <li>
                                            <h2>TOTAL: $0</h2>
                                        </li>
                                    </ul>
                                </div>
                                <div class="row justify-content-between mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <button id="save_colors" class="btn btn-primary" disabled wire:click='saveColors'>Guardar</button>
</div>


@endsection


@push('scripts')
<script>
    $(document).ready(function() {

    });
    $('input[type="color"]').on('input', function() {
            $("#save_colors").attr("disabled", false);
            let color = $(this).val();
            let targetElement = $(this).attr('id'); // Asume que el ID del input coincide con la clase del elemento que quieres cambiar
            switch(targetElement){
                case 'navbar_background':
                $('#navbar-header').css('background-color', color);
                setTextLogoColor();
                break;
                case 'navbar_color':
                $('#navbar-header p').css('color', color);
                break;
                case 'sidebar_background':
                $('#compactSidebar').css('background-color', color);
                break;
                case 'sidebar_icos_color':
                $('.sidebar-wrapper #compactSidebar .menu-categories a.menu-toggle .base-icons svg').css('color', color);
                break;
                case 'sidebar_color':
                $('.sidebar-wrapper #compactSidebar .menu-categories a.menu-toggle .base-menu span').css('color', color);
                break;
                case 'bodyBackground':
                $('body').css('background-color', color);
                break;
                case 'contentConfig':
                $('.contentConfig').css('background-color', color);
                break;
                case 'tableHeadTextColor':
                $('.tableHeadTextColor').css('color', color);
                break;
                case 'tableHeadColor':
                $('.tableHeadColor').css('background-color', color);
                break;
                case 'tableTextColor':
                $('.tableTextColor').css('color', color);
                break;
                case 'tableBodyColor':
                $('.tableBodyColor').css('background-color', color);
                break;
                case 'bgPayrollModalHeaderColor':
                $('.bgPayrollModalHeaderColor').css('background-color', color);
                break;
                case 'textPayrollModalHeaderTextColor':
                $('.textPayrollModalHeaderTextColor').css('color', color);
                break;
                case 'bgPayrollModalBodyColor':
                $('.bgPayrollModalBodyColor').css('background-color', color);
                break;
                case 'bgPayrollModalContainerColor':
                $('.bgPayrollModalContainerColor').css('background-color', color);
                break;
                case 'bgPayrollModalInfoContainerColor':
                $('.bgPayrollModalInfoContainerColor').css('background-color', color);
                break;
                case 'payrollModalInfoContainerTextColor':
                $('.payrollModalInfoContainerTextColor').css('color', color);
                break;
                case 'payrollModalInfoContainerTextTableColor':
                $('.payrollModalInfoContainerTextTableColor').css('color', color);
                break;
                case 'payrollModalInfoContainerbodyColor':
                $('.payrollModalInfoContainerbodyColor').css('background-color', color);
                break;
            }
        });

    document.addEventListener('livewire:load', function () {
    $("#save_colors").click(function(){
        $("#save_colors").attr("disabled", true);
        Livewire.emit('saveColors');
    });
    Livewire.on('colors-saved', (element) => {
    noty('Color for ' + element + ' was saved!')
})
});


</script>

@endpush
