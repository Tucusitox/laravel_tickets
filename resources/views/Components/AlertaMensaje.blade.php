<div class="alert {{$typeAlert ?? 'alert-success'}} {{$styleText ?? 'text-start'}} alert-dismissible fade show w-auto my-2" role="alert">
    <b>¡{{ $mensaje ?? 'nuevo mensaje' }}!</b>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
</div>

<style>
    a{cursor: pointer;}
</style>