Edit from for {{$staff->name}}
<form method="POST" action="{{route('test.update',$staff)}}">
    @csrf 
    <input type="text" name="name" value=" {{ $staff->name}}">
    <input type="email"name="email"value=" {{ $staff->email}}">
    <button type="submit">Update</button>
</form> 
