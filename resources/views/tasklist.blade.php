<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Serkan Erdinç">
    <title>Developer ToDo List</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        h1 {
            font-size: 200%;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
<div class="table-responsive">
    <h1>Developer ToDo List</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                @foreach ($users as $user)
                    <th scope="col">{{$user->name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $week=>$userList)
                <tr>
                    <th scope="row">{{$week}} Haftası</th>
                    @foreach ($users as $user)
                        <td>
                            @foreach ($userList[$user->id] as $task)
                                {{$task->task->name}} ({{$task->estimated_duration}} saat)<br>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
