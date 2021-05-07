<!--begin::Form-->
<form method="POST" action="{{route('stations.store')}}" class="m-form m-form--fit m-form--label-align-right">
    @csrf
    @include('stations._form')
</form>
<!--end::Form-->
