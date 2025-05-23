
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ticketit Installation</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <h1 style="text-align: center">{{ trans('ticketit::install.initial-setup') }}</h1>
  <form class="form-signin" action="{{url('/tickets-install') }}" method="post" style="max-width: 500px">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <h3 class="form-signin-heading">{{ trans('ticketit::install.master-template-file') }}</h3>
        <select id="master" name="master" class="form-control" required autofocus>
            @foreach($views_files_list as $name => $path)
                <option value="{{ $name }}">{{ $path }}</option>
            @endforeach
        </select>
        <br>
        <div class="form-group" id="other-path-group" style="display: none">
            <label for="other_path">{{ trans('ticketit::install.master-template-other-path') }}</label>
            <input type="text" id="other_path" name="other_path" class="form-control" />
            <span id="helpBlock" class="help-block">
                {{ trans('ticketit::install.master-template-other-path-ex') }}
            </span>
        </div>

        <h3 class="form-signin-heading">{{ trans('ticketit::install.admin-select') }}</h3>
        <select id="admin_id" name="admin_id" class="form-control" required autofocus>
            @foreach($users_list as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <span id="helpBlock" class="help-block">
            {{ trans('ticketit::install.admin-select-help-block') }}
        </span>
        <br>

        <div class="well small" style="border: 1px solid #ccc">
            @if(!empty($inactive_migrations))
                <b>{{ trans('ticketit::install.migrations-to-be-installed') }}</b>
                <ul>
                    @foreach($inactive_migrations as $mig)
                        <li>{{ $mig }}</li>
                    @endforeach
                </ul>
            @else
                <b>{{ trans('ticketit::install.all-tables-migrated') }}</b>
            @endif
        </div>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            {{ trans('ticketit::install.proceed') }}
        </button>
    </form>

</div> <!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $('#master').change(function() {
        opt = $(this).val();
        if (opt=="another") {
            $('#other-path-group').show();
        } else {
            $('#other-path-group').hide();
        }
    });
</script>
</body>
</html>
