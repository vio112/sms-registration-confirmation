@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                
                    @if(session()->has('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="/register/confirm-sms/validate-code">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label for="code" class="col-md-4 control-label">Security Code</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Verify
                                </button>

                                <a id="resend-code" class="btn btn-link" href="#">
                                    Resend Code?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#resend-code').click(function(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/register/confirm-sms",
            type: 'POST',
            success: function(result){
                alert('success');
            }
        });
    });
</script>
@endsection