<div>
    <!-- Be present above all else. - Naval Ravikant -->
<h1>ALL USERS</h1>
<table border="1">
    <tr>
        <td>id</td>
    <td>name</td>
    <td>email</td>

    </tr>
    <tr>
    @foreach ($users as $user )
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>

    @endforeach

</tr>
</table>

</div>
