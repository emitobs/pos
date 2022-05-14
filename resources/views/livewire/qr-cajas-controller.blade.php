<div>
    <style>
        /*SPINNER*/
        .spinner {
            padding-top: 35vh;
            top: 0;
            left: 0px;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 3;
            position: absolute;
        }
    </style>
    <div id="iframeloading" class="spinner" wire:loading wire:target="check_code">
        <img src="https://mathiasmoyano.github.io/idea-Moyano/img/logo.png" height="120px;">
    </div>
    <div class="containercontacto">
        <h4>Ingresa tus datos.</h4>
        <form>
            <div class="form-row">
                <div class="col">
                    <label>Nombre*</label>
                    <input type="text" class="form-control " wire:model.lazy='name' placeholder="ingresa tu nombre">
                    @error('name') <span class=""
                        style="color: red; display:block; margin-top:10px;">{{$message}}</span>@enderror

                </div>
                <div class="col">
                    <label>Telefono*</label>
                    <input type="number" class="form-control " wire:model.lazy='phone'
                        placeholder="ingresa tu telefono">
                    @error('phone') <span class=""
                        style="color: red; display:block; margin-top:10px;">{{$message}}</span>@enderror
                </div>
                <div class="col">
                    <label>Codigo*</label>
                    <input type="text" class="form-control " wire:model.lazy='code' placeholder="ingresa tu codigo">
                    @error('code') <span class=""
                        style="color: red; display:block; margin-top:10px;">{{$message}}</span>@enderror
                </div>
            </div>
        </form>
        <li><button wire:click='check_code' class="btn btn-primary">Comprobar Suerte!</button></li>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        window.livewire.on('congratulations', data => {
            Swal.fire({
            title: 'Felicidades '+data.name+'!' ,
            html: 'Tu premio es '+data.award,
            width: 600,
            padding: '3em',
            color: '#7D7F0B',
            confirmButtonText: 'Obtener Premio!',
            confirmButtonColor: '#A7A862',
            showCancelButton: false,
            backdrop: `
            rgba(215,217,81,0.4)
                url("https://sweetalert2.github.io/images/nyan-cat.gif")
                left top
                no-repeat
            `
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('https://wa.me/59891713746?text=Hola,%20soy%20'+data.name+'%20y%20me%20gane%20'+data.award+',%20%20con%20el%20codigo:%20'+data.code+'.');
                }
            });
        });


        window.livewire.on('better-luck-next-time', data => {
            Swal.fire({
            title: 'Upss! :(',
            html: '<h2>Mas suerte la proxima, '+data.name+' (:!</h2>',
            width: 600,
            padding: '3em',
            color: '#000',
            confirmButtonText: 'Volver!',
            confirmButtonColor: '#b3a318',
            showCancelButton: false,
            backdrop: `
                rgba(0,0,0,0.8)
                url("https://sweetalert2.github.io/images/nyan-cat.gif")
                left top
                no-repeat
            `
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('qrcajas');
                }
            });
        });

        window.livewire.on('error-code', data => {
            Swal.fire({
            title: 'Eyy!!',
            html: data.message,
            width: 600,
            padding: '3em',
            color: '#000',
            confirmButtonText: 'Volver!',
            confirmButtonColor: '#b3a318',
            showCancelButton: false,
            backdrop: `
                rgba(255,0,0,0.8)
                url("https://sweetalert2.github.io/images/nyan-cat.gif")
                left top
                no-repeat
            `

            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('qrcajas');
                }
            })
        });
    });

</script>
