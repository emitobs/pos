<div>
    <style>

    </style>

    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-4">
            @include('livewire.local.partials.products')
        </div>
        <div class="col-sm-12 col-md-5">
            @include('livewire.local.partials.detail')
        </div>
        <div class="col-sm-12 col-md-3">
            @include('livewire.local.partials.clarifications')
        </div>
    </div>
</div>

<script src="{{asset('js/keypress.js')}}"></script>
{{-- <script src="{{asset('js/onscan.min.js')}}"></script> --}}

@include('livewire.local.scripts.shortcuts')
@include('livewire.local.scripts.events')
@include('livewire.local.scripts.general')
@include('livewire.local.scripts.scan')
