

<form method="POST" action="{{route('test.store')}}">
    @csrf 
    <input type="text" name="name">
    <input type="email"name="email">
    <input type="password"name="password">
    <button type="submit">Submit</button>
</form> 

<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<form method="POST" action="{{route('test.store')}}">
    @csrf 
    <input type="text" name="name">
    <input type="email"name="email">
    <input type="password"name="password">
    <button type="submit">Submit</button>
</form> 


<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Actions</th>
  </tr>
  @foreach($staffs as $staff)
</tr>
    <td>{{ $staff->id }}</td>
    <td>{{ $staff->name }}</td>
    <td>{{ $staff->email }}</td>
     <td>
        <a href="">Edit</a>
        <a href="{{ route('test.destroy',$staff) }}">Delete</a>
     <td>
  </tr>
  @endforeach
</table>