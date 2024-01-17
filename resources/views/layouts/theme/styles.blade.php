<link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

<link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
<script src="{{asset('assets/js/loader.js')}}"></script>


<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/structure.css')}}" rel="stylesheet" type="text/css" class="structure" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<link href="{{asset('assets/css/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" class="dashboard-sales" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<link rel="stylesheet" href="{{asset('assets/css/apps/scrumboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('assets/css/apps/notes.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/widgets/modules-widgets.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/components/cards/card.css')}}">

<style>
    h1 {
        font-size: 14px;
    }

    .table td,
    .table th {
        padding: 0;
    }

    .available {
        background-color: #5ae21b;
    }

    .busy {
        background-color: #e21b3c;
    }

    .pointer {
        cursor: pointer !important;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .orderline {
        width: 100%;
        margin: 0px;
        padding-top: 3px;
        padding-bottom: 10px;
        padding-left: 15px;
        padding-right: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: background 250ms ease-in-out;
        -moz-transition: background 250ms ease-in-out;
        transition: background 250ms ease-in-out;
    }

    li {
        list-style-type: none;
    }

    .orderlines {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .product-name {
        padding: 0;
        display: inline-block;
        font-weight: bold;
        width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-list {
        color: #888;
    }

    .price {
        padding: 0;
        font-weight: bold;
        float: right;
        color: #555555;
    }

    em {
        color: #777;
        font-weight: bold;
        font-style: normal;
    }

    ul .info-list {
        padding-left: 13px;
    }

    .discount {
        color: #555555;
        padding: 3px;
        box-sizing: border-box;
        border-radius: 50%;
    }

    .discount i {
        color: #fff;
    }

    .products-container {
        max-height: 350px;
        overflow-y: auto;
    }

    .orderline {
        width: 100%;
        margin: 0px;
        padding-top: 3px;
        padding-bottom: 10px;
        padding-left: 15px;
        padding-right: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: background 250ms ease-in-out;
        -moz-transition: background 250ms ease-in-out;
        transition: background 250ms ease-in-out;
    }

    li {
        list-style-type: none;
    }

    .orderlines {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .product-name {
        padding: 0;
        display: inline-block;
        font-weight: bold;
        width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-list {
        color: #888;
    }

    .price {
        padding: 0;
        font-weight: bold;
        float: right;
        color: #555555;
    }

    em {
        color: #777;
        font-weight: bold;
        font-style: normal;
    }

    ul .info-list {
        padding-left: 13px;
    }

    .discount {
        color: #555555;
        padding: 3px;
        box-sizing: border-box;
        border-radius: 50%;
    }

    .discount i {
        color: #fff;
    }

    .products-container {
        max-height: 350px;
        overflow-y: auto;
    }

    .orderline {
        width: 100%;
        margin: 0px;
        padding-top: 3px;
        padding-bottom: 10px;
        padding-left: 15px;
        padding-right: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: background 250ms ease-in-out;
        -moz-transition: background 250ms ease-in-out;
        transition: background 250ms ease-in-out;
    }

    li {
        list-style-type: none;
    }

    .orderlines {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .product-name {
        padding: 0;
        display: inline-block;
        font-weight: bold;
        width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-list {
        color: #888;
    }

    .price {
        padding: 0;
        font-weight: bold;
        float: right;
        color: #555555;
    }

    em {
        color: #777;
        font-weight: bold;
        font-style: normal;
    }

    ul .info-list {
        padding-left: 13px;
    }

    .discount {
        color: #555555;
        padding: 3px;
        box-sizing: border-box;
        border-radius: 50%;
    }

    .discount i {
        color: #fff;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .ul-money-detail {
        padding: 0;
        margin-top: 5px;
    }

    @media (max-width: 1236px) {
        header {
            max-height: 40px;
        }
    }

    .pointer {
        cursor: pointer;
    }

    .buscador {
        border-radius: 10px;
        box-shadow: 0 4px 6px 0 rgb(85 85 85 / 8%), 0 1px 20px 0 rgb(0 0 0 / 7%), 0px 1px 11px 0px rgb(0 0 0 / 7%);
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
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

    .ul-money-detail {
        padding: 0;
        margin-top: 5px;
    }

    @media (max-width: 1236px) {
        header {
            max-height: 40px;
        }
    }

    .pointer {
        cursor: pointer;
    }

    .buscador {
        border-radius: 10px;
        box-shadow: 0 4px 6px 0 rgb(85 85 85 / 8%), 0 1px 20px 0 rgb(0 0 0 / 7%), 0px 1px 11px 0px rgb(0 0 0 / 7%);
    }

    aside {
        display: none !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color: #3b3f5c;
    }

    @media(max-width: 480px) {
        .mtmobile {
            margin-bottom: 20px !important;
        }

        .mbmobile {
            margin-bottom: 10px !important;
        }

        .hideonsm {
            display: none !important;
        }

        .inblock {
            display: block;
        }
    }

    .sidebar-theme #compactSidebar {
        background: #047439;
    }

    .header-container .sidebarCollapse {
        color: #199;
    }

    .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
        font-size: 15px;
        background-color: rgba(255, 204, 102, 0.901961);
        padding-right: 40px;
        padding-top: 12px;
        border: none;
        color: #3b3f5c;
        box-shadow: none;
        border-radius: 30px;
    }
</style>

{{-- Opciones para configurar --}}
<style>
    body {
        background-color: {{getBodyBackground()}};
    }
    .contentConfig{
        background-color: {{getContentConfig()}};
    }
    h1 {
        color: white;
    }

    h2 {
        color: white;
    }

    h3 {
        color: white;
    }

    h4 {
        color: white;
    }

    h5 {
        color: white;
    }

    h6 {
        color: white;
    }

    .navbar {
        background: {{getNavbarBackground()}};
    }

    #navbar-header p {
        color: {{getNavbarColor()}};
    }

    .modal-content {
        background: rgb(68, 70, 84);
    }

    .sidebar-theme #compactSidebar {
        background-color: {{getSidebarBackground()}};
    }

    /* Color iconos sidebar */

    .sidebar-wrapper #compactSidebar .menu-categories a.menu-toggle .base-icons svg {
        color: {{getSidebarIconsColor()}}
    }


    /* Color de la fuente del menu sidebar */
    .sidebar-wrapper #compactSidebar .menu-categories a.menu-toggle .base-menu span {
        color: {{getSidebarColor()}}
    }

    .card{
       background-color: rgb(32, 33, 35);
    }
    .card .payrollModalInfoContainerbodyColor{
       background-color: {{getPayrollModalInfoContainerbodyColor()}};
    }

    .form-control {
        background-color: rgb(68, 70, 84);
        color: white;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        background-color: rgb(68, 70, 84);
        color: white;
    }

    .select2-dropdown {
        background-color: rgb(68, 70, 84);
        color: white;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        color: white;
    }

    .btn-primary {
        background-color: #4361ee;
    }

    .tableHeadTextColor {
        color:{{getTableHeadTextColor()}}
    }

    .tableHeadColor{
        background-color:{{getTableHeadColor()}}
    }

    .tableTextColor{
        color:{{getTableTextColor()}}
    }

    .tableBodyColor{
        background-color:{{getTableBodyColor()}}
    }

    .bgPayrollModalHeaderColor{
        background-color:{{getBgPayrollModalHeaderColor()}}
    }

    .textPayrollModalHeaderTextColor{
        color:{{getTextPayrollModalHeaderTextColor()}}
    }

    .bgPayrollModalBodyColor{
        background-color:{{getBgPayrollModalBodyColor()}}
    }

    .bgPayrollModalContainerColor{
        background-color:{{getBgPayrollModalContainerColor()}}
    }

    .widget .widget-account-invoice-one .bgPayrollModalInfoContainerColor{
        background-color:{{getBgPayrollModalInfoContainerColor()}};
    }

    .payrollModalInfoContainerTextColor{
        color:{{getPayrollModalInfoContainerTextColor()}};
    }

    .payrollModalInfoContainerTextTableColor, .payrollModalInfoContainerTextTableColor tr td {
        color: {{getPayrollModalInfoContainerTextTableColor()}};
    }

</style>

@livewireStyles
