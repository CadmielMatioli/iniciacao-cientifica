@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            @include('includes.flashalert')
                <div class="card">
                    <div class="card-header">Subscribe Messages</div>
                    <div class="card-body">
                        <form action="{{route('subscribe.mqtt')}}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label for="topic" class="form-label">Tópico<span class="form-required">*</span></label>
                                    <input type="text" id="topic" name="topic" class="form-control form-group">
                                    @if ($errors->has('topic'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('topic') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-secondary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
