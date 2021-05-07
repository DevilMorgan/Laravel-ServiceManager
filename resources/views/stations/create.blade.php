@extends('layouts.app')

@section('content')

    @component('components.title', ['back_url' => route('stations.index')])
        {{__('messages.stations')}}
    @endcomponent

    <!-- END: Subheader -->
    <div class="m-content">

        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-plus"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            {{__('messages.new_station')}}
                        </h3>
                    </div>
                </div>
            </div>
            @include('stations.create_form')
        </div>

        <!--end::Portlet-->

    </div>
@stop
