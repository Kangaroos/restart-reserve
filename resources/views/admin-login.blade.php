@extends('layouts.base')
@section('title', '后台登录')

@section('head')
@parent
<style type="text/css">
    body {
        background: #ffffff;
    }

    body > .grid {
        height: 100%;
    }

    #logo {
        width: 10em;
    }

    .column {
        max-width: 450px;
    }
</style>
@endsection
@section('body')
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui teal image header">
                <img id="logo" src="{{ asset('assets/images/logo.jpg') }}" class="image">
            </h2>
            <form class="ui large form">
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" placeholder="账号">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="密码">
                        </div>
                    </div>
                    <div class="ui fluid large teal submit button">登 录</div>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
@endsection

@section('end')
@parent
<script>
    $(document).ready(function() {
        $('.ui.form')
                .form({
                    fields: {
                        email: {
                            identifier  : 'email',
                            rules: [
                                {
                                    type   : 'empty',
                                    prompt : 'Please enter your e-mail'
                                },
                                {
                                    type   : 'email',
                                    prompt : 'Please enter a valid e-mail'
                                }
                            ]
                        },
                        password: {
                            identifier  : 'password',
                            rules: [
                                {
                                    type   : 'empty',
                                    prompt : 'Please enter your password'
                                },
                                {
                                    type   : 'length[6]',
                                    prompt : 'Your password must be at least 6 characters'
                                }
                            ]
                        }
                    }
                })
        ;
    })
    ;
</script>
@endsection